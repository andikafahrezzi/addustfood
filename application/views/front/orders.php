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
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Harga</th>
                    <th>Status</th>
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
                    $status == "in process" ||
                    $status == "rejected"
                ){
                ?>

                <tr>

                    <td><?php echo $order['order_number']; ?></td>

                    <td><?php echo $order['total_item']; ?></td>

                    <td><?php echo $order['total_quantity']; ?></td>

                    <td><?php echo 'Rp. '.number_format($order['total_price'],0,',','.'); ?></td>

                    <?php if($status=="" || $status=="NULL"){ ?>

                        <td>
                            <button class="btn btn-secondary">
                                <i class="fas fa-bars"></i> Process
                            </button>
                        </td>

                    <?php } ?>

                    <?php if($status=="in process"){ ?>

                        <td>
                            <button class="btn btn-warning">
                                <span class="fa fa-cog fa-spin"></span>
                                On Your Way!
                            </button>
                        </td>

                    <?php } ?>

                    <?php if($status=="rejected"){ ?>

                        <td>
                            <button class="btn btn-danger">
                                <i class="far fa-times-circle"></i>
                                Cancelled
                            </button>
                        </td>

                    <?php } ?>

                    <td>

                        <?php

                        $cDate = strtotime($order['date']);

                        echo date('d-M-Y H:i',$cDate);

                        ?>

                    </td>

                    <td>

                        <!-- sementara masih cancel per checkout -->
                        <a
                        href="javascript:void(0);"
                        class="btn btn-danger disabled">

                            <i class="fas fa-trash-alt"></i>

                            Cancel

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
    function deleteOrder(id) {
        if (confirm("Are you sure you want to cancel this order?")) {
        window.location.href = '<?php echo base_url().'orders/deleteOrder/';?>' + id;
        }
    }
</script>