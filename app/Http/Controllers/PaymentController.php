<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use zfhassaan\Payfast\PayFast;


class PaymentController extends Controller
{


   //Badg3risaWesome


    public function getPaymentFormDetails(Request $request): array
    {
        $item_name = $request->item_name;
        $item_description = $request->item_description;
        $amount = $request->amount;
        $order_id = 1;

        $merchant_id = env('PAYFAST_MERCHANT_ID');
        $merchant_key = env('PAYFAST_SECURED_KEY');
        $merchant_name = env('PAYFAST_MERCHANT_NAME');

        $successUrl= env('PAYFAST_SUCCESS_URL');
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
            'BASKET_ID' => $order_id, // Order ID from Checkout Page.
            'ORDER_DATE' => date('Y-m-d H:i:s', time()), // Order Date
        );
    }


    public function showSuccess(Request $request): \Inertia\Response|\Inertia\ResponseFactory
    {
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
