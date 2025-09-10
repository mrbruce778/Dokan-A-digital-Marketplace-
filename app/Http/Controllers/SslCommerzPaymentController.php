<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Log;

class SslCommerzPaymentController extends Controller
{
    /**
     * Example Hosted Checkout Page
     */
    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    /**
     * Example Easy Checkout Page
     */
    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    /**
     * Hosted Payment Initiation
     */
    public function index(Request $request)
    {
        $post_data = [
            'total_amount' => 10, // numeric
            'currency' => "BDT",
            'tran_id' => uniqid(), // must be unique
            'cus_name' => 'Customer Name',
            'cus_email' => 'customer@mail.com',
            'cus_add1' => 'Customer Address',
            'cus_country' => "Bangladesh",
            'cus_phone' => '8801XXXXXXXXX',
            'ship_name' => "Store Test",
            'ship_add1' => "Dhaka",
            'ship_city' => "Dhaka",
            'ship_country' => "Bangladesh",
            'shipping_method' => "NO",
            'product_name' => "Computer",
            'product_category' => "Goods",
            'product_profile' => "physical-goods",
            'value_a' => "ref001",
        ];

        // Ensure the order exists
        DB::table('orders')->updateOrInsert(
            ['transaction_id' => $post_data['tran_id']],
            [
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'currency' => $post_data['currency'],
            ]
        );

        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            Log::error('SSLCommerz Error:', ['response' => $payment_options]);
            return response()->json(['error' => $payment_options]);
        }
    }

    /**
     * Ajax Payment Initiation
     */
public function payViaAjax(Request $request)
{
    // 1️⃣ Prepare payment data
    $post_data = [
        'total_amount' => 10,
        'currency' => "BDT",
        'tran_id' => uniqid(),
        'cus_name' => 'Customer Name',
        'cus_email' => 'customer@mail.com',
        'cus_add1' => 'Customer Address',
        'cus_country' => "Bangladesh",
        'cus_phone' => '8801XXXXXXXXX',
        'ship_name' => "Store Test",
        'ship_add1' => "Dhaka",
        'ship_city' => "Dhaka",
        'ship_country' => "Bangladesh",
        'shipping_method' => "NO",
        'product_name' => "Computer",
        'product_category' => "Goods",
        'product_profile' => "physical-goods",
        'value_a' => "ref001",
    ];

    // 2️⃣ Ensure order exists in DB
    DB::table('orders')->updateOrInsert(
        ['transaction_id' => $post_data['tran_id']],
        [
            'name' => $post_data['cus_name'],
            'email' => $post_data['cus_email'],
            'phone' => $post_data['cus_phone'],
            'amount' => $post_data['total_amount'],
            'status' => 'Pending',
            'address' => $post_data['cus_add1'],
            'currency' => $post_data['currency']
        ]
    );

    // 3️⃣ Initiate SSLCommerz payment and log response ✅
    $sslc = new SslCommerzNotification();
    $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

    Log::info('SSLCommerz Response:', (array)$payment_options);

    if (!is_array($payment_options)) {
        return response()->json(['error' => $payment_options]);
    }

    // 4️⃣ Return payment options to frontend
    return response()->json($payment_options);
}


    /**
     * Payment Success
     */
    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->first(['transaction_id', 'status', 'currency', 'amount']);

        if (!$order_details) {
            return "Invalid Transaction";
        }

        if ($order_details->status == 'Pending') {
            $sslc = new SslCommerzNotification();
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                return "Transaction is successfully Completed";
            }
        } elseif (in_array($order_details->status, ['Processing', 'Complete'])) {
            return "Transaction is already successfully Completed";
        } else {
            return "Invalid Transaction";
        }
    }

    /**
     * Payment Fail
     */
    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->first(['transaction_id', 'status']);

        if ($order_details && $order_details->status == 'Pending') {
            DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            return "Transaction has Failed";
        } elseif ($order_details && in_array($order_details->status, ['Processing', 'Complete'])) {
            return "Transaction is already Successful";
        }

        return "Invalid Transaction";
    }

    /**
     * Payment Cancel
     */
    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->first(['transaction_id', 'status']);

        if ($order_details && $order_details->status == 'Pending') {
            DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            return "Transaction is Canceled";
        } elseif ($order_details && in_array($order_details->status, ['Processing', 'Complete'])) {
            return "Transaction is already Successful";
        }

        return "Invalid Transaction";
    }

    /**
     * Instant Payment Notification (IPN)
     */
    public function ipn(Request $request)
    {
        $tran_id = $request->input('tran_id');

        if (!$tran_id) {
            return "Invalid Data";
        }

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->first(['transaction_id', 'status', 'currency', 'amount']);

        if (!$order_details) {
            return "Invalid Transaction";
        }

        if ($order_details->status == 'Pending') {
            $sslc = new SslCommerzNotification();
            $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);

            if ($validation) {
                DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);
                return "Transaction is successfully Completed";
            }
        } elseif (in_array($order_details->status, ['Processing', 'Complete'])) {
            return "Transaction is already successfully Completed";
        } else {
            return "Invalid Transaction";
        }
    }
}
