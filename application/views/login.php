<!DOCTYPE html>
<html>
<head>
    <title>Login with OTP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h4 class="text-center mb-3">Login with OTP</h4>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('send-otp'); ?>">
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" required 
                               placeholder="Enter Mobile Number">
                    </div>

                    <button class="btn btn-primary btn-block">Send OTP</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
