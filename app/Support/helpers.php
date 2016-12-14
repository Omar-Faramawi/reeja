<?php

use Carbon\Carbon;
use Tamkeen\Ajeer\Utilities\Constants;
use Tamkeen\Platform\Billing\BillingUtils;

if (!function_exists('sortDropdownByKey')) {

    /**
     * Sort the passed array with first key and last key
     * this method take the array and strip out the first key and last key from it
     * then append the first key and value at array start
     * and prepend the last key and value at the array end
     *
     * @param array $array
     * @param       $firstOrderKey | integer
     * @param       $lastOrderKey | integer
     *
     * @return array
     * @throws InvalidArgumentException
     */
    function sortDropDownByKey(array $array, $firstOrderKey, $lastOrderKey)
    {

        if (!isset($array[$firstOrderKey]) || !isset($array[$lastOrderKey])) {
            return $array;
        }

        $sortedArray = array_where($array,
            function ($key, $value) use ($firstOrderKey, $lastOrderKey) {
                if ($firstOrderKey !== $key && $lastOrderKey !== $key) {
                    return $value;
                }
            });

        return [$firstOrderKey => $array[$firstOrderKey]] + $sortedArray + [$lastOrderKey => $array[$lastOrderKey]];
    }
}

if (!function_exists('dynamicAjaxPaginate')) {

    /**
     * Paginate datatables
     *
     * @param       $data
     * @param       $columns
     * @param       $total_count
     * @param       $buttons
     * @param bool $checkbox
     * @param array $html
     *
     * @return mixed
     */
    function dynamicAjaxPaginate(
        $data,
        $columns,
        $total_count,
        $buttons,
        $checkbox = false,
        $html = []
    ) {
        $length = request()->input('length');
        $start  = request()->input('start');
        if (!empty(request()->input('order'))) {
            $orderBy = $columns[request()->input('order')[0]['column']]['name'];
            if ($orderBy == 'check') {
                $orderBy = 'id';
            }
            $order = request()->input('order')[0]['dir'];
            if (Route::getCurrentRoute()->getPath() != "taqawel/notices/{notices}") {
                $data = $data->orderBy($orderBy, $order);
            }
        }

        if (Route::getCurrentRoute()->getPath() == "taqawel/notices/{notices}") {
            $records['data'] = $data->slice($start, $start+$length);
            $records['data'] = $records['data']->values();
        } else {
            $records['data'] = $data->skip($start)->take($length)->get();  
        }
        $records["iTotalRecords"] = $total_count;

        $records["iTotalDisplayRecords"] = $total_count;

        $records["customActionStatus"]  = "OK";
        $records["customActionMessage"] = trans('labels.customActionMessage');

        $records["draw"] = intval(request()->input('draw'));

        for ($i = 0; $i < count($records['data']); $i++) {
            if (count($buttons) == 0 && $checkbox) {
                $records['data'][$i]['check'] = '<input type="checkbox" name="id[]" value="' . $records['data'][$i]['id'] . '" class="select-checkbox">';
            }
            
            foreach ($buttons as $key => $button) {
                $id  = !empty($button['id']) ? $button['id'] : 'id';
                $url = !empty($button['url']) ? $button['url'] : request()->url();

                if (!empty($button['uri'])) {
                    $uri = url($url . "/" . $records['data'][$i][$id] . "/" . $button['uri']);
                } else {
                    $uri = url($url . "/" . $records['data'][$i][$id]);
                }

                $css_class = !empty($button['css_class']) ? $button['css_class'] : "btn";
                $text = !empty($button['text']) ? $button['text'] : trans('labels.' . $key);

                if ($checkbox) {
                    $records['data'][$i]['check'] = '<input type="checkbox" name="id[]" value="' . $records['data'][$i][$id] . '" class="select-checkbox">';
                }

                if (!empty($css_class) && !empty($uri) && !empty($text)) {
                    if ($records['data'][$i]['status'] == 'approved' && date('Y-m-d') > $records['data'][$i]['end_date']) {
                        if (isset($button['gen'])) {
                            $records['data'][$i]['contract_details'] .= "<a class='btn btn-default generate_cert " . $css_class . "' href='" . $url . "' data-startdate='" . $records['data'][$i]['start_date'] . "' data-enddate='" . $records['data'][$i]['end_date'] . "' data-cid='" . $records['data'][$i]['id'] . "'>" . $text . "</a>";
                        }
                    } else {
                        if (isset($button['det'])) {
                            $url = url('/contractdetails/' . $records['data'][$i]['id']);
                            $records['data'][$i]['contract_details'] .= "<a target='_blank' class='btn btn-default generate_cert " . $css_class . "' href='" . $url . "' data-startdate='" . $records['data'][$i]['start_date'] . "'data-enddate='" . $records['data'][$i]['end_date'] . "' data-cid=" . $records['data'][$i]['id'] . "'>" . $text . "</a>";
                        }
                    }

                    if (isset($button['service_flag'])) {
                        $records['data'][$i]['service_details'] .= "<a data-token='" . csrf_token() . "' url='" . url('taqawel/market') . "' data-url='" . url('/taqawel/market/offer') . "' data-id= '" . $records['data'][$i][$id] . "' class='service btn btn-default " . $css_class . "'>" . $text . "</a>";
                    }

                    if (isset($button['serviceEdit'])) {
                        $records['data'][$i]['serviceEdit'] .= "<a class='btn btn-default " . $css_class . "'  data-href='" . url("/taqawel/publishservice/" . $records['data'][$i][$id]) . "/edit'  data-target='#main' data-toggle=\"modal\" >" . $text . "</a>";
                    }
                    if (isset($button['serviceDelete'])) {
                        $records['data'][$i]['serviceEdit'] .= "<a  data-popout=\"true\" data-token='" . csrf_token() . "' data-hreff='" . route('taqawel.publishservice.destroy',
                                $records['data'][$i][$id]) . "' data-url='" . url('/taqawel/publishservice') . "' data-id= '" . $records['data'][$i][$id] . "'class=\"btn red-mint delete-ajax\" data-toggle=\"confirmation\"
                                                    data-original-title=\"" . trans('labels.delete_confirmation_message') . "\"
                                                    data-placement=\"top\"
                                                    data-btn-ok-label=\"" . trans('labels.delete') . "\"
                                                    data-btn-cancel-label=\"" . trans('labels.cancel') . "\">
                                                <i class=\"fa fa-trash-o\"></i>" . $text . "</a>";
                    }

                    // Taqawel Service edit/delete buttons using modal/ajax
                    if (isset($button['taqawelServiceEdit'])) {
                        $records['data'][$i]['taqawelServiceEdit'] .= "<a class='btn btn-default " . $css_class . "'  data-href='" . url("/taqawel/taqawelService/" . $records['data'][$i][$id]) . "/edit'  data-target='#main' data-toggle=\"modal\" >" . $text . "</a>";
                    }
                    if (isset($button['taqawelServiceDelete'])) {
                        $records['data'][$i]['taqawelServiceEdit'] .= "<a  data-popout=\"true\" data-token='" . csrf_token() . "' data-hreff='" . route('taqawel.taqawelService.destroy',
                                $records['data'][$i][$id]) . "' data-url='" . url('/taqawel/taqawelService') . "' data-id= '" . $records['data'][$i][$id] . "'class=\"btn red-mint delete-ajax\" data-toggle=\"confirmation\"
                                                    data-original-title=\"" . trans('labels.delete_confirmation_message') . "\"
                                                    data-placement=\"top\"
                                                    data-btn-ok-label=\"" . trans('labels.delete') . "\"
                                                    data-btn-cancel-label=\"" . trans('labels.cancel') . "\">
                                                <i class=\"fa fa-trash-o\"></i>" . $text . "</a>";
                    }

                    // Taqawel Service edit/delete buttons using modal/ajax END

                    $records['data'][$i]['details'] .= "<a data-loading-text='".trans('labels.loading')."...' class='btn btn-default " . $css_class . "' href='" . $uri . "'>" . $text . "</a>";
                    $records['data'][$i]['buttons'] .= "<a class='btn btn-default " . $css_class . "' href='" . $uri . "'>" . $text . "</a>";

                    // Check if it is the follow contracts table
                    if (request()->is('follow_contracts/*/*')) {
                        followContractsDatatableCallback($records, $i, $key, $buttons);
                    }
                }

                if (!empty($html)) {
                    if (isset($html['column']) && is_array($html['column'])) {
                        foreach ($html as $name => $column) {
                            foreach ($column as $key => $name) {
                                $records['data'][$i][array_get($html,
                                    'column.' . $key)] = array_get($html,
                                    'html.' . $key);
                            }
                        }
                    } else {
                        $records['data'][$i][$html['column']] = $html['html'];
                    }
                }
            }

        }

        return $records;
    }
}

