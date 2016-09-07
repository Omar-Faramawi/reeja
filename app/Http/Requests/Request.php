<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class Request
 * @package Tamkeen\Ajeer\Http\Requests
 */
abstract class Request extends FormRequest
{
    /**
     * get target id from the current segment
     *.
     *
     * @param int $segment
     *
     * @return int
     */
    protected function getTargetId($segment = 3)
    {
        return ! empty($this->segment((integer)$segment)[0]) ? Hashids::decode($this->segment((integer)$segment))[0] : 0;
    }
}
