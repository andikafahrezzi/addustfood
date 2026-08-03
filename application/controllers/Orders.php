<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Orders extends CI_Controller {
    function __construct(){
        parent::__construct();

        $user = $this->session->userdata('user');
            if(empty($user)) {
                $this->session->set_flashdata('msg', 'Your session has been expired');
                redirect(base_url().'login/');
            }
        $this->load->model('Order_model');
        $this->load->model('Store_model');
        $this->load->model('User_model');
        $this->load->model('Payment_model');
        $this->load->model('Menu_model');
    }
public function index()
{
    $user = $this->session->userdata('user');

    if (!$user) {
        redirect('login');
    }

    // Mengambil history berdasarkan order_number (1 checkout = 1 data)
    $data['orders'] = $this->Order_model->getUserOrderHistory($user['user_id']);

    $this->load->view('front/partials/header');
    $this->load->view('front/orders', $data);
    $this->load->view('front/partials/footer');
}

    public function deleteOrder($id) {
        $order = $this->Order_model->getOrder($id);

        if(empty($order)) {
            $this->session->set_flashdata('error_msg', 'Order not found');
            redirect(base_url().'orders');
        }

        $this->Order_model->deleteOrder($id);

        $this->session->set_flashdata('success_msg', 'Your order cancelled successfully');
        redirect(base_url().'orders');

    }
public function cancelOrder($orderNumber)
{
    $order = $this->Order_model->getOrderByOrderNumber($orderNumber);

    if (empty($order)) {

        $this->session->set_flashdata('error_msg', 'Order not found');

        redirect(base_url('orders'));
    }

    // Soft Cancel Payment
    $this->Payment_model->cancelByOrderNumber($orderNumber);

    // Soft Cancel Order
    $this->Order_model->cancelOrderByOrderNumber($orderNumber);

    $this->session->set_flashdata(
        'success_msg',
        'Your order has been cancelled successfully.'
    );

    redirect(base_url('orders'));
}

public function invoice($orderNumber)
{
    // Cek login
    $user = $this->session->userdata('user');

    if (!$user) {
        redirect(base_url('login'));
    }

    // Ambil ringkasan order
    $summary = $this->Order_model->getOrderSummary($orderNumber);

    // Ambil seluruh item dalam checkout
    $orders = $this->Order_model->getOrdersByOrderNumber($orderNumber);

    // Order tidak ditemukan
    if (empty($summary) || empty($orders)) {
        show_404();
    }

    // Validasi pemilik order
    if ($summary['u_id'] != $user['user_id']) {
        $this->session->set_flashdata(
            'error_msg',
            'You are accessing wrong order data.'
        );

        redirect(base_url('orders'));
    }

    // Invoice hanya bisa dilihat jika order selesai
    if ($summary['status'] != 'closed') {
        $this->session->set_flashdata(
            'error_msg',
            'Your order is not yet complete.'
        );

        redirect(base_url('orders'));
    }

    // ===============================
    // Ambil data customer
    // ===============================
    $userData = $this->User_model->getUserById($summary['u_id']);

    // ===============================
    // Ambil harga satuan setiap menu
    // ===============================
    foreach ($orders as $key => $item) {

        $dish = $this->Menu_model->getSingleDish($item['d_id']);

        $orders[$key]['unit_price'] = $dish['price'];
    }

    // ===============================
    // Data ke View
    // ===============================
    $data['summary'] = $summary;
    $data['orders']  = $orders;
    $data['user']    = $userData;
    $data['res']     = $this->Store_model->getStore($summary['r_id']);

    $this->load->view('front/invoice', $data);
}
    public function update_payment_mode()
{
    // Load library dan model yang diperlukan
    $this->load->library('form_validation');
    $this->load->model('Order_model');

    // Validasi input
    $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required');

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal, kembali ke halaman form
        $this->session->set_flashdata('error', 'Payment mode is required.');
        redirect('admin/orders');
    } else {
        // Ambil data dari form
        $payment_mode = $this->input->post('payment_mode');
        if ($payment_mode) {
            echo "Payment Mode: " . $payment_mode; // Debug
        }

        // Data yang akan ditambahkan
        $data = [
            'payment_mode' => $payment_mode,
        ];

        // Masukkan data ke database
        if ($this->Order_model->insert_payment_mode($data)) {
            $this->session->set_flashdata('success', 'Payment mode updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update payment mode.');
        }

        redirect('orders');
    }
}

}