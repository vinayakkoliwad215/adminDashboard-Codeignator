<!DOCTYPE html>
<html>
<head>
<title>Payment Receipt</title>
<style>
body { font-family: DejaVu Sans; font-size: 13px; }
.table { width: 100%; border-collapse: collapse; margin-top:15px; }
.table th, .table td { border: 1px solid #444; padding: 8px; }
.header-logo { text-align:center; margin-bottom:5px; }
.footer { position: fixed; bottom: 0; left:0; right:0; text-align: center; font-size: 12px; }
.signature { margin-top: 40px; text-align: right; padding-right:40px; font-size: 14px; }
.title { text-align:center; margin-top:5px; font-size: 18px; font-weight:bold; text-decoration: underline; }
</style>
</head>
<body>

<!-- 🔹 1. Logo -->
<div class="header-logo">
  <img src="<?= base_url('uploads/invoce1.png') ?>" width="140">
</div>

<!-- 🔹 2. Title -->
<div class="title">PAYMENT RECEIPT</div>

<!-- 🔹 3. Receipt Date -->
<p style="text-align:right; font-size: 14px;">
  Date: <b><?= date("d-m-Y") ?></b>
</p>

<!-- 🔹 4. Table -->
<table class="table">
  <tr><th>User No</th><td><?= $user->id ?></td></tr>
  <tr><th>User Name</th><td><?= $user->username ?></td></tr>
  <tr><th>Mobile Number</th><td><?= $user->mobilenumber ?></td></tr>
  <tr><th>Email</th><td><?= $user->useremail ?></td></tr>
</table>
<br/>
<table class="table">
    <thead>
        <tr>
            <th>Receipt No</th>
            <th>Payment Date</th>
            <th>Payment Mode</th>
            <th>Deposit Type</th>
            <th>Security Deposit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $t): ?>
        <tr>
            <td><?= $t->id ?></td>
            <td><?= date("d-m-Y", strtotime($t->paymentDate)) ?></td>
            <td><?= $t->payment_mode_name ?></td>
            <td><?= $t->depositType ?></td>
            <td><?= number_format($t->security_depo, 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h3 style="float:right; margin-right:80px;">Total Deposit: <?= number_format($total,2) ?></h3>

<br/>
<br/>

<!-- 🔹 5. Signature -->
<div class="signature">
  <b>Authorized Signature</b><br><br>
  _______________________
</div>

<!-- 🔹 6. Footer -->
<div class="footer">
  Thank you for your payment! • This is a computer generated receipt.
</div>

</body>
</html>
