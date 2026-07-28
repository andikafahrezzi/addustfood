<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Order_model extends CI_Model {

    public function getOrders() {
        $this->db->order_by('o_id','DESC');
        $result = $this->db->get('user_orders')->result_array();
        return $result;
    }

    public function getOrder($id) {
        $this->db->where('o_id', $id);
        $result = $this->db->get('user_orders')->row_array();
        return $result;
    }

    public function getUserOrder($id) {
        $this->db->where('u_id', $id);
        $this->db->order_by('o_id','DESC');
        $result = $this->db->get('user_orders')->result_array();
        return $result;
    }
    public function getOrdersByOrderNumber($orderNumber)
    {
        $this->db->where('order_number', $orderNumber);
        $this->db->order_by('o_id', 'ASC');

        return $this->db->get('user_orders')->result_array();
    }
public function updatePaymentMethodByOrderNumber($orderNumber, $paymentMethod)
{
    return $this->db
        ->where('order_number', $orderNumber)
        ->update(
            'user_orders',
            [
                'payment_mode' => $paymentMethod
            ]
        );
}
    public function getOrderSummary($orderNumber)
    {
        $this->db->select('
            order_number,
            u_id,
            r_id,
            payment_mode,
            status,
            date,
            SUM(price) AS total_price,
            SUM(quantity) AS total_quantity,
            COUNT(o_id) AS total_item
        ');

        $this->db->where('order_number', $orderNumber);
        $this->db->group_by('order_number');

        return $this->db->get('user_orders')->row_array();
    }
    public function getUserOrderHistory($userId)
    {
        $this->db->select("
            order_number,
            u_id,
            payment_mode,
            status,
            date,
            SUM(price) AS total_price,
            SUM(quantity) AS total_quantity,
            COUNT(o_id) AS total_item
        ");

        $this->db->where('u_id', $userId);
        $this->db->group_by('order_number');
        $this->db->order_by('MAX(date)', 'DESC', false);

        return $this->db->get('user_orders')->result_array();
    }

    public function update($id, $status) {
        $this->db->where('o_id', $id);
        $this->db->update('user_orders', $status);
    }

    public function deleteOrder($id) {
        $this->db->where('o_id', $id);
        $this->db->delete('user_orders');
    }

    public function insertOrder($orderData) {
        $this->db->insert_batch('user_orders', $orderData);
        return $this->db->insert_id();
    }

    public function countOrders() {
        $query = $this->db->get('user_orders');
        return $query->num_rows();
    }

    public function countPendingOrders() {
        $this->db->where('status', NULL);
        $query = $this->db->get('user_orders');
        return $query->num_rows();
    }

    public function countDeliveredOrders() {
        $this->db->where('status','closed');
        $query = $this->db->get('user_orders');
        return $query->num_rows();
    }

    public function countRejectedOrders() {
        $this->db->where('status','rejected');
        $query = $this->db->get('user_orders');
        return $query->num_rows();
    }

    public function getAllOrders() {
        $this->db->order_by('o_id','DESC');
        $this->db->select('o_id, d_name, quantity, price, status, date, username, address,payment_mode');
        $this->db->from('user_orders');
        $this->db->join('users', 'users.u_id = user_orders.u_id');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getOrderByUser($id) {
        $this->db->select('o_id, r_id, d_id, users.u_id, d_name, quantity, price, status, f_name, l_name, user_orders.date, users.email, users.phone,  success-date, username, address, payment_mode');
        $this->db->from('user_orders');
        $this->db->join('users', 'users.u_id = user_orders.u_id');
        $this->db->where('o_id', $id);
        $result = $this->db->get()->row_array();
        return $result;
    }
    public function insert_data($data)
    {
        return $this->db->insert('user_orders', $data); // 'user_order' adalah nama tabel
    }
    
}