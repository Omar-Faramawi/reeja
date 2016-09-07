<?php namespace Tamkeen\Ajeer\Services\NIC;

use Artisaninweb\SoapWrapper\Extension\SoapService;
use SoapFault;

class NicSoapServices extends SoapService implements NicServices
{
    protected $wsdl = 'http://172.26.20.52:2936/NICService.svc?wsdl';

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
    public function authenticateViaMobile($idNumber, $code = null)
    {
        if (!$code) {
            $code = substr(str_shuffle(str_repeat('0123456789', 6)), 0, 6);
        }

        $message = [
            'AuthenticateUserByMobile' => [
                'IdNo' => $idNumber,
                'smsCode' => $code,
            ],
        ];

        try {
            $result = $this->call('AuthenticateUserByMobile', $message);

        } catch (SoapFault $e) {
            throw new SmsSendingException("", 0, $e);
        }

        if ($result->AuthenticateUserByMobileResult == false) {
            throw new SmsSendingException();
        }

        return $code;
    }
}
