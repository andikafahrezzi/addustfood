<?php
class Payment_model extends CI_Model
{
    public function create($data)
    {
        return $this->db->insert('payments', $data);
    }

    public function getByOrderNumber($orderNumber)
    {
        return $this->db
            ->where('order_number', $orderNumber)
            ->get('payments')
            ->row_array();
    }

    public function updateByOrderNumber($orderNumber, $data)
    {
        return $this->db
            ->where('order_number', $orderNumber)
            ->update('payments', $data);
    }
    public function updateSnapToken($orderNumber, $snapToken)
{
    return $this->db
        ->where('order_number', $orderNumber)
        ->update(
            'payments',
            [
                'snap_token' => $snapToken
            ]
        );
}

}