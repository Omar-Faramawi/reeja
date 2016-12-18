<?php

namespace Tamkeen\Ajeer\Utilities;

use Illuminate\Support\Arr;

/**
 * Class Constants
 * @package Tamkeen\Ajeer\Utilities
 */
final class Constants
{
    /**
     * const ContractTypes
     */
    const CONTRACTTYPES = [
        'taqawel'      => '1',
        'temp_work'    => '2',
        'hire_labor'   => '3',
        'direct_emp'   => '4',
        'taqawel_free' => '5',
        'taqawel_paid' => '6'
    ];

    /*
     * constant uplaod path
     */
    const UPLOADPATH = 'public/uploads/';
    /**
     * cons user types
     */
    const USERTYPES = [
        'admin'      => '1',
        'gov'        => '2',
        'est'        => '3',
        'saudi'      => '4',
        'job_seeker' => '5',
    ];

    /**
     * const service types
     */
    const SERVICETYPES = [
        'provider' => '1',
        'benf'     => '2',
    ];

    /**
     * const direct hiring service types
     */
    const DIRECTSERVICETYPES = [
        'job_seeker' => '1',
        'job_owner'     => '2',
    ];


    /**
     * cons genders
     */
    const GENDER = [
        'female' => '0',
        'male'   => '1',
    ];
    /**
     * cons genders
     */
    const VacancyGENDER = [
        'female' => '0',
        'male'   => '1',
        'male_or_female'   => '2',
    ];

    /**
     * const religions
     */
    const RELIGION = [
        'muslim'     => '1',
        'non_muslim' => '2',
        'na'         => '3',
    ];

    /**
     * const job types
     */
    const JOBTYPES = [
        'no_salary' => '0',
        'salary'    => '1',
    ];
    /*
     * cons period types
     */
    const PERIODTYPES = [
        'day'   => '1',
        'month' => '2',
        'year'  => '3'
    ];
    /*
     * Establishment Statuses
     */
    const EST_STATUS = [
        'pending'       => '0',
        'approved'      => '1',
        'rejected'      => '2',
        'hajj_approved' => '3',
        'catt_approved' => '4',
    ];

    /*
     * Return CSS class corresponding to establishment status
     */
    const EST_STATUS_CLASSES = [
        '0' => 'default',
        '1' => 'success',
        '2' => 'danger',
        '3' => 'info',
        '4' => 'info'
    ];
    const CONTRACT_STATUSES = [
        'requested'         => 'requested',
        'pending'           => 'pending',
        'rejected'          => 'rejected',
        'pending_ownership' => 'pending_ownership',
        'approved'          => 'approved',
        'cancelled'         => 'cancelled',
        'benef_cancel'      => 'benef_cancel',
        'provider_cancel'   => 'provider_cancel',
    ];

    const CONTRACT_STATUSES_MAP = [
        'pending'                  => [
            '1' => ['edit_offer', 'cancel_offer'],
            '2' => ['view_offer'],

        ],
        'requested'                => [
            '1' => ['send_offer', 'reject_request'],
            '2' => ['details'],

        ],
        'rejected'                 => [
            '1' => ['details'],
            '2' => ['details']
        ],
        'pending_ownership'        => [
            '1' => ['details'],
            '2' => ['details'],

        ],
        'approved_without_ishaar'  => [
            '1' => ['generate_ishaar', 'request_contract_cancel'],
            '2' => ['details', 'request_contract_cancel'],

        ],
        'approved'                 => [
            '1' => ['request_contract_cancel', 'cancel_ishaar'],
            '2' => ['print_ishaar', 'request_contract_cancel', 'cancel_ishaar'],

        ],
        'cancelled'                => [
            '1' => ['details'],
            '2' => ['details'],

        ],
        'benef_cancel'             => [
            '1' => ['process_cancel_request'],
            '2' => ['details'],

        ],
        'provider_cancel'          => [
            '1' => [],
            '2' => ['process_cancel_request'],

        ],
        'approved_finished'        => [
            '1' => ['details'],
            '2' => ['details'],

        ],
        'benef_cancel_employee'    => [
            '1' => ['process_cancel_request'],
            '2' => ['process_cancel_request'],

        ],
        'provider_cancel_employee' => [
            '1' => ['process_cancel_request'],
            '2' => ['process_cancel_request'],

        ],
    ];

    const PRVD_BENF_SHORTCUT = [
        '1' => 'provider',
        '2' => 'benef'
    ];
    const INVOICE_STATUS = [
        'pending' => '0',
        'paid'    => '1',
        'expired' => '2',
    ];

    /*
     * Invoice Types
     */
    const INVOICE_TYPES = [
        'bundle'                     => '1',
        'certificate'                => '2',
        'contract_hire_labor'        => '3',
        'contract_direct_employee'   => '4',
    ];

    /**
     * cons user Permission types
     */
    const USERPERMISSIONTYPES = [
        'est'      => '1',
        'gov'        => '2',
        'indv'        => '3',
        'saudi'      => '4',
        
    ];

    /**
     * list user types
     *
     * @return array
     */
    private static function userTypes()
    {
        return array_flip(self::USERTYPES);
    }

    /**
     * list genders
     *
     * @return array
     */
    private static function gender()
    {
        return array_flip(self::GENDER);
    }

    /**
     * list genders
     *
     * @return array
     */
    private static function vacancyGender()
    {
        return array_flip(self::VacancyGENDER);
    }

    /**
     * list religions
     *
     * @return array
     */
    private static function religions()
    {
        return array_flip(self::RELIGION);
    }

    /**
     * list benf types
     *
     * @return array
     */
    private static function benfTypes()
    {
        return self::userTypes();
    }

    /**
     * list job type
     *
     * @return array
     */
    private static function jobTypes()
    {
        return array_flip(self::JOBTYPES);
    }

    /**
     * @return array
     *
     * Contract types constant
     */
    private static function contractTypes()
    {
        return array_flip(self::CONTRACTTYPES); // for translation return the inverse
    }

    /**
     * list period types
     *
     * @return array
     */
    private static function periodTypes()
    {
        return array_flip(self::PERIODTYPES);
    }

    /**
     * @return mixed
     *
     * Get type of the service either provider or benf
     */
    private static function serviceTypes()
    {
        return array_flip(self::SERVICETYPES);
    }

    /**
     * @return mixed
     *
     * Get type of the direct hiring service either job seeker or job_owner
     */
    private static function directServiceTypes()
    {
        return array_flip(self::DIRECTSERVICETYPES);
    }

    /**
     * @return mixed
     *
     * Get list of contract statuses
     */
    private static function contract_statuses()
    {
        return array_flip(self::CONTRACT_STATUSES);
    }

    /**
     * @return mixed
     *
     * Get The Establishment Statuses List
     */
    private static function estStatus()
    {
        return array_flip(self::EST_STATUS);
    }

    /**
     * @return mixed
     *
     * Get The Invoice Types
     */
    private static function invoiceTypes()
    {
        return array_flip(self::INVOICE_TYPES);
    }

    /**
     * @return mixed
     *
     * Get The Invoice Status
     */
    private static function invoiceStatues()
    {
        return array_flip(self::INVOICE_STATUS);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return string
     * you get a list of any dropdown translated
     * if you want to get specific value, just pass the key
     *
     * Example:
     * Constants::religions();
     * array:2 [ 0 => "general.non_muslim", 1 => "general.muslim"]
     * Constants::religions(1);
     * array:2 [ 1 => "general.muslim"]
     *
     * You can also pass array for the path of the translation file like
     * Constants::religions(1,['file' => 'banks'])
     *
     * this will override the default file of the translation ( default ) if you want
     */
    public static function __callStatic($name, $arguments)
    {
        $values = static::$name();
        if (!is_array($values)) {
            return;
        }

        list($file, $arguments) = self::checkForFileInputParameter($arguments);
        if (!empty($arguments)) {
            $values = array_only($values, $arguments);

            if (count($values) === 1) {
                $value = Arr::flatten($values);

                return trans($file . '.' . $value[0]);
            }
        }

        $translatedValues = array_map(function ($value) use ($file) {
            return trans($file . '.' . $value);
        }, $values);

        return $translatedValues;
    }

    /**
     * @param $arguments
     *
     * @return mixed|string
     *
     * This method check for the passed file parameter to the array like this
     * [ 'file' => 'banks' ]
     */
    private static function checkForFileInputParameter($arguments)
    {
        $file = 'labels';

        foreach ($arguments as $key => $argment) {

            if (is_array($argment)) {
                $exist = array_key_exists('file', $argment);
                if ($exist) {
                    $file = $argment['file'];
                }
                unset($arguments[$key]);
            }
        }

        return [$file, $arguments];
    }
}