if (!function_exists('followContractsDatatableCallback')) {
    function followContractsDatatableCallback($records, $i, $key, $buttons)
    {
        $prvd_benf = request()->route()->parameter('prvd_benf');
        if ($records['data'][$i]['contract_type_id'] == Constants::CONTRACTTYPES['direct_emp'] && 
                !in_array($records['data'][$i]['status'], ['approved', 'provider_cancel', 'benef_cancel'])) {
            if ( in_array($records['data'][$i]['provider_type'],
                    [Constants::USERTYPES['saudi'], Constants::USERTYPES['job_seeker']]) && $prvd_benf == 1
            ) {
                $prvd_benf = 2;
            } else {
                $prvd_benf = 1;
            }
        }

        // Special case - Job seeker - no actions
        /*if (!in_array($records['data'][$i]['provider_type'],
                [Constants::USERTYPES['saudi'], Constants::USERTYPES['job_seeker']])
        ) {*/
            // -- Dual state status
            if ($records['data'][$i]['status'] == 'approved') {
                // If it has no contract employee (Ishaar)
                if (count($records['data'][$i]['employees']) == 0) {
                    if (in_array($key,
                        Constants::CONTRACT_STATUSES_MAP[$records['data'][$i]['status'] . '_without_ishaar'][$prvd_benf])) {
                        $records['data'][$i]['follow_contract_options'] .= "<a class='btn btn-default " . $buttons[$key]['css_class'] . "' href='" . datatableBtnURI($buttons[$key],
                                $records['data'][$i]) . "'>" . $buttons[$key]['text'] . "</a>";
                    }
                } else {
                    if (date('Y-m-d') > $records['data'][$i]['end_date']) {
                        if ($records['data'][$i]['cancelled_employees']) {
                            foreach ($records['data'][$i]['cancelled_employees'] as $ke => $ve) {
                                if (in_array($key,
                                    Constants::CONTRACT_STATUSES_MAP[Constants::PRVD_BENF_SHORTCUT[3 - $prvd_benf] . '_cancel_employee'])) {
                                    $records['data'][$i]['follow_contract_options'] .= "<a class='btn btn-default " . $buttons[$key]['css_class'] . "' href='" . datatableBtnURI($buttons[$key],
                                            $records['data'][$i]) . "'>" . $buttons[$key]['text'] . " ($ve)" . "</a>";
                                }
                            }
                        } else {
                            if (in_array($key,
                                Constants::CONTRACT_STATUSES_MAP[$records['data'][$i]['status'] . '_finished'][$prvd_benf])) {
                                $records['data'][$i]['follow_contract_options'] .= "<a class='btn btn-default " . $buttons[$key]['css_class'] . "' href='" . datatableBtnURI($buttons[$key],
                                        $records['data'][$i]) . "'>" . $buttons[$key]['text'] . "</a>";
                            }
                        }

                    } else {
                        if (in_array($key,
                            Constants::CONTRACT_STATUSES_MAP[$records['data'][$i]['status']][$prvd_benf])) {
                            if (!isset($buttons[$key]['repeated'])) {
                                $records['data'][$i]['follow_contract_options'] .= "<a class='btn btn-default " . $buttons[$key]['css_class'] . "' href='" . datatableBtnURI($buttons[$key],
                                        $records['data'][$i]) . "'>" . $buttons[$key]['text'] . "</a>";
                            } else {
                                $buttonsBeforeLoop = $records['data'][$i]['follow_contract_options'];
                                foreach ($records['data'][$i]['employees'] as $ind => $emp) {
                                    if ($emp->status == Constants::CONTRACT_STATUSES['provider_cancel'] || $emp->status == Constants::CONTRACT_STATUSES['benef_cancel']) {
                                        $records['data'][$i]['follow_contract_options'] = $buttonsBeforeLoop;
                                        if ($emp->status == Constants::CONTRACT_STATUSES['benef_cancel'] && $prvd_benf == 1) {
                                            $records['data'][$i]['follow_contract_options'] = "<a class='btn btn-default " . $buttons['process_cancel_ishaar_request']['css_class'] . "' href='" . datatableBtnURI($buttons['process_cancel_ishaar_request'],
                                                    $emp) . "'>" . $buttons['process_cancel_ishaar_request']['text'] . "</a>";
                                        } elseif ($emp->status == Constants::CONTRACT_STATUSES['provider_cancel'] && $prvd_benf == 2) {
                                            $records['data'][$i]['follow_contract_options'] = "<a class='btn btn-default " . $buttons['process_cancel_ishaar_request']['css_class'] . "' href='" . datatableBtnURI($buttons['process_cancel_ishaar_request'],
                                                    $emp) . "'>" . $buttons['process_cancel_ishaar_request']['text'] . "</a>";
                                        }
                                        break;
                                    } elseif ($emp->status == Constants::CONTRACT_STATUSES['cancelled']) {
                                        continue;
                                    }

                                    $empIndex = '';
                                    if (count($records['data'][$i]['employees']) > 1) {
                                        $empIndex = ' (' . ($ind + 1) . ') ';
                                    }
                                    $records['data'][$i]['follow_contract_options'] .= "<a class='btn btn-default " . $buttons[$key]['css_class'] . "' href='" . datatableBtnURI($buttons[$key],
                                            $emp) . "'>" . $buttons[$key]['text'] . $empIndex . "</a>";
                                }
                            }
                        }
                    }
                }
            } else {
                if (in_array($key,
                    Constants::CONTRACT_STATUSES_MAP[$records['data'][$i]['status']][$prvd_benf])) {
                    $records['data'][$i]['follow_contract_options'] .= "<a class='btn btn-default " . $buttons[$key]['css_class'] . "' href='" . datatableBtnURI($buttons[$key],
                            $records['data'][$i]) . "'>" . $buttons[$key]['text'] . "</a>";
                }
            }
        //}
    }
}
if (!function_exists('datatableBtnURI')) {
    /**
     * This function generates the button's URI dynamically based on the params array in the $button array
     */

    function datatableBtnURI($button, $data)
    {
        $uri = $button['uri_' . request()->route()->parameter('ct_id')];

        foreach ($button['params'] as $key => $param) {
            if (!is_null($param['value'])) {
                $uri = str_replace('{' . $key . '}', $param['value'], $uri);
            } else {
                $uri = str_replace('{' . $key . '}', $data[$param['name']], $uri);
            }
        }

        return $uri;
    }
}
//TODO : sendSMS
if (!function_exists("sendSMS")) {

    /**
     * This function for sending SMS for Ajeer clients
     *
     * @param $mobileNumber
     * @param $text
     *
     * @return bool
     */
    function sendSMS($mobileNumber, $text)
    {
        return true;
    }
}

if (!function_exists("customUploadFile")) {

    /**
     * Custom upload function that you send to it the file name in the request like "photo"
     * Also you will specify the folder like "tempWork" or "tqawel"
     * This function will find or create upload folder for the current month then make upload inside it
     *
     * @param $fileAttr
     * @param $path
     *
     * @return string $filePath
     */
    function customUploadFile($fileAttr, $path = "tempWork")
    {
        $upload_dir = \Tamkeen\Ajeer\Utilities\Constants::UPLOADPATH;
        $folder_path = $path . '/' . date('m') . '_' . date('y');

        if (request()->file($fileAttr)->isValid()) {
            if (!file_exists(base_path($upload_dir . $folder_path))) {
                mkdir(base_path($upload_dir . $folder_path), 0777, true);
            }

            $file = request()->file($fileAttr);
            $name = $file->getClientOriginalName();
            $name = time() . '_' . $name;
            $file->move(base_path($upload_dir . $folder_path), $name);

            return $folder_path . '/' . $name;
        }

        return false;
    }
}

if (!function_exists("getDiffPeriodDay")) {

    /**
     * @param $dayAdded
     * @param $period
     * @param $periodType
     *
     * @return string
     */
    function getDiffPeriodDay($dayAdded, $period, $periodType)
    {
        $date = Carbon::parse($dayAdded);

        switch ($periodType) {
            case 1:
                $endDate = $date->addDays($period);
                break;
            case 2:
                $endDate = $date->addMonths($period);
                break;
            case 3:
                $endDate = $date->addYears($period);
                break;
            default :
                $endDate = $date;
                break;
        }

        return $endDate->format("Y-m-d");
    }
}


if (!function_exists("getCurrentUserNameAndId")) {

    /**
     * @return array
     *
     * Get the current username and id
     */
    function getCurrentUserNameAndId()
    {
        if (session()->get('selected_establishment')) {
            $userId = session()->get('selected_establishment.id');
            $username = session()->get('selected_establishment.name');
        } elseif (session()->get('government')) {
            $userId = session()->get('government.id');
            $username = session()->get('government.name');
        } else {
            $userId = auth()->user()->id_no;
            $username = auth()->user()->name;
        }

        return [$userId, $username];
    }
}


if (!function_exists("getDiffPeriodMonth")) {

    /**
     * @param $date1
     * @param $date2
     *
     * @return num of months
     */
    function getDiffPeriodMonth($date1, $date2)
    {
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        return $diff;
    }
}

if (!function_exists("checkInRange")) {

    /**
     * @param $start_date
     * @param $end_date
     * @param checkable_date
     *
     * @return boolean
     */
    function checkInRange($start_date, $end_date, $checkable_date)
    {
        // Convert to timestamp
        $start_ts = strtotime($start_date);
        $end_ts   = strtotime($end_date);
        $user_ts  = strtotime($checkable_date);

        // Check that user date is between start & end
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }
}

if (!function_exists("getLoggedAccountNumber")) {
    /**
     * Get current account number
     *
     * @param Connector $connector
     *
     * @return int $customerNo
     */
    function getLoggedAccountNumber($connector)
    {
        if (!empty(session('selected_establishment'))) {
            $establishment = session('selected_establishment');
            $customerNo    = BillingUtils::establishmentCustomerNumber($establishment->labour_office_no,
                $establishment->sequence_no);
            $name          = $establishment->name;
        } elseif (!empty(auth()->user()->national_id)) {
            $customerNo = BillingUtils::personalCustomerNumber(auth()->user()->national_id);
            $name       = auth()->user()->name;
        } else {
            abort(401);
        }

        return $connector->getAccountNumber(1, $customerNo, $name);
    }
}

if (!function_exists('defaultDateRange')) {
    /**
     * Returns the default date range in two variables, $from and $to
     */
    function defaultDateRange($asString = false, $from = null, $to = null)
    {
        // $from and $to are present and needed in string format
        if (true == $asString) {
            $from = $from->format('Y-m-d');
            $to = $to->format('Y-m-d');

            return [$from, $to];
        }

        // Default date range
        $default_period = 30;

        if (!is_null($to) && $to < date('Y-m-d', time()) && Carbon::createFromFormat('Y-m-d', $to) !== false) {
            $to = Carbon::createFromFormat('Y-m-d', $to);
        } else {
            $to = Carbon::now();
        }

        if (!is_null($from) && $from < date('Y-m-d', time()) && Carbon::createFromFormat('Y-m-d',
                $from) !== false && $from < $to
        ) {
            $from = Carbon::createFromFormat('Y-m-d', $from);
        } else {
            $from = Carbon::now()->subDays($default_period);
        }

        return [$from, $to];
    }
}

if (!function_exists("getDatesDiff")) {

    function getDatesDiff($start_date, $end_date)
    {
        $carbon_start_date = Carbon::parse($start_date);
        $carbon_end_date = Carbon::parse($end_date);
        
        if($carbon_start_date->diffInYears($carbon_end_date) != 0){
            return $carbon_start_date->diffInYears($carbon_end_date)." ". trans('approve_cancellation_disclaimer.years');
        }else if($carbon_start_date->diffInMonths($carbon_end_date) != 0){
            return $carbon_start_date->diffInMonths($carbon_end_date)." ". trans('approve_cancellation_disclaimer.months');
        }else{
             return $carbon_start_date->diffInDays($carbon_end_date)." ". trans('approve_cancellation_disclaimer.days');
        }
    }

}

/** Date Convertions **/

if(!function_exists('intPart')) {
    function intPart($float)
    {
        if ($float < -0.0000001)
            return ceil($float - 0.0000001);
        else
            return floor($float + 0.0000001);
    }
}

/** 
*
* Date Convertion (Hijri to Gregorian)
* @param integer day
* @param integer month 
* @param integer year 
* @return Associative Array ['year'=> ,'month'=> ,'day'=> ]
*/
if(!function_exists('Hijri2Greg')) {
    function Hijri2Greg($day, $month, $year, $string = false)
    {
        $day   = (int) $day;
        $month = (int) $month;
        $year  = (int) $year;

        $jd = intPart((11*$year+3) / 30) + 354 * $year + 30 * $month - intPart(($month-1)/2) + $day + 1948440 - 385;

        if ($jd > 2299160)
        {
            $l = $jd+68569;
            $n = intPart((4*$l)/146097);
            $l = $l-intPart((146097*$n+3)/4);
            $i = intPart((4000*($l+1))/1461001);
            $l = $l-intPart((1461*$i)/4)+31;
            $j = intPart((80*$l)/2447);
            $day = $l-intPart((2447*$j)/80);
            $l = intPart($j/11);
            $month = $j+2-12*$l;
            $year  = 100*($n-49)+$i+$l;
        }
        else
        {
            $j = $jd+1402;
            $k = intPart(($j-1)/1461);
            $l = $j-1461*$k;
            $n = intPart(($l-1)/365)-intPart($l/1461);
            $i = $l-365*$n+30;
            $j = intPart((80*$i)/2447);
            $day = $i-intPart((2447*$j)/80);
            $i = intPart($j/11);
            $month = $j+2-12*$i;
            $year = 4*$k+$n+$i-4716;
        }
        
        $data = array();
        $date['year']  = $year;
        $date['month'] = $month;
        $date['day']   = $day;
        
        if (!$string)
            return $date;
        else
            return     "{$year}-{$month}-{$day}";
    }
}

/** 
*
* Date Convertion (Gerorgian to hijri)
* @param integer day
* @param integer month 
* @param integer year 
* @return Associative Array ['year'=> ,'month'=> ,'day'=> ]
*/

if(!function_exists('Greg2Hijri')) {
    function Greg2Hijri($day, $month, $year, $string = false)
    {
        $day   = (int) $day;
        $month = (int) $month;
        $year  = (int) $year;

        if (($year > 1582) or (($year == 1582) and ($month > 10)) or (($year == 1582) and ($month == 10) and ($day > 14)))
        {
            $jd = intPart((1461*($year+4800+intPart(($month-14)/12)))/4)+intPart((367*($month-2-12*(intPart(($month-14)/12))))/12)-
            intPart( (3* (intPart(  ($year+4900+    intPart( ($month-14)/12)     )/100)    )   ) /4)+$day-32075;
        }
        else
        {
            $jd = 367*$year-intPart((7*($year+5001+intPart(($month-9)/7)))/4)+intPart((275*$month)/9)+$day+1729777;
        }

        $l = $jd-1948440+10632;
        $n = intPart(($l-1)/10631);
        $l = $l-10631*$n+354;
        $j = (intPart((10985-$l)/5316))*(intPart((50*$l)/17719))+(intPart($l/5670))*(intPart((43*$l)/15238));
        $l = $l-(intPart((30-$j)/15))*(intPart((17719*$j)/50))-(intPart($j/16))*(intPart((15238*$j)/43))+29;
        
        $month = intPart((24*$l)/709);
        $day   = $l-intPart((709*$month)/24);
        $year  = 30*$n+$j-30;
        
        $date = array();
        $date['year']  = $year;
        $date['month'] = $month;
        $date['day']   = $day;

        if (!$string)
            return $date;
        else
            return     "{$year}-{$month}-{$day}";
    }
}

/** End of Date Convertions **/
