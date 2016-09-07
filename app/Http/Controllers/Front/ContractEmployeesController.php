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

            $query       = HRPool::with('region', 'nationality', 'job');
            $total_count = $query->ByMe()->count();
            $columns     = request()->input('columns');

            $inputs = request()->only([
                'id_number',
                "nationality_id",
                "gender",
                "religion",
            ]);

            foreach ($inputs as $key => $input) {
                if (request()->input($key) != '') {
                    $query = $query->where($key, $input);
                }
            }

            if (request()->input('name') != '') {
                $query->where('name', 'LIKE', '%' . request()->input('name') . '%');
            }

            if (request()->input('nationality') != '') {
                $query = $query->where('nationality_id', request()->input('nationality'));
            }

            if (request()->input('gender') != '') {
                $query = $query->where('gender', request()->input('gender'));
            }

            if (request()->input('religion') != '') {
                $query = $query->where('religion', request()->input('religion'));
            }

            if ($age = request()->input('age') != '') {
                $to   = Carbon::now()->subYears($age);
                $from = Carbon::now()->subYears($age)->startOfYear();

                $query = $query->whereBetween('birth_date', [$from, $to]);
            }

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
