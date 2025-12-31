<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="color:darkgreen"><?= $title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <div id="alert-div"></div>
    </section>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#create">General Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#update">Comming Soon</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <!-- Create Tab -->
                            <div id="create" class="tab-pane fade show active">
                                <form id="createForm" action="<?= base_url('generalSettings/store') ?>" method="post">
                                    <input type="hidden" name="id" value="<?= $setting->id ?? '' ?>">
                                    <?php $this->load->view('settings/general_setting_form'); ?>
                                    <button class="btn btn-success btn-block">
                                        <?= isset($setting) ? 'Update Settings' : 'Save Settings' ?>
                                    </button>
                                </form>
                            </div>
                            <!-- Update Tab -->
                            <div id="update" class="tab-pane fade">
                                <form>
                                    <h1>Comming Soon..</h1>
                                </form>
                                   
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
// Tab switching with validation reset
$('#myTab a').on('click', function () {
    $('form').trigger("reset");
    $('.text-danger').remove();
});

$(document).ready(function () {
    setTimeout(function () {
        $(".alert.alert-success").fadeOut("slow");
    }, 3000);
});

// Frontend Validation
$("form").on("submit", function(e){
    let valid = true;
    $(this).find("input[required]").each(function(){
        if ($(this).val().trim() === "") {
            valid = false;
            if (!$(this).next().hasClass("text-danger")) {
                $(this).after('<span class="text-danger">Required</span>');
            }
        } else {
            $(this).next(".text-danger").remove();
        }
        setTimeout(function() {
            $(".alert alert-success").html('');
        }, 3000);
    });
    
    if (!valid) {
        e.preventDefault();
    }
});
</script>