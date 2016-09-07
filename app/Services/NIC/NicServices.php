<?php namespace Tamkeen\Ajeer\Services\NIC;

interface NicServices
{
    /**
     * Send a code via SMS to the id number registered mobile.
     *
     * @param int         $idNumber
     * @param string|null $code
     *
     * @return string The code that was sent.
     *
     * @throws SmsSendingException
     */
    public function authenticateViaMobile($idNumber, $code = null);
}
