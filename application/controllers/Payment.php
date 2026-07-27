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

            // Simpan ke database
            $this->Payment_model->updateSnapToken(
                $orderNumber,
                $snapToken
            );

            // Debug sementara
            echo $snapToken;
            exit;

        } catch (Exception $e) {

            echo $e->getMessage();

        }

    }
    
}