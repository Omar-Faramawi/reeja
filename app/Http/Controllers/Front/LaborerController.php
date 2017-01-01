<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Auth;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Http\Requests\LaborerRequest;
use Tamkeen\Ajeer\Http\Requests\PublishLaborerRequest;
use Tamkeen\Platform\NIC\Repositories\Foreigners\ForeignersRepository;
use Tamkeen\Platform\NIC\Repositories\Foreigners\ForeignerDataNotFoundException;
use Tamkeen\Platform\Model\Common\HijriDate;
use Tamkeen\Platform\Model\Common\GregorianDate;
use Tamkeen\Platform\Model\NIC\IdNumber;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository;

class LaborerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MolDataRepository $mol)
    {
        if (request()->ajax()) {
            $data    = HRPool::with('nationality', 'job')->byMe()->notMe()->notChecked();
            $columns = request()->input('columns');

            if (request()->input('id')) {
                $data->where('id', request()->input('id'));
            }
            if (request()->input('name')) {
                $data->where('name', 'like', '%' . request()->input('name') . '%');
            }
            if (request()->input('id_number')) {
                $data->where('id_number', request()->input('id_number'));
            }
            if (request()->input('nationality')) {
                $data->where('hr_pool.nationality_id', intval(request()->input('nationality')));
            }
            if (request()->input('job')) {
                $data->where('hr_pool.job_id', intval(request()->input('job')));
            }
            if (request()->input('age')) {
                $data->where('age', request()->input('age'));
            }
            if (request()->input('religion')) {
                $data->where('religion', request()->input('religion'));
            }
            if (request()->input('gender') || request()->input('gender') === '0') {
                $data->where('gender', request()->input('gender'));
            }

            $buttons   = [];
            $total_count = ($data->count()) ? $data->count() : 1;

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons, true);
        }
        
        $jobs = Job::pluck('job_name', 'id');
        $nationalities = Nationality::pluck('name', 'id');

        return view('front.laborer.index', compact('jobs', 'nationalities'));
    }

    /**
     * @param                      $id
     * @param ForeignersRepository $nic
     *
     * @return string
     */
    public function getLaborer($id, ForeignersRepository $nic)
    {
        try {
            $laborer = $nic->fetchForeigner(IdNumber::fromString($id),
                IdNumber::fromInt(config('nic.operatorId')));
            if (session('auth.type') == 'mol' || session('auth.type') == '3') {

                if ($laborer->getSponsor()->getIdNumber()->__toString() == (string)session('selected_establishment.id_number')) {
                    if($laborer->getStatus()->getPersonStatus()->getCode() != 1)
                    {
                        return 'false2';
                    }else{
                        return serialize($laborer);
                    }
                } else {
                    return 'false';
                }

            } elseif (session('auth.type') == '4') {
                if ($laborer->getSponsor()->getIdNumber()->__toString() == \Auth::user()->national_id) {
                    if($laborer->getStatus()->getPersonStatus()->getCode() != 1)
                    {
                        return 'false2';
                    }else{
                        return serialize($laborer);
                    }
                } else {
                    return 'false';
                }
            }
        } catch (ForeignerDataNotFoundException $e) {
            return 'false';
        }
    }

    /**
     * @param LaborerRequest       $request
     * @param ForeignersRepository $nic
     *
     * @return mixed
     */
    public function postLaborer(LaborerRequest $request, ForeignersRepository $nic)
    {
        $data = $request->only(array_keys($request->rules()));

        $laborer = $this->getLaborer($request->id_number, $nic);

        if ($laborer == 'false') {
            return response()->json(["errors" => trans('add_laborer.error')], 422);
        }

        $laborer       = unserialize($laborer);
        $dateString    = $laborer->getBirthDate()->getGregorianDate()->__toString();
        $splittedArray = explode('-', $dateString);
        $currentYear   = date("Y");
        $age           = intval($currentYear) - intval($splittedArray[0]);

        $HRPool = new HRPool();

        $nationality = Nationality::where('name', $laborer->nationality->__toString())->orWhere('eng_name',
            $laborer->nationality->__toString())->get()->first();
        if ($nationality !== null) {
            $HRPool->nationality_id = $nationality->id;
        }

        if (session('auth.type') == 'mol') {
            $provider_type = '3';
        } else {
            $provider_type = session('auth.type');
        }

        $HRPool->gender        = ($laborer->gender->__toString() == '2' ? '0' : '1');
        $HRPool->age           = $age;
        $HRPool->birth_date    = $laborer->getBirthDate()->getHijriDate();
        $HRPool->id_number     = $request->id_number;
        $HRPool->chk           = 0;
        $HRPool->name          = $laborer->getFullName()->__toString();
        if (session()->has('selected_establishment')) {
            $HRPool->provider_id = session('selected_establishment.id');
        } else {
            $HRPool->provider_id = \Auth::user()->id_no;
        }
        $HRPool->provider_type = $provider_type;
        //$HRPool->job_id        = 1; /* To do : get this value from NIC */
        $HRPool->religion      = 1; /* To do : get this value from NIC */

        $HRPool->save();

        return trans('add_laborer.laboreradded');
    }

    /**
     * @param PublishLaborerRequest $request
     *
     * @return mixed
     */
    public function save(PublishLaborerRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));
        if(!empty($data['enddate']) && !empty($data['startdate']) && ($data['enddate'] < $data['startdate'])){
            return Response::json([
                'startdate' => trans('add_laborer.enddate_before_start_date')
            ], 422);
        }
        foreach ($data['id'] as $key) {
            $hrpool                  = HRPool::find(intval($key));
            $hrpool->chk             = '1';
            if (!empty($data['startdate'])) {
                $hrpool->work_start_date = $data['startdate'];
            }
            if (!empty($data['enddate'])) {
                $hrpool->work_end_date = $data['enddate'];
            }
            $hrpool->save();
        }

        return trans('add_laborer.updated');
    }
}
