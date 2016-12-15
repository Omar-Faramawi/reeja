<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use DateTime;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\IshaarSetupsRequest;
use Tamkeen\Ajeer\Http\Requests\UpdateTaqawelIshaarSetupRequest;
use Tamkeen\Ajeer\Models\Bundle;
use Tamkeen\Ajeer\Models\IshaarJob;
use Tamkeen\Ajeer\Models\IshaarSetup;
use Tamkeen\Ajeer\Models\IshaarType;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\NationalityForJob;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Utilities\Constants;
use Vinkla\Hashids\Facades\Hashids;

class IshaarSetupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = IshaarSetup::tempWork()->latest()->paginate(20);

        return view('admin.ishaars.setups.lists', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::pluck('name', 'id')->toArray();
        $ishaarTypes = IshaarType::pluck('name', 'id')->toArray();
        $jobs = Job::pluck('job_name', 'id')->toArray();
        $nationalities = Nationality::pluck('name', 'id')->toArray();

        return view('admin.ishaars.setups.edit', compact('regions', 'ishaarTypes', 'jobs', 'nationalities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IshaarSetupsRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function store(IshaarSetupsRequest $request)
    {
        $data = array_except($request->only(array_keys($request->rules())), ['regions', 'job', 'nationalities']);
        if(!empty($data['period_start_date']) && !empty($data['period_end_date'])){
            $startDate = explode("-", $data['period_start_date']);
            $gerogorianStart = Hijri2Greg(intval($startDate[2]), intval($startDate[1]), intval($startDate[0]));
            $gregStartDate = new DateTime();
            $gregStartDate->setDate($gerogorianStart['year'], $gerogorianStart['month'], $gerogorianStart['day']);
            $data['period_start_date'] = $gregStartDate->format('Y-m-d');

            $endDate = explode("-", $data['period_end_date']);
            $gerogorianEnd = Hijri2Greg(intval($endDate[2]), intval($endDate[1]), intval($endDate[0]));
            $gregEndDate = new DateTime();
            $gregEndDate->setDate($gerogorianEnd['year'], $gerogorianEnd['month'], $gerogorianEnd['day']);
            $data['period_end_date'] = $gregEndDate->format('Y-m-d');
        }
        $setup = IshaarSetup::create($data);
        $setup->regions()->attach($request->regions);
        $jobs = $request->job;
        foreach($jobs as $one_job) {
            $ishaarJob = IshaarJob::create([
                'ishaar_setup_id' => $setup->id,
                'job_id'          => $one_job,
            ]);
            $job_nationalities= explode(',',$request->nationalities[$one_job]);
            if (!empty($request->nationalities[$one_job])) {
                foreach($job_nationalities as $nationality_id) {
                    if(is_numeric($nationality_id))
                    $ishaarJob->nationalities()->save(new NationalityForJob(['nationality_id' => $nationality_id]));
                }
            }
        }

        return trans('ishaar_setup.added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = IshaarSetup::byId($id)->with('regions', 'jobs', 'ishaarjobs')->firstOrFail();
        if (!empty($data->period_start_date) && $data->period_start_date != "0000-00-00"
            && !empty($data->period_end_date) && $data->period_end_date != "0000-00-00"){
            $startDate = explode('-', $data->period_start_date);
            $endDate = explode('-', $data->period_end_date);

            $gregStartDate = Greg2Hijri($startDate[2], $startDate[1], $startDate[0]);
            $gregEndDate = Greg2Hijri($endDate[2], $endDate[1], $endDate[0]);

            $gregorianStartDate = new DateTime();
            $gregorianStartDate->setDate($gregStartDate['year'], $gregStartDate['month'], $gregStartDate['day']);
            $readableStartDate = $gregorianStartDate->format('Y-m-d');

            $gregorianEndDate = new DateTime();
            $gregorianEndDate->setDate($gregEndDate['year'], $gregEndDate['month'], $gregEndDate['day']);
            $readableEndDate = $gregorianEndDate->format('Y-m-d');
        }
        
        $regions = Region::pluck('name', 'id')->toArray();
        $ishaarTypes = IshaarType::pluck('name', 'id')->toArray();
        $jobs = Job::pluck('job_name', 'id')->toArray();
        $nationalities = Nationality::pluck('name', 'id')->toArray();
        $selectedJob = $data->jobs()->select('ad_jobs.id')->lists('id')->toArray();
        $selected_nationalities = [];
        if (!empty($selectedJob)) {
            foreach ($selectedJob as $one_job) {
                $this_job = $data->ishaarjobs()->where('job_id', $one_job)->first()->id;
                $selected_nationalities[$one_job] = NationalityForJob::where('ishaar_job_id',
                    $this_job)->select('nationality_id')->lists('nationality_id')->toArray();
            }
        }
        return view('admin.ishaars.setups.edit',
            compact('data', 'regions', 'ishaarTypes', 'jobs', 'selected_nationalities',
                'nationalities', 'readableStartDate', 'readableEndDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IshaarSetupsRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(IshaarSetupsRequest $request, $id)
    {
        $data = array_except($request->only(array_keys($request->rules())), ['regions', 'job', 'nationalities']);
        if(!empty($data['period_start_date']) && !empty($data['period_end_date'])){
            $startDate = explode("-", $data['period_start_date']);
            $gerogorianStart = Hijri2Greg(intval($startDate[2]), intval($startDate[1]), intval($startDate[0]));
            $gregStartDate = new DateTime();
            $gregStartDate->setDate($gerogorianStart['year'], $gerogorianStart['month'], $gerogorianStart['day']);
            $data['period_start_date'] = $gregStartDate->format('Y-m-d');

            $endDate = explode("-", $data['period_end_date']);
            $gerogorianEnd = Hijri2Greg(intval($endDate[2]), intval($endDate[1]), intval($endDate[0]));
            $gregEndDate = new DateTime();
            $gregEndDate->setDate($gerogorianEnd['year'], $gerogorianEnd['month'], $gerogorianEnd['day']);
            $data['period_end_date'] = $gregEndDate->format('Y-m-d');
        }
        $setup = IshaarSetup::byId($id)->with(['jobs', 'ishaarjobs'])->firstOrFail();
        $setup->update($data);
        if ($setup->id != 3) {
            $setup->regions()->sync($request->regions);
        }
        $nations = $setup->ishaarjobs()->with('nationalities')->get();
        foreach ($nations as $nation) {
            $nation->nationalities()->delete();
            $nation->delete();
        }

        foreach($request->job as $one_job) {
            $ishaarJob = IshaarJob::create([
                'ishaar_setup_id' => $setup->id,
                'job_id'          => $one_job,
            ]);

            if (!empty($request->nationalities[$one_job])) {
                $nationals= explode(',', $request->nationalities[$one_job]);
                foreach($nationals as $nationality_id) {
                    if(is_numeric($nationality_id))
                    $ishaarJob->nationalities()->save(new NationalityForJob(['nationality_id' => $nationality_id]));
                }
            }
        }
        

        return trans('ishaar_setup.updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*
        $setup = IshaarSetup::byId($id)->with('regions', 'jobs')->firstOrFail();
        if (count($setup->regions)) {
            return response()->json(['error' => trans('ishaar_setup.error_delete_regions')], 422);
        }
        $setup->delete();
        
        return trans('ishaar_setup.deleted');
        */
    }

    public function taqawelIshaarManagement()
    {
        $taqawel_free = IshaarSetup::firstOrCreate(['ishaar_type_id' => Constants::CONTRACTTYPES['taqawel_free']]);
        $taqawel_paid = IshaarSetup::firstOrCreate(['ishaar_type_id' => Constants::CONTRACTTYPES['taqawel_paid']]);

        return view('admin.ishaars.taqawel_setup.edit', compact('taqawel_free', 'taqawel_paid'));
    }

    public function updateTaqawelIshaarManagement(UpdateTaqawelIshaarSetupRequest $request, $id)
    {
        $data = $request->only(array_keys($request->rules()));

        if (request()->get('ishaar_type_name') == 'taqawel') {
            IshaarSetup::whereIn('id', [1, 2])->update($data);
        } else {
            IshaarSetup::byId($id)->update($data);
            if (request()->get('ishaar_type_name') == 'taqawel_paid') {
                $amount = request()->get('trial_ishaar_num');
                Bundle::find(1)->update(['min_of_num_ishaar' => '1', 'max_of_num_ishaar' => $amount]);
            }
        }

        return trans('ishaar_setup.updated');

    }
}
