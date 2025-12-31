<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h4 class="text-center mb-3">Verify OTP</h4>

                <p class="text-center text-muted">
                    OTP sent to <strong><?= $mobile; ?></strong>
                </p>

                <form method="post" action="<?= base_url('verify-otp'); ?>">

                    <input type="hidden" name="mobile" value="<?= $mobile; ?>">

                    <div class="form-group">
                        <label>Enter OTP</label>
                        <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
                    </div>

                    <button class="btn btn-success btn-block">Verify OTP</button>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>
