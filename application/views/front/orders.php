<div class="container mt-3">
    <?php if($this->session->flashdata('success_msg') != ""):?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success_msg');?>
    </div>
    <?php endif ?>
    <?php if($this->session->flashdata('error_msg') != ""):?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('error_msg');?>
    </div>
    <?php endif ?>
    <div class="container shadow-container">
        <h2 class="text-center">Recent Orders</h2>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Total Item</th>
                    <th>Total Quantity</th>
                    <th>Payment</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php if(!empty($orders)) { ?>

                <?php foreach($orders as $order) { ?>

                <?php
                $status = $order['status'];

                if(
                    $status == "" ||
                    $status == "NULL" ||
                    $status == "waiting confirmation" ||
                    $status == "waiting order" ||
                    $status == "in process" ||
                    $status == "rejected"
                ){
                ?>

                <tr>

                    <td><?php echo $order['order_number']; ?></td>

                    <td><?php echo $order['total_item']; ?></td>

                    <td><?php echo $order['total_quantity']; ?></td>

                    <td><?php echo 'Rp. '.number_format($order['total_price'],0,',','.'); ?></td>
                    <td>

<?php if($order['payment_method'] == 'Cash') { ?>

    <span class="badge bg-secondary">
        Cash
    </span>

<?php } else { ?>

    <?php

    $paymentStatus = strtolower($order['transaction_status']);

    switch($paymentStatus){

        case 'capture':
        case 'settlement':

            $badge = 'success';
            $text  = ucfirst($paymentStatus);

        break;

        case 'pending':

            $badge = 'warning';
            $text  = 'Pending';

        break;

        case 'expire':
        case 'cancel':
        case 'deny':

            $badge = 'danger';
            $text  = ucfirst($paymentStatus);

        break;

        default:

            $badge = 'secondary';
            $text  = '-';

    }

    ?>

    <span class="badge bg-<?php echo $badge; ?>">
        <?php echo $text; ?>
    </span>

<?php } ?>

</td>
                  <td>

<?php

switch($status){

    case 'pending payment':

        $badge = 'secondary';
        $icon  = 'fas fa-credit-card';
        $text  = 'Pending Payment';

    break;

    case 'waiting confirmation':

        $badge = 'warning';
        $icon  = 'fas fa-clock';
        $text  = 'Waiting Confirmation';

    break;

    case 'waiting order':

        $badge = 'warning';
        $icon  = 'fas fa-clock';
        $text  = 'Waiting Order';

    break;

    case 'in process':

        $badge = 'primary';
        $icon  = 'fas fa-truck';
        $text  = 'In Process';

    break;

    case 'closed':

        $badge = 'success';
        $icon  = 'fas fa-check-circle';
        $text  = 'Completed';

    break;

    case 'rejected':

        $badge = 'danger';
        $icon  = 'fas fa-times-circle';
        $text  = 'Cancelled';

    break;

    default:

        $badge = 'secondary';
        $icon  = 'fas fa-question-circle';
        $text  = ucfirst($status);

}

?>

<span class="badge bg-<?php echo $badge; ?>">
    <i class="<?php echo $icon; ?>"></i>
    <?php echo $text; ?>
</span>

</td>

                    <td>

                        <?php

                        $cDate = strtotime($order['date']);

                        echo date('d-M-Y H:i',$cDate);

                        ?>

                    </td>

                    <td>

<?php

$paymentStatus = strtolower($order['transaction_status']);
$orderStatus   = strtolower($order['status']);
$paymentMethod = strtolower($order['payment_mode']);

?>

<?php if(
    $paymentMethod == 'online transfer' &&
    $paymentStatus == 'pending' &&
    $orderStatus == 'waiting order'
){ ?>

    <a
    href="<?php echo base_url('payment/pay/'.$order['order_number']); ?>"
    class="btn btn-primary">

        <i class="fas fa-credit-card"></i>

        Continue Payment

    </a>

<?php } elseif(
    $paymentMethod == 'cash' &&
    $orderStatus == 'waiting confirmation'
){ ?>

    <a
    href="javascript:void(0);"
   onclick="cancelOrder('<?php echo $order['order_number']; ?>')"
    class="btn btn-danger">

        <i class="fas fa-times"></i>

        Cancel

    </a>

<?php } else { ?>

    <button
    class="btn btn-secondary"
    disabled>

        <i class="fas fa-clock"></i>

        Waiting Order

    </button>

<?php } ?>

</td>

                </tr>

                <?php } ?>

                <?php } ?>

                <?php } else { ?>

                <tr>

                <td colspan="7">

                No Orders Found

                </td>

                </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>
        <h2 class="text-center">All Orders</h2>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Date</th>
                        <th>Total Item</th>
                        <th>Total Qty</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tbody>

                <?php if(!empty($orders)) { ?>

                <?php foreach($orders as $order) { ?>

                <?php if($order['status']=="closed") { ?>

                <tr>

                <td>

                <?php echo $order['order_number']; ?>

                </td>

                <td>

                <?php

                $cDate = strtotime($order['date']);

                echo date('d-M-Y',$cDate);

                ?>

                </td>

                <td>

                <?php echo $order['total_item']; ?>

                </td>

                <td>

                <?php echo $order['total_quantity']; ?>

                </td>

                <td>

                <?php echo 'Rp. '.number_format($order['total_price'],0,',','.'); ?>

                </td>

                <td>

                <button class="btn btn-success">

                <i class="fas fa-check"></i>

                Delivered

                </button>

                </td>

                <td>

                <a
                href="<?php echo base_url('orders/invoice/'.$order['order_number']); ?>"
                class="btn btn-info">

                <i class="fas fa-file-alt"></i>

                Invoice

                </a>

                </td>

                </tr>

                <?php } ?>

                <?php } ?>

                <?php } else { ?>

                <tr>

                <td colspan="7">

                No Orders Found

                </td>

                </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function cancelOrder(id) {
        if (confirm("Are you sure you want to cancel this order?")) {
        window.location.href = '<?php echo base_url().'orders/cancelOrder/';?>' + id;
        }
    }
</script>