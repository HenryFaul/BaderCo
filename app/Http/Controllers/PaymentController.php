<?php

namespace App\Http\Controllers;
use App\Models\DesignJob;
use App\Models\DesignJobEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use zfhassaan\Payfast\PayFast;


class PaymentController extends Controller
{


   //Badg3risaWesome


    public function getPaymentFormDetails(Request $request): array
    {
        $item_name = $request->item_name;
        $item_description = $request->item_description;
        $amount = $request->amount;
        $order_id = $request->design_job_id;


        $merchant_id = env('PAYFAST_MERCHANT_ID');
        $merchant_key = env('PAYFAST_SECURED_KEY');
        $merchant_name = env('PAYFAST_MERCHANT_NAME');

        $successUrl= env('PAYFAST_SUCCESS_URL').'/'.$order_id;
        $failUrl = env('PAYFAST_ERROR_URL');
        $notifyUrl = env('PAYFAST_NOTIFY_URL');

        return array(
            'ITEM_NAME'=>$item_name,
            'ITEM_DESCRIPTION'=>$item_description,
            'AMOUNT'=>$amount,
            'ORDER_ID'=>$order_id,
            'MERCHANT_ID' => $merchant_id, // Merchant ID received from Payfast
            'MERCHANT_KEY' => $merchant_key, // Merchant ID received from Payfast
            'MERCHANT_NAME' => $merchant_name, // Merchant Name registered with Payfast.
            'CUSTOMER_MOBILE_NO' => '1234', // Customer Mobile Number
            'CUSTOMER_EMAIL_ADDRESS' => 'test@mail.com', // Customer Email address
            'VERSION' => 'Bader Co.', // Optional
            'TXNDESC' => 'Products purchased from ' .$merchant_name, // Transaction Description to show on website
            'SUCCESS_URL' => urlencode($successUrl), // Success URL where to redirect user after success
            'FAILURE_URL' => urlencode($failUrl), // Failure URL where to redirect user after failure
            'NOTIFY_URL' => urlencode($notifyUrl), // Failure URL where to redirect user after failure
            'BASKET_ID' => $order_id, // Order ID from Checkout Page.
            'ORDER_DATE' => date('Y-m-d H:i:s', time()), // Order Date
        );
    }


    public function showSuccess(Request $request, $job_id = null): \Inertia\Response|\Inertia\ResponseFactory
    {

        if (isset($job_id)){

           $design_job = DesignJob::where('id',$job_id)->first();

           if ($design_job!= null){

               $design_job->payment_status_id = 3;
               $design_job->save();

               $id = Auth::id();

               $event = DesignJobEvent::create([
                   'user_id' => $id,
                   'design_job_id' => $job_id,
                   'event' => 'payment_update',
                   'message' => 'Payfast payment processed.'
               ]);

           }


        }


        return inertia(
            'Payments/Success',
            [

            ]
        );
    }

    public function showError(Request $request): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia(
            'Payments/Error',
            [

            ]
        );
    }


}
