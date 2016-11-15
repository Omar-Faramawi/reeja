<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Utilities\Constants;

class LaborerWithMultipleIshaarsController extends Controller
{
    public function index()
    {

        $data = DB::table('contract_employees')
                  ->leftJoin('contract_employees as emp2', function($join){
                    $join->on('contract_employees.id_number', '=', 'emp2.id_number')
                         ->on('emp2.id', '!=', 'contract_employees.id')
                         ->on(function($j){
                            $j->on(function($jn1){
                                $jn1->on('contract_employees.start_date', '>=', 'emp2.start_date')
                                    ->on('contract_employees.start_date', '<=', 'emp2.end_date');
                            })->orOn(function($jn2){
                                $jn2->on('contract_employees.end_date', '>=', 'emp2.start_date')
                                    ->on('contract_employees.end_date', '<=', 'emp2.end_date');
                            });
                        });
                    })->leftJoin('hr_pool', 'contract_employees.id_number', '=', 'hr_pool.id')
                      ->leftJoin('establishments', function($jn3){
                            $jn3->on('hr_pool.provider_id', '=', 'establishments.id')
                                ->where('hr_pool.provider_type', '=', '3');
                      })->leftJoin('indviduals', function($jn3){
                            $jn3->on('hr_pool.provider_id', '=', 'indviduals.id')
                                ->where('hr_pool.provider_type', '=', '4')
                                ->orWhere('hr_pool.provider_type', '=', '5');
                      })->leftJoin('governments', function($jn3){
                            $jn3->on('hr_pool.provider_id', '=', 'governments.id')
                                ->where('hr_pool.provider_type', '=', '2');
                      })
                      ->select('hr_pool.provider_type', 'hr_pool.name', 'hr_pool.id_number as nid', 'contract_employees.id_number', 'establishments.name as est_name', 'indviduals.name as ind_name', 'governments.name as gov_name')
                      ->groupBy('contract_employees.id_number')
                      ->havingRaw('COUNT(emp2.id)>0')
                      ->get();

        return view('admin.reports.laborer-wiht-multiple-ishaar.index', compact('data'));
    }


    /**
     * Get The employees for the same Benef for 6 Months
     */

    public function sameBenfEmployees()
    {
        $data = DB::select("select `contract_employees`.`id` AS `id`,`hr_pool`.`id_number` AS `id_number`,(to_days(`contract_employees`.`end_date`) - to_days(`contract_employees`.`start_date`)) AS `period`,`establishments`.`name` AS `est_name`,`indviduals`.`name` AS `ind_name`,`governments`.`name` AS `gov_name`,`hr_pool`.`name` AS `name` from ((((((`contract_employees` join `contract_employees` `emp2` on(((((to_days(`emp2`.`start_date`) - to_days(`contract_employees`.`end_date`)) = 1) or ((to_days(`contract_employees`.`start_date`) - to_days(`emp2`.`end_date`)) = 1)) and (`contract_employees`.`id_number` = `emp2`.`id_number`) and (`contract_employees`.`contract_id` = `emp2`.`contract_id`) and `contract_employees`.`id_number` in (select `contract_employees`.`id_number` from `contract_employees` group by `contract_employees`.`id_number` having (sum((to_days(`contract_employees`.`end_date`) - to_days(`contract_employees`.`start_date`))) >= 179))))) join `contracts` on((`contract_employees`.`contract_id` = `contracts`.`id`))) left join `establishments` on(((`contracts`.`benf_id` = `establishments`.`id`) and (`contracts`.`benf_type` = 3)))) left join `indviduals` on((((`contracts`.`benf_id` = `indviduals`.`id`) and (`contracts`.`benf_type` = 4)) or (`contracts`.`benf_type` = 5)))) left join `governments` on(((`contracts`.`benf_id` = `governments`.`id`) and (`contracts`.`benf_type` = 2)))) left join `hr_pool` on((`contract_employees`.`id_number` = `hr_pool`.`id`))) union (select `contract_employees`.`id` AS `id`,`hr_pool`.`id_number` AS `id_number`,(to_days(`contract_employees`.`end_date`) - to_days(`contract_employees`.`start_date`)) AS `period`,`establishments`.`name` AS `est_name`,`indviduals`.`name` AS `ind_name`,`governments`.`name` AS `gov_name`,`hr_pool`.`name` AS `name` from (((((`contract_employees` join `contracts` on((`contract_employees`.`contract_id` = `contracts`.`id`))) left join `establishments` on(((`contracts`.`benf_id` = `establishments`.`id`) and (`contracts`.`benf_type` = 3)))) left join `indviduals` on((((`contracts`.`benf_id` = `indviduals`.`id`) and (`contracts`.`benf_type` = 4)) or (`contracts`.`benf_type` = 5)))) left join `governments` on(((`contracts`.`benf_id` = `governments`.`id`) and (`contracts`.`benf_type` = 2)))) left join `hr_pool` on((`contract_employees`.`id_number` = `hr_pool`.`id`))) where ((to_days(`contract_employees`.`end_date`) - to_days(`contract_employees`.`start_date`)) >= 180))");
       
        return view('admin.reports.laborer-wiht-Same-Benf.index', compact('data'));
    }
}
