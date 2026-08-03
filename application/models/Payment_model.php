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

public function updateTransactionStatus($orderNumber, $status)
{
    $this->db->where('order_number', $orderNumber);

    return $this->db->update('payments', [

        'transaction_status' => $status,
        'updated_at' => date('Y-m-d H:i:s')

    ]);
}

public function cancelByOrderNumber($orderNumber)
{
    return $this->db
        ->where('order_number', $orderNumber)
        ->update(
            'payments',
            [
                'transaction_status' => 'cancelled',
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
}

public function updateNotification($orderNumber, $data)
{
    $this->db->where('order_number', $orderNumber);

    return $this->db->update('payments', $data);
}
}