<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Illuminate\Http\Request;
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
            $data    = HRPool::with('nationality', 'job')->byMe()->notChecked();
            $columns = request()->input('columns');

            if (request()->input('id')) {
                $data = $data->where('id', request()->input('id'));
            }
            if (request()->input('name')) {
                $data = $data->where('name', 'like', '%' . request()->input('name') . '%');
            }
            if (request()->input('id_number')) {
                $data = $data->where('id_number', request()->input('id_number'));
            }
            if (request()->input('nationality')) {
                $nationality = Nationality::where('name', 'like',
                    '%' . request()->input('nationality') . '%')->get()->first();
                if ($nationality !== null) {
                    $data = $data->where('hr_pool.nationality_id', $nationality->id);
                }
            }
            if (request()->input('job')) {
                $job = Job::where('job_name', 'like', '%' . request()->input('job') . '%')->get()->first();
                if ($job !== null) {
                    $data = $data->where('hr_pool.job_id', $job->id);
                }
            }
            if (request()->input('age')) {
                $data = $data->where('age', request()->input('age'));
            }
            if (request()->input('religion')) {
                $data = $data->where('religion', request()->input('religion'));
            }
            if (request()->input('gender')) {
                $data = $data->where('gender', request()->input('gender'));
            }

            $buttons   = ['view' => [], 'edit' => []];
            $extraHtml = ["column" => [], "html" => []];

            $total_count = ($data->count()) ? $data->count() : 1;

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons, true, $extraHtml);
        }
        
        return view('front.laborer.index');
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
                    return serialize($laborer);
                } else {
                    return 'false';
                }

            } elseif (session('auth.type') == '4') {
                if ($laborer->getSponsor()->getIdNumber()->__toString() == (string)session('user.national_id')) {
                    return serialize($laborer);
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

        $HRPool->gender        = $laborer->gender->__toString();
        //$HRPool->age           = $age;
        $HRPool->id_number     = $request->id_number;
        $HRPool->chk           = 0;
        $HRPool->name          = $laborer->getFullName()->__toString();
        $HRPool->provider_id   = session('selected_establishment.id');
        $HRPool->provider_type = $provider_type;
        $HRPool->job_id        = 1; /* To do : get this value from NIC */
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
        foreach ($data['id'] as $key) {
            $hrpool                  = HRPool::find(intval($key));
            $hrpool->chk             = '1';
            $hrpool->work_start_date = $data['startdate'];
            $hrpool->work_end_date   = $data['enddate'];
            $hrpool->save();
        }

        return trans('add_laborer.updated');
    }
}
