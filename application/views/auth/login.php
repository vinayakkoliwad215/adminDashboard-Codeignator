<!DOCTYPE html>
<html>
<head>
    <title>Login with OTP</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            min-height: 100vh;
            background: url("<?= !empty($setting->background_image) ? base_url($setting->background_image) : '' ?>") no-repeat center center fixed;
            background-size: cover;
        }

        .login-card {
            background: 
                <?php if (!empty($setting->login_background)): ?>
                    url("<?= base_url($setting->login_background) ?>") no-repeat center center;
                <?php else: ?>
                    #ffffff;
                <?php endif; ?>
            background-size: cover;
            border-radius: 10px;
            top:45px;
        }

        .login-logo {
            max-height: 80px;
            margin: 0 auto 15px;
            display: block;

            /* 🔥 Makes white background appear transparent */
            
        }

        .overlay {
            background: rgba(255,255,255,0.90);
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card p-3 shadow login-card">
                                    <!-- LOGO -->
                    <?php if (!empty($setting->logo_image)): ?>
                        <img src="<?= base_url($setting->logo_image) ?>" class="login-logo">
                    <?php endif; ?>
                <div class="overlay">



                    <h2 class="text-center">Login</h2>

                    <div id="alert-box"></div>

                    <div id="step1">
                        <div class="form-group">
                            <input type="text" id="username" placeholder="Enter the Username" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="password" id="password" placeholder="Enter the Password" class="form-control">
                        </div>

                        <button class="btn btn-primary btn-block" id="sendOtpBtn">
                            Login / Send OTP
                        </button>
                    </div>

                    <div id="step2" style="display:none;">
                        <div class="form-group">
                            <input type="text" id="otp" placeholder="Enter OTP" class="form-control">
                        </div>

                        <button class="btn btn-primary btn-block" id="verifyOtpBtn">
                            Verify OTP
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- 🔒 YOUR EXISTING JS (UNCHANGED) -->
<script>
//Send OTP
$("#sendOtpBtn").click(function() {

    Swal.fire({
        title: "Processing...",
        text: "Sending OTP, please wait...",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.post("<?= base_url('login/send-otp'); ?>", {
        username: $("#username").val(),
        password: $("#password").val()
    }, function(res) {

        Swal.close();

        let r = JSON.parse(res);

        if (r.status && r.direct === true) {
            $("#alert-box").html('<div class="alert alert-success">'+ r.message +'</div>');
            setTimeout(() => {
                window.location.href = "<?= base_url('dashboard'); ?>";
            }, 800);
            return;
        }

        if (r.status && r.direct === "otp_sent") {
            $("#alert-box").html('<div class="alert alert-success">'+ r.message +'</div>');
            $("#step1").hide();
            $("#step2").show();
            return;
        }

        $("#alert-box").html('<div class="alert alert-danger">'+ r.message +'</div>');
    })
    .fail(function () {
        Swal.close();
        $("#alert-box").html('<div class="alert alert-danger">Server error. Please try again.</div>');
    });
});

//verifyOtpBtn
$("#verifyOtpBtn").click(function() {

    Swal.fire({
        title: "Verifying OTP...",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.post("<?= base_url('login/verify-otp'); ?>", {
        username: $("#username").val(),
        otp: $("#otp").val()
    }, function(res) {

        Swal.close();

        let r = JSON.parse(res);

        if (r.status) {
            $("#alert-box").html('<div class="alert alert-success">'+ r.message +'</div>');
            setTimeout(() => {
                window.location.href = "<?= base_url('dashboard'); ?>";
            }, 1000);
        } else {
            $("#alert-box").html('<div class="alert alert-danger">'+ r.message +'</div>');
            $("#otp").val('');
        }

        setTimeout(() => $("#alert-box").html(''), 3000);
    })
    .fail(function () {
        Swal.close();
        $("#alert-box").html('<div class="alert alert-danger">OTP verification failed.</div>');
    });
});
</script>

</body>
</html>
