  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="color:green"><?= $title ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="client">
      <a class="btn btn-primary mb-3" href="<?= base_url('clients/list'); ?>">
        <i class="fa fa-list-ul"></i> List Of Clients
      </a>
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <marquee behavior="scroll" direction="left" scrollamount="5">
          <h6 style="color:Blue;font: size 20px;"> This Form Auto Saving the Client Details</h6>
        </marquee>
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <div class="card-header">
                <h2 style="font: size 12px;text-transform: uppercase;">Auto Save Clients Details</h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <div class="mb-2">
                    <label><b>Name</b></label>
                    <input type="text" id="name" class="form-control auto">
                    <div id="err_name" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label><b>Email Id</b></label>
                    <input type="text" id="email" class="form-control auto">
                    <div id="err_email" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label><b>Phone</b></label>
                    <input type="text" id="phone" class="form-control auto">
                    <div id="err_phone" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label><b>Designation</b></label>
                    <input type="text" id="designation" class="form-control auto">
                    <div id="err_designation" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label><b>Department</b></label>
                    <input type="text" id="department" class="form-control auto">
                    <div id="err_department" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label><b>Address</b></label>
                    <textarea id="address" class="form-control auto"></textarea>
                    <div id="err_address" class="error-msg"></div>
                    <span id="finalSavedMsg" style="color: green; font-weight: bold; display: none;">
                      ✓ All details saved!
                    </span>
                  </div>
                  <input type="hidden" id="emp_id" value="">
              </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
</div>
<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
let timer;
let validationStatus = {
    name:false, email:false, phone:false,
    designation:false, department:false, address:false
};

function validate(field){
    let val = $("#"+field).val().trim();
    let error = "";

    switch(field){
        case "name":
            if(val.length < 3) error = "Name must be at least 3 characters.";
            break;

        case "email":
            let emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!emailReg.test(val)) error = "Enter a valid email.";
            break;

        case "phone":
            if(!/^\d{10}$/.test(val)) error = "Phone must be 10 digits.";
            break;

        case "designation":
            if(val.length < 3) error = "Designation must be at least 3 characters.";
            break;

        case "department":
            if(val.length < 2) error = "Department must be at least 2 characters.";
            break;

        case "address":
            if(val.length < 5) error = "Address must be at least 5 characters.";
            break;
    }

    if(error !== ""){
        validationStatus[field] = false;
        $("#err_"+field).text(error);
        $("#"+field).removeClass("input-warning input-success").addClass("input-error");
    } else {
        validationStatus[field] = true;
        $("#err_"+field).text("");
        $("#"+field).removeClass("input-warning input-error").addClass("input-warning");
    }

    return (error === "");
}

// APPLY WARNING FIRST
$(".auto").addClass("input-warning");

// TYPING — LIVE VALIDATION
$(".auto").on("keyup", function(){
    let field = $(this).attr("id");
    validate(field);
});

// ON BLUR — IF VALID → SAVE
$(".auto").on("blur", function(){
    let field = $(this).attr("id");

    if(validate(field)){
        autoSave(field);
    }
});

function autoSave(field){

    let emp_id = $("#emp_id").val();

    $.ajax({
        url: $('meta[name=app-url]').attr("content") + "clients/auto-save",
        type: "POST",
        data: {
            id: emp_id,
            name: $("#name").val(),
            email: $("#email").val(),
            phone: $("#phone").val(),
            designation: $("#designation").val(),
            department: $("#department").val(),
            address: $("#address").val(),
        },
        success:function(resp){
            let res = JSON.parse(resp);
            $("#emp_id").val(res.emp_id);

            // Green + Tick
            $("#"+field)
                .removeClass("input-warning input-error")
                .addClass("input-success");

            checkAllCompleted();
        }
    });
}

// AFTER ALL FIELDS ARE SUCCESSFULLY SAVED
function checkAllCompleted(){
    if(Object.values(validationStatus).every(v => v === true)){
    $("#finalSavedMsg").fadeIn();
        Swal.fire({
            icon: 'success',
            title: 'All fields saved successfully!',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
                // Hide saved message again
                $("#finalSavedMsg").hide();
            }, 1000); // wait 1 sec before SweetAlert
    }
}

 function resetForm() {

    // Clear input values
    $(".auto").val("");

    // Remove all validation classes
    $(".auto").removeClass("input-warning input-error input-success");

    // Clear error messages
    $(".error-msg").text("");

    // Reset validation status
    validationStatus = {
        name:false, email:false, phone:false,
        designation:false, department:false, address:false
    };

    // Reapply initial yellow border
    $(".auto").addClass("input-warning");

     // Clear hidden ID
    $("#emp_id").val("");
}
</script>