<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('midtrans');

        $this->load->model('Payment_model');
        $this->load->model('Order_model');
        $this->load->model('User_model');
    }
    public function createSnapTransaction($orderNumber)
{
    // Ambil ringkasan order
    $summary = $this->Order_model->getOrderSummary($orderNumber);

    if (!$summary) {
        show_404();
    }

    // Ambil semua item
    $items = $this->Order_model->getOrdersByOrderNumber($orderNumber);

    // Ambil data user
    $user = $this->User_model->getUser($summary['u_id']);

    // Ambil data payment
    $payment = $this->Payment_model->getByOrderNumber($orderNumber);

    // =============================
    // Build Item Details
    // =============================
    $itemDetails = [];

    foreach ($items as $item) {

        $itemDetails[] = [

            'id'       => $item['d_id'],

            // Midtrans membutuhkan harga satuan
            'price'    => (int) ($item['price'] / $item['quantity']),

            'quantity' => (int) $item['quantity'],

            'name'     => $item['d_name']

        ];
    }

    // =============================
    // Customer Details
    // =============================
    $customerDetails = [

        'first_name' => $user['f_name'],

        'last_name'  => $user['l_name'],

        'email'      => $user['email'],

        'phone'      => $user['phone']

    ];

    // =============================
    // Transaction Details
    // =============================
    $transactionDetails = [

        'order_id'    => $summary['order_number'],

        'gross_amount'=> (int) $payment['gross_amount']

    ];

    // =============================
    // Midtrans Payload
    // =============================
    $params = [

        'transaction_details' => $transactionDetails,

        'customer_details' => $customerDetails,

        'item_details' => $itemDetails

    ];
    
    // DEBUG
        try {
            
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $this->Payment_model->updateSnapToken(
                $orderNumber,
                $snapToken
            );

            return $snapToken;

        } catch (Exception $e) {

            log_message('error', 'MIDTRANS ERROR : ' . $e->getMessage());

            echo "<pre>";
            echo $e->getMessage();
            die;

        }

    }
    public function pay($orderNumber)
    {
        $payment = $this->Payment_model->getByOrderNumber($orderNumber);

        if (!$payment) {
            show_404();
        }

        // Generate Snap Token jika belum ada
        if (empty($payment['snap_token'])) {

            $this->createSnapTransaction($orderNumber);

            $payment = $this->Payment_model->getByOrderNumber($orderNumber);
        }

        // Ambil data order (selalu)
        $orderSummary = $this->Order_model->getOrderSummary($orderNumber);

        $orderItems = $this->Order_model->getOrdersByOrderNumber($orderNumber);

        $data['payment'] = $payment;
        $data['summary'] = $orderSummary;
        $data['items'] = $orderItems;

        $this->config->load('midtrans');
        $data['clientKey'] = $this->config->item('client_key');
        $this->load->view('front/payment', $data);
    }
    public function finish()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $orderNumber = $this->input->post('order_number', true);
    $transactionStatus = $this->input->post('transaction_status', true);

    if (empty($orderNumber) || empty($transactionStatus)) {

        echo json_encode([
            'status'  => false,
            'message' => 'Invalid request.'
        ]);

        return;
    }

    // Update status pembayaran
    $updated = $this->Payment_model->updateTransactionStatus(
        $orderNumber,
        $transactionStatus
    );

    // Sinkronisasi status order
    if ($transactionStatus == 'settlement') {

        $this->Order_model->updateOrderStatusByOrderNumber(
            $orderNumber,
            'in process'
        );

    }

    if ($updated) {

        echo json_encode([
            'status' => true
        ]);

    } else {

        echo json_encode([
            'status' => false
        ]);

    }
}
public function notification()
{
    $notification = new \Midtrans\Notification();

    $transactionStatus = $notification->transaction_status;
    $orderNumber       = $notification->order_id;
    $paymentType       = $notification->payment_type;
    $fraudStatus       = $notification->fraud_status ?? null;
    $transactionId     = $notification->transaction_id;
    $transactionTime   = $notification->transaction_time;
    $settlementTime    = $notification->settlement_time ?? null;
    $expiryTime        = $notification->expiry_time ?? null;
    $statusCode        = $notification->status_code;
    $grossAmount       = $notification->gross_amount;
    $signatureKey      = $notification->signature_key;

    // =====================================================
    // Verify Signature Key
    // =====================================================

    $serverKey = $this->config->item('server_key');

    $hashed = hash(
        'sha512',
        $orderNumber .
        $statusCode .
        $grossAmount .
        $serverKey
    );

    if ($hashed !== $signatureKey) {

        http_response_code(403);
        exit('Invalid Signature');

    }

    // =====================================================
    // Data yang akan diupdate ke tabel payments
    // =====================================================

    $paymentData = [

        'midtrans_order_id'  => $orderNumber,
        'transaction_id'     => $transactionId,
        'transaction_status' => $transactionStatus,
        'payment_type'       => $paymentType,
        'fraud_status'       => $fraudStatus,
        'transaction_time'   => $transactionTime,
        'settlement_time'    => $settlementTime,
        'expiry_time'        => $expiryTime,
        'status_code'        => $statusCode,
        'signature_key'      => $signatureKey,
        'updated_at'         => date('Y-m-d H:i:s')

    ];

    if ($transactionStatus === 'settlement') {

        $paymentData['paid_at'] = date('Y-m-d H:i:s');

    }

    $this->Payment_model->updateByOrderNumber(
        $orderNumber,
        $paymentData
    );

    // =====================================================
    // Sinkronisasi status order
    // =====================================================

    switch ($transactionStatus) {

        case 'settlement':

            $this->Order_model->updateOrderStatusByOrderNumber(
                $orderNumber,
                'in process'
            );

            break;

        case 'pending':

            $this->Order_model->updateOrderStatusByOrderNumber(
                $orderNumber,
                'pending_payment'
            );

            break;

        case 'expire':

            $this->Order_model->updateOrderStatusByOrderNumber(
                $orderNumber,
                'expired'
            );

            break;

        case 'cancel':

            $this->Order_model->updateOrderStatusByOrderNumber(
                $orderNumber,
                'cancelled'
            );

            break;

        case 'deny':

            $this->Order_model->updateOrderStatusByOrderNumber(
                $orderNumber,
                'rejected'
            );

            break;
    }

    http_response_code(200);

    echo "OK";
}
public function testSnap()
{
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000
        ]
    ];

    try {
        $token = \Midtrans\Snap::getSnapToken($params);
        echo $token;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
}