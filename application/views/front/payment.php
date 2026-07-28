<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Payment</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <script src="<?= base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>

    <script
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?= $clientKey ?>">
</script>

</head>

<body>

<div class="container mt-5">

    <div class="card">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">Payment</h4>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>

                    <th width="30%">Order Number</th>

                    <td><?= $summary['order_number']; ?></td>

                </tr>

                <tr>

                    <th>Status</th>

                    <td><?= ucfirst($payment['transaction_status']); ?></td>

                </tr>

                <tr>

                    <th>Payment Method</th>

                    <td><?= $payment['payment_method']; ?></td>

                </tr>

                <tr>

                    <th>Total Item</th>

                    <td><?= $summary['total_item']; ?></td>

                </tr>

                <tr>

                    <th>Total Quantity</th>

                    <td><?= $summary['total_quantity']; ?></td>

                </tr>

                <tr>

                    <th>Grand Total</th>

                    <td>
                        <strong>
                            Rp <?= number_format($payment['gross_amount'],0,',','.'); ?>
                        </strong>
                    </td>

                </tr>

            </table>

            <hr>

            <h5>Items</h5>

            <table class="table table-striped">

                <thead>

                    <tr>

                        <th>Menu</th>

                        <th>Qty</th>

                        <th>Subtotal</th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach($items as $item){ ?>

                    <tr>

                        <td><?= $item['d_name']; ?></td>

                        <td><?= $item['quantity']; ?></td>

                        <td>
                            Rp <?= number_format($item['price'],0,',','.'); ?>
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

            <button
                class="btn btn-success btn-lg btn-block"
                id="pay-button">

                Bayar Sekarang

            </button>


        </div>

    </div>

</div>
<script>
document.getElementById('pay-button').addEventListener('click', function () {
    console.log("Snap Token:");
console.log("<?= $payment['snap_token']; ?>");
    snap.pay("<?= $payment['snap_token']; ?>", {

        onSuccess: function(result) {

            $.ajax({

                url: "<?= base_url('payment/finish'); ?>",
                type: "POST",
                dataType: "json",

                data: {

                    order_number: result.order_id,
                    transaction_status: result.transaction_status

                },

                success: function(response) {

                    if (response.status) {

                        window.location.href = "<?= base_url('orders'); ?>";

                    } else {

                        alert("Gagal memperbarui status pembayaran.");

                    }

                },

                error: function() {

                    alert("Terjadi kesalahan pada server.");

                }

            });

        },

        onPending: function(result) {

            $.ajax({

                url: "<?= base_url('payment/finish'); ?>",
                type: "POST",
                dataType: "json",

                data: {

                    order_number: result.order_id,
                    transaction_status: result.transaction_status

                },

                success: function() {

                    window.location.href = "<?= base_url('orders'); ?>";

                }

            });

        },

        onError: function(result) {

            $.ajax({

                url: "<?= base_url('payment/finish'); ?>",
                type: "POST",
                dataType: "json",

                data: {

                    order_number: result.order_id,
                    transaction_status: result.transaction_status

                }

            });

            alert("Pembayaran gagal.");

        },

        onClose: function() {

            alert("Anda menutup popup pembayaran.");

        }

    });

});

</script>
</body>

</html>