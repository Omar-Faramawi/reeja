<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Utilities\Constants;

class ReportController extends Controller
{
    public function contractTypesIshaarsData($from = null, $to = null)
    {
        list($from, $to) = defaultDateRange(false, $from, $to);

        $temp_employees = ContractEmployee::tempWork()->select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
            ])
        ->whereBetween('created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')])
        ->groupBy('date')
        ->get()
        ->groupBy('date');

        $taqawel_employees = ContractEmployee::taqawel()->select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
            ])
        ->whereBetween('created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')])
        ->groupBy('date')
        ->get()
        ->groupBy('date');

        $hajj = ContractEmployee::tempInHajj()->select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
            ])
        ->whereBetween('created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')])
        ->groupBy('date')
        ->get()
        ->groupBy('date');

        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($from, $interval, $to);

        $morris_data = $record = [];
        foreach ($daterange as $date) {
            $record['date'] = $date->format('Y-m-d');
            $record['taqawel'] = isset($taqawel_employees[$date->format('Y-m-d')]) ? $taqawel_employees[$date->format('Y-m-d')][0]->count : 0;
            $record['temp_work'] = isset($temp_employees[$date->format('Y-m-d')]) ? $temp_employees[$date->format('Y-m-d')][0]->count : 0;
            $record['hajj'] = isset($hajj[$date->format('Y-m-d')]) ? $hajj[$date->format('Y-m-d')][0]->count : 0;
            $morris_data[] = $record;
        }

        return response()->json($morris_data);
    }

    public function contractTypesIshaars($from = null, $to = null)
    {
        // Dates as Carbon objects
        list($from, $to) = defaultDateRange(false, $from, $to);

        $partial = 'contract_types_ishaars_1';
        $title = trans('reports.ishaars_types_chart');
        $js_func = 'drawIshaarsLineChart';
        $charts_ids = '#ishaarsLineChart';

        // Dates as strings
        list($from, $to) = defaultDateRange(true, $from, $to);

        return view('admin.reports.reports_templates.index',
            compact('partial', 'from', 'to', 'title', 'js_func', 'charts_ids'));
    }

    public function topTenPrvdBenfActivitiesData($chartOrvalue = '4chart', $prvd_benf = 1, $from = null, $to = null)
    {
        // Dates as Carbon objects
        list($from, $to) = defaultDateRange(false, $from, $to);

        if ($chartOrvalue === '4chart') {
            // For initializing the chart
            $ishaarsObject = [];
            // Pie Chart Data (Top Activities) - Provider
            $top_ten_activities = ContractEmployee::select([
                DB::raw('COUNT(contract_employees.id) AS count'),
                'activities.name AS activity_name',
                'activities.id AS activity_id',
                'establishments.name AS est_name',
                'establishments.id AS est_id',
                'establishments.est_nitaq AS est_nitaq',
                'contract_type_id AS c_t_id'
                ])->join('contracts', 'contract_employees.contract_id', '=', 'contracts.id');
            if ($prvd_benf == Constants::SERVICETYPES['provider']) {
                $top_ten_activities = $top_ten_activities->establishmentProvider()
                ->join('establishments', function ($join) {
                    $join->on('contracts.provider_id', '=', 'establishments.id')->where('provider_type', '=',
                        Constants::USERTYPES['est']);
                });
            } else {
                $top_ten_activities = $top_ten_activities->establishmentBeneficial()
                ->join('establishments', function ($join) {
                    $join->on('contracts.benf_id', '=', 'establishments.id')->where('benf_type', '=',
                        Constants::USERTYPES['est']);
                });
            }


            $top_ten_activities = $top_ten_activities->leftJoin('activities',
                'establishments.activity_id', '=', 'activities.id')
            ->whereBetween('contract_employees.created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')])
            ->groupBy('activities.name')
            ->orderBy('count', 'DESC')
            ->take(10)
            ->get();

            foreach ($top_ten_activities as $key => $value) {
                $ishaarsObject[] =
                [
                'statusName'  => $value->activity_name,
                'statusValue' => $value->count,
                'sourceField' => $value->activity_id
                ];
            }

            return response()->json($ishaarsObject);
        } else {
            // Is for datatable (On Slice Click)
            if ($prvd_benf == Constants::SERVICETYPES['provider']) {
                $contracts = ContractEmployee::establishmentProviderWithActivity($chartOrvalue)
                ->whereBetween('created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')])
                ->get();
            } else {
                $contracts = ContractEmployee::establishmentBeneficialWithActivity($chartOrvalue)
                ->whereBetween('created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')])
                ->get();
            }

            $data = [];
            foreach ($contracts as $k => $con) {
                $data[] = [
                $con->id,
                $con->contract->establishment->name,
                $con->contract->establishment->activity->name,
                $con->contract->establishment->est_nitaq,
                Constants::serviceTypes(['file' => 'reports.labels'])[$prvd_benf],
                Constants::contractTypes(['file' => 'contract_setup'])[$con->contract->contract_type_id],
                ];
            }

            return response()->json(['data' => $data]);
        }
    }


    public function topTenPrvdBenfActivities($from = null, $to = null)
    {
        // Dates as Carbon objects
        list($from, $to) = defaultDateRange(false, $from, $to);
        $partial = 'providers_beneficials_activities';
        $title = trans('reports.top_ten_ishaars');
        $js_func = 'drawPieChart';
        $charts_ids = '#top_ten_activities_provider, #top_ten_activities_benef';

        // Dates as strings
        list($from, $to) = defaultDateRange(true, $from, $to);

        return view('admin.reports.reports_templates.index',
            compact('partial', 'from', 'to', 'title', 'js_func', 'charts_ids'));
    }


    public function activityIshaarsData($chartOrvalue = '4chart', $prvd_benf = 1, $from = null, $to = null)
    {
        // Dates as Carbon objects
        list($from, $to) = defaultDateRange(false, $from, $to);

        if ($chartOrvalue === '4chart') {
            // For initializing the chart
            $ishaarsObject = [];
            // Pie Chart Data (Top Activities) - Provider
            $top_ten_activities = ContractEmployee::select([
                DB::raw('COUNT(contract_employees.id) AS count'),
                'activities.name AS activity_name',
                'activities.id AS activity_id',
                'establishments.name AS est_name',
                'establishments.id AS est_id',
                'establishments.est_nitaq AS est_nitaq',
                'contract_type_id AS c_t_id'
                ])->join('contracts', 'contract_employees.contract_id', '=', 'contracts.id');
            if ($prvd_benf == Constants::SERVICETYPES['provider']) {
                $top_ten_activities = $top_ten_activities->establishmentProvider()
                ->join('establishments', function ($join) {
                    $join->on('contracts.provider_id', '=', 'establishments.id')->where('provider_type', '=',
                        Constants::USERTYPES['est']);
                });
            } else {
                $top_ten_activities = $top_ten_activities->establishmentBeneficial()
                ->join('establishments', function ($join) {
                    $join->on('contracts.benf_id', '=', 'establishments.id')->where('benf_type', '=',
                        Constants::USERTYPES['est']);
                });
            }


            $top_ten_activities = $top_ten_activities->leftJoin('activities',
                'establishments.activity_id', '=', 'activities.id')
            ->whereBetween('contract_employees.created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')])
            ->groupBy('activities.name')
            ->get();

            foreach ($top_ten_activities as $key => $value) {
                $ishaarsObject[] =
                [
                'statusName'  => $value->activity_name,
                'statusValue' => $value->count,
                'sourceField' => $value->activity_id
                ];
            }

            return response()->json($ishaarsObject);
        } else {
            // Is for datatable (On Slice Click)
            if ($prvd_benf == Constants::SERVICETYPES['provider']) {
                $contracts = ContractEmployee::establishmentProviderWithActivity($chartOrvalue)
                ->whereBetween('created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')])
                ->get();
            } else {
                $contracts = ContractEmployee::establishmentBeneficialWithActivity($chartOrvalue)
                ->whereBetween('created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')])
                ->get();
            }

            $data = [];
            foreach ($contracts as $k => $con) {
                $data[] = [
                $con->id,
                $con->contract->establishment->name,
                $con->contract->establishment->activity->name,
                $con->contract->establishment->est_nitaq,
                Constants::serviceTypes(['file' => 'reports.labels'])[$prvd_benf],
                Constants::contractTypes(['file' => 'contract_setup'])[$con->contract->contract_type_id],
                ];
            }

            return response()->json(['data' => $data]);
        }
    }


    public function activityIshaars($from = null, $to = null)
    {
        // Dates as Carbon objects
        list($from, $to) = defaultDateRange(false, $from, $to);
        $partial = 'activities_ishaars';
        $title = trans('reports.activities_chart_chart');
        $js_func = 'drawPieChart';
        $charts_ids = '#top_ten_activities_provider, #top_ten_activities_benef';

        // Dates as strings
        list($from, $to) = defaultDateRange(true, $from, $to);

        return view('admin.reports.reports_templates.index',
            compact('partial', 'from', 'to', 'title', 'js_func', 'charts_ids'));
    }

    public function jobsChart($from = null, $to = null)
    {
        list($from, $to) = defaultDateRange(false, $from, $to);

        $partial = 'jobs_chart';
        $title = trans('reports.jobs_chart_chart');
        $js_func = 'drawPieChart';
        $charts_ids = '#jobs_chart_chart';

        list($from, $to) = defaultDateRange(true, $from, $to);

        return view('admin.reports.reports_templates.index',
            compact('partial', 'from', 'to', 'title', 'charts_ids', 'js_func'));

    }

    public function jobsChartData($chartOrvalue = '4chart', $from = null, $to = null)
    {
        list($from, $to) = defaultDateRange(false, $from, $to);
        if ($chartOrvalue == '4chart') {
            // Contract Employees Jobs
            $jobs_chart = HRPool::select([
                DB::raw('COUNT(ad_jobs.id) AS count'),
                'ad_jobs.job_name as job_name',
                'ad_jobs.id as job_id',
                ])
            ->whereHas('contractEmployee', function ($q) use ($from, $to) {
                $q->whereBetween('contract_employees.created_at',
                    [$from->format('Y-m-d'), $to->format('Y-m-d')]);

            })
            ->join('ad_jobs', 'hr_pool.job_id', '=', 'ad_jobs.id')
            ->groupBy('job_name')
            ->orderBy('count', 'DESC')
            ->take(5)
            ->get();

            $ishaarsObject = [];
            foreach ($jobs_chart as $key => $value) {
                $ishaarsObject[] =
                [
                'statusName'  => $value->job_name,
                'statusValue' => $value->count,
                'sourceField' => $value->job_id
                ];
            }

            return response()->json($ishaarsObject);
        } else {
            $job_id = $chartOrvalue;

            $hr_pools = HRPool::where('job_id', $job_id)
            ->whereHas('contractEmployee', function ($q) use ($from, $to) {
                $q->whereBetween('created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')]);

            })->get();
            $jobs_chart_obj = [];
            foreach ($hr_pools as $hr_pool) {
                $jobs_chart_obj[] = [
                $hr_pool->id,
                $hr_pool->name,
                $hr_pool->job->job_name,
                $hr_pool->nationality->name,
                $hr_pool->id_number,
                ];
            }

            return response()->json(['data' => $jobs_chart_obj]);
        }
    }

    public function ishaarTypesGrouped($from = null, $to = null)
    {
        list($from, $to) = defaultDateRange(false, $from, $to);
        $js_func = 'drawPieChart';
        $partial = 'ishaar_types_groups';
        $charts_ids = '#ishaars_types_chart';
        $title = trans('reports.ishaars_types_grouped_chart');
        list($from, $to) = defaultDateRange(true, $from, $to);

        return view('admin.reports.reports_templates.index',
            compact('partial', 'from', 'to', 'title', 'charts_ids', 'js_func'));

    }

    public function ishaarTypesGroupedData($chartOrValue = '4chart', $from = null, $to = null)
    {
        list($from, $to) = defaultDateRange(false, $from, $to);

        // Ishaar Types grouped

        $ishaars_obj = [];

        if ($chartOrValue == '4chart') {
            $ishaars_obj[] = [
            'statusName'  => trans('reports.labels.taqawel'),
            'statusValue' => ContractEmployee::taqawel()->whereBetween('created_at',
                [$from->format('Y-m-d'), $to->format('Y-m-d')])->count(),
            'sourceField' => 'taqawel',
            ];
            $ishaars_obj[] = [
            'statusName'  => trans('reports.labels.temp_work'),
            'statusValue' => ContractEmployee::tempWork()->whereBetween('created_at',
                [$from->format('Y-m-d'), $to->format('Y-m-d')])->count(),
            'sourceField' => 'temp_work',
            ];
            $ishaars_obj[] = [
            'statusName'  => trans('reports.labels.hajj'),
            'statusValue' => ContractEmployee::tempInHajj()->whereBetween('created_at',
                [$from->format('Y-m-d'), $to->format('Y-m-d')])->count(),
            'sourceField' => 'hajj',
            ];

            return response()->json($ishaars_obj);
        } else {
            if ($chartOrValue == 'taqawel') {
                $data = [];
                $ishaars_obj = ContractEmployee::taqawel()->whereBetween('created_at',
                    [$from->format('Y-m-d'), $to->format('Y-m-d')])
                ->with('contract')->get();

                foreach ($ishaars_obj as $obj) {
                    $data[] = [
                    $obj->id,
                    $obj->contract->providername,
                    $obj->contract->benf_name,
                    trans('reports.labels.taqawel')
                    ];
                }
            } elseif ($chartOrValue == 'temp_work') {
                $ishaars_obj = ContractEmployee::tempWork()->whereBetween('created_at',
                    [$from->format('Y-m-d'), $to->format('Y-m-d')])
                ->with('contract')->get();
                foreach ($ishaars_obj as $obj) {
                    $data[] = [
                    $obj->id,
                    $obj->contract->providername,
                    $obj->contract->benf_name,
                    trans('reports.labels.temp_work')
                    ];
                }
            } elseif ($chartOrValue == 'hajj') {
                $ishaars_obj = ContractEmployee::tempInHajj()->whereBetween('created_at',
                    [$from->format('Y-m-d'), $to->format('Y-m-d')])
                ->with('contract')->get();
                foreach ($ishaars_obj as $obj) {
                    $data[] = [
                    $obj->id,
                    $obj->contract->providername,
                    $obj->contract->benf_name,
                    trans('reports.labels.hajj')
                    ];
                }
            }

            return response()->json(['data' => $data]);
        }
    }

    public function countriesIshaarsData($chartOrValue = '4chart', $from = null, $to = null)
    {
        list($from, $to) = defaultDateRange(false, $from, $to);

        if ($chartOrValue == '4chart') {
            // Contract Employees Jobs
            $countriesIshaars = HRPool::select([
                DB::raw('COUNT(nationalities.id) AS count'),
                'nationalities.name as nationality_name',
                'nationalities.id as nationality_id',
                'hr_pool.id as hrpoolId'
                ])
            ->whereHas('contractEmployee', function ($q) use ($from, $to) {
                $q->whereBetween('created_at',
                    [$from->format('Y-m-d'), $to->format('Y-m-d')]);

            })
            ->join('nationalities', 'hr_pool.nationality_id', '=', 'nationalities.id')
            ->groupBy('nationality_name')
            ->take(5)
            ->get();

            $data = [];
            foreach ($countriesIshaars as $obj) {
                $data[] = [
                'statusName'  => $obj->nationality->name,
                'statusValue' => $obj->count,
                'sourceField' => $obj->nationality_id,
                ];
            }

            return response()->json($data);
        } else {
            $nationality_id = $chartOrValue;

            $countriesIshaars_obj = [];
            $hr_pools = HRPool::where('nationality_id', $nationality_id)
            ->whereHas('contractEmployee', function ($q) use ($from, $to) {
                $q->whereBetween('created_at', [$from->format('Y-m-d'), $to->format('Y-m-d')]);
            })->with('contractEmployee')
            ->get();
            foreach ($hr_pools as $key => $value) {
                $countriesIshaars_obj[] = [
                $value->id,
                $value->name,
                $value->job->job_name,
                $value->nationality->name,
                Constants::contractTypes(['file' => 'contract_setup'])[$value->contractEmployee->contract->contract_type_id]
                ];
            }

            return response()->json(['data' => $countriesIshaars_obj]);
        }
    }

    public function countriesIshaars($from = null, $to = null)
    {
        list($from, $to) = defaultDateRange(false, $from, $to);
        $partial = 'ishaar_countries_groups';
        $title = trans('reports.ishaars_country_chart');
        $js_func = 'drawPieChart';
        $charts_ids = '#ishaars_country_chart';
        list($from, $to) = defaultDateRange(true, $from, $to);

        return view('admin.reports.reports_templates.index',
            compact('partial', 'from', 'to', 'title', 'js_func', 'charts_ids'));
    }

    public function employeesBenfPeriod()
    {
     $over6Months = [];
     $minMonthsPeriod = 6;
     $data = ContractEmployee::all();
     $interval = new \DateInterval('P1M');
     $dates = [];
     foreach ($data as $key => $emp) {
        $start_end_dates = [];
        $start_date = Carbon::createFromFormat('Y-m-d', $emp->start_date);
        $end_date = Carbon::createFromFormat('Y-m-d', $emp->end_date);
        $months = $end_date->diffInMonths($start_date);
        $daterange = new \DatePeriod($start_date, $interval, $end_date);

        foreach ($daterange as $date) {
            $dates[$emp->benfIdPattern()]['dates'][] = $date->format("Y-m");
            $dates[$emp->benfIdPattern()]['info']['emp_name'] = $emp->hrPool->name;
            $dates[$emp->benfIdPattern()]['info']['benf_name'] = $emp->contract->benf_name;
            $dates[$emp->benfIdPattern()]['dates'] = array_unique($dates[$emp->benfIdPattern()]['dates']);
        }

        uksort($dates, function ($a, $b) {
            global $array;

            return strcmp($array[$a]['db'], $array[$b]['db']);
        });
    }

    $conseqMonths = 0;
    foreach ($dates as $key => $date) {
        if(isset($date['dates'])) {
            foreach ($date['dates'] as $k => $month) {
                if (!isset($currentMonth)) {
                    $currentMonth = Carbon::createFromFormat('Y-m', $month);
                }
                $nextMonth = $currentMonth->addMonth();
                if (in_array($nextMonth->format('Y-m'), $date['dates'])) {
                    $conseqMonths++;
                    if ($conseqMonths >= $minMonthsPeriod) {
                     $over6Months[$key]['info']['emp_name'] = $date['info']['emp_name'];
                     $over6Months[$key]['info']['benf_name'] = $date['info']['benf_name'];
                     if(!isset($over6Months[$key]['period'])) {
                        $over6Months[$key]['period'] = $conseqMonths;
                    }else {
                        $over6Months[$key]['period'] = $over6Months[$key]['period'] + 1;
                    }
                    $currentMonth = $nextMonth;
                }
            } 
            else {
                unset($currentMonth);
                $conseqMonths = 0;
            }
        }
    }
}

$partial = 'labor_beneficial_period';
$title = 'reports.labor_benf_period';

return view('admin.reports.reports_templates.index',
    compact('partial', 'title', 'over6Months'));
}
}
