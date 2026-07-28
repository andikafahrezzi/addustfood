<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Checkout extends CI_Controller {

    function __construct() {
        parent::__construct();

        $user = $this->session->userdata('user');
            if(empty($user)) {
                $this->session->set_flashdata('msg', 'Your session has been expired');
                redirect(base_url().'login/');
            }
        
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->model('Order_model');
        $this->load->model('User_model');
        $this->load->model('Payment_model');
        $this->controller = 'checkout';
    }
    private function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

public function index()
{
    $loggedUser = $this->session->userdata('user');

    if (!$loggedUser) {
        redirect('login');
    }

    $u_id = $loggedUser['user_id'];
    $user = $this->User_model->getUser($u_id);

    if ($this->cart->total_items() <= 0) {
        redirect(base_url('jeniscemilan'));
    }

    $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
    $this->form_validation->set_rules('address', 'Address', 'trim|required');
    $this->form_validation->set_rules('payment_mode', 'Metode Pembayaran', 'required');

    if ($this->form_validation->run() == TRUE) {

        // Update alamat user
        $formArray = [
            'address' => $this->input->post('address', true)
        ];

        $this->User_model->update($u_id, $formArray);

        // Ambil metode pembayaran dari form
        $paymentMethod = $this->input->post('payment_mode', true);

        // Simpan order
        $order = $this->placeOrder($u_id, $paymentMethod);

        if ($order) {

            // Simpan data pembayaran
            $paymentData = [

                'order_number'       => $order['order_number'],

                'payment_method'     => $order['payment_method'],

                'transaction_status' => 'pending',

                'gross_amount'       => $order['gross_amount']

            ];

            $this->Payment_model->create($paymentData);
            
            redirect(base_url('payment/pay/' . $order['order_number']));

        } else {

            $data['error_msg'] = 'Order submission failed, please try again.';
        }
    }

    $data['user'] = $user;
    $data['cartItems'] = $this->cart->contents();

    $this->load->view('front/partials/header');
    $this->load->view('front/checkout', $data);
    $this->load->view('front/partials/footer');
}
public function placeOrder($u_id, $paymentMethod)
{
    $cartItems = $this->cart->contents();

    if (empty($cartItems)) {
        return false;
    }

    // 1 Checkout = 1 Order Number
    $orderNumber = $this->generateOrderNumber();

    $orderData = [];

    foreach ($cartItems as $item) {

        $orderData[] = [

            'order_number' => $orderNumber,

            'u_id' => $u_id,
            'd_id' => $item['id'],
            'r_id' => $item['r_id'],
            'd_name' => $item['name'],
            'quantity' => $item['qty'],
            'price' => $item['subtotal'],

            // sementara masih disimpan di user_orders
            'payment_mode' => $paymentMethod,

            'date' => date('Y-m-d H:i:s', now()),
            'success-date' => date('Y-m-d H:i:s', now())
        ];
    }

    $insertOrder = $this->Order_model->insertOrder($orderData);

    if ($insertOrder) {

    // Hitung total checkout sebelum cart dihapus
        $grossAmount = (float) $this->cart->total();

        // Hapus cart
        $this->cart->destroy();

        return [
            'order_number'   => $orderNumber,
            'gross_amount'   => $grossAmount,
            'payment_method' => $paymentMethod
        ];
    }

    return false;
}

public function process()
{
    $payment_mode = $this->input->post('payment_mode');
    
    // Data lain seperti ID user dan order
    $data = [
        'u_id' => $this->session->userdata('u_id'), // Contoh ID user
        'o_id' => $this->generateOrderID(),
        'payment_mode' => $payment_mode,
    ];

    // Simpan ke database
    $this->db->insert('user_orders', $data);

    // Redirect ke halaman invoice
    redirect('front/invoice' . $data['o_id']);
}

}
