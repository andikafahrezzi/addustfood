<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice - ADDUST FOOD</title>

    <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/custom.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'public/front/css/style.css';?>">

    <script src="<?php echo base_url().'assets/js/jquery-3.6.0.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js';?>"></script>
</head>

<body>

<div class="container my-4" style="border:2px solid #0d6efd">

    <div class="p-4">

        <div class="row">

            <div class="col-md-6">
                <h2 class="text-primary font-weight-bold">
                    ADDUST FOOD
                </h2>
            </div>

            <div class="col-md-6 text-right">

                <h5><?php echo $res['name']; ?></h5>

                <div><?php echo $res['email']; ?></div>

                <div><?php echo $res['address']; ?></div>

            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-6">

                <h5>Customer</h5>

                <div>
                    <?php echo $user['f_name'].' '.$user['l_name']; ?>
                </div>

                <div>
                    <?php echo $user['address']; ?>
                </div>

                <div>
                    <?php echo $user['email']; ?>
                </div>

                <div>
                    <?php echo $user['phone']; ?>
                </div>

            </div>

            <div class="col-md-6 text-right">

                <h5>Invoice</h5>

                <div>

                    <strong>Order Number :</strong>

                    <?php echo $summary['order_number']; ?>

                </div>

                <div>

                    <strong>Order Date :</strong>

                    <?php echo date('d M Y H:i', strtotime($summary['date'])); ?>

                </div>

                <div>

                    <strong>Payment :</strong>

                    <?php echo $summary['payment_mode']; ?>

                </div>

                <div>

                    <strong>Status :</strong>

                    Delivered

                </div>

            </div>

        </div>

        <hr>

        <table class="table table-bordered">

            <thead class="thead-light">

                <tr>

                    <th>No</th>

                    <th>Menu</th>

                    <th class="text-center">Qty</th>

                    <th class="text-right">Unit Price</th>

                    <th class="text-right">Subtotal</th>

                </tr>

            </thead>

            <tbody>

            <?php

            $no = 1;

            foreach($orders as $item){

            ?>

                <tr>

                    <td><?php echo $no++; ?></td>

                    <td><?php echo $item['d_name']; ?></td>

                    <td class="text-center">
                        <?php echo $item['quantity']; ?>
                    </td>

                    <td class="text-right">
                        Rp <?php echo number_format($item['unit_price'],0,',','.'); ?>
                    </td>

                    <td class="text-right">
                        Rp <?php echo number_format($item['price'],0,',','.'); ?>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

            <tfoot>

                <tr>

                    <th colspan="4" class="text-right">

                        Total Item

                    </th>

                    <th class="text-right">

                        <?php echo $summary['total_item']; ?>

                    </th>

                </tr>

                <tr>

                    <th colspan="4" class="text-right">

                        Total Quantity

                    </th>

                    <th class="text-right">

                        <?php echo $summary['total_quantity']; ?>

                    </th>

                </tr>

                <tr>

                    <th colspan="4" class="text-right">

                        Grand Total

                    </th>

                    <th class="text-right">

                        Rp <?php echo number_format($summary['total_price'],0,',','.'); ?>

                    </th>

                </tr>

            </tfoot>

        </table>

        <hr>

        <div class="text-center">

            <h5>Thank You For Your Order!</h5>

            <p class="mb-0">
                Terima kasih telah mempercayai Addust Food.
            </p>

            <small>
                Invoice ini dibuat secara otomatis oleh sistem.
            </small>

        </div>

    </div>

</div>

<div class="container text-center mb-4">

    <a href="<?php echo base_url('orders'); ?>" class="btn btn-warning">

        <i class="fas fa-arrow-left"></i>

        Back to Orders

    </a>

    <button onclick="window.print();" class="btn btn-primary">

        <i class="fas fa-print"></i>

        Print Invoice

    </button>

</div>

</body>

</html>