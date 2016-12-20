<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Region;


/**
 * Class ReceivedContractsController
 * @package Tamkeen\Ajeer\Http\Controllers\Front
 */
class ContractEmployeesController extends Controller
{

    /**
     * @return mixed
     *
     */
    public function index()
    {
        if (request()->ajax()) {

            $query = HRPool::with('region', 'nationality', 'job');
            $total_count = ($query->ByMe()->count()) ? $query->ByMe()->count() : 1;
            $columns = request()->input('columns');

            $inputs = request()->only([
                'id_number',
                "nationality_id",
                "gender",
                "religion",
            ]);

            foreach ($inputs as $key => $input) {
                if (request()->input($key) != '') {
                    $query->where($key, $input);
                }
            }

            if (request()->input('name') != '') {
                $query->where('name', 'LIKE', '%' . request()->input('name') . '%');
            }

            if ($age = request()->input('age') != '') {
                $to = Carbon::now()->subYears($age);
                $from = Carbon::now()->subYears($age)->startOfYear();

                $query->whereBetween('birth_date', [$from, $to]);
            }


            $buttons = [];
            $buttons['view'] = [
                'text' => trans('temp_job.add'),
                'css_class' => 'blue select_emp',
                'url' => '#'
            ];


            return dynamicAjaxPaginate($query, $columns, $total_count, $buttons, true);
        }
    }


    /**
     * @return mixed
     *
     */
    public function contractEmployees($contract_id)
    {
        if (request()->ajax()) {

            $query = HRPool::whereHas('contractEmployee', function ($query) use ($contract_id) {
                $query->where('contract_id', '=', $contract_id);

                if (request()->input('name') != '') {
                    $query->where('name', 'LIKE', '%' . request()->input('name') . '%');
                }

                if (request()->input('nationality') != '') {
                    $query->where('nationality_id', request()->input('nationality'));
                }

                if (request()->input('gender') != '' || request()->input('gender') === '0') {
                    $query->where('gender', request()->input('gender'));
                }

                if (request()->input('religion') != '') {
                    $query->where('religion', request()->input('religion'));
                }

                if ($age = request()->input('age') != '') {
                    $to = Carbon::now()->subYears($age);
                    $from = Carbon::now()->subYears($age)->startOfYear();

                    $query->whereBetween('birth_date', [$from, $to]);
                }

            });

            $total_count = ($query->count()) ? $query->count() : 1;
            $columns = request()->input('columns');

            $buttons = [
                'view' => [
                    'text' => trans('temp_job.add'),
                    'css_class' => 'blue select_emp',
                    'url' => '#'
                ]
            ];

            return dynamicAjaxPaginate($query, $columns, $total_count, $buttons, true);
        }
    }


}
