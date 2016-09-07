<?php

namespace Tamkeen\Ajeer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Tamkeen\Ajeer\Models\Invoice;
use Tamkeen\Platform\Billing\Connectors\Connector;
use Tamkeen\Platform\Billing\Exceptions\InvalidPaymentNotificationException;
use Tamkeen\Platform\Billing\Exceptions\UnauthorizedPaymentNotificationException;
use Tamkeen\Ajeer\Http\Controllers\Controller;

class BillingController extends Controller
{
    public function notifyPayment(Request $request, Connector $billingConnector, LoggerInterface $logger)
    {
        $status = 0;
        
        $token           = $request->get('service_token');
        $accountNumber   = $request->get('account_number');
        $billNumber      = $request->get('bill_number');
        $paymentDatetime = $request->get('payment_datetime');
        
        $logger->info(sprintf("Payment Notification Received: \n%s \n%s", json_encode($request->header()),
            json_encode($request->getContent())));
        
        try {
            $billingConnector->assertPaymentNotification($token, $request->getClientIp(), $accountNumber, $billNumber,
                $paymentDatetime);
            
            Invoice::where('bill_number', $billNumber)->firstOrFail()->setPaid();
            
            $status  = 1;
            $message = 'Success';
            
        } catch (UnauthorizedPaymentNotificationException $e) {
            $logger->error($e);
            $message = 'Unauthorized access.';
            
        } catch (InvalidPaymentNotificationException $e) {
            $logger->error($e);
            $message = 'Invalid notification.';
        }
        
        return response()->json(compact('status', 'message'), $status == 1 ? 200 : 500);
        
    }
}
