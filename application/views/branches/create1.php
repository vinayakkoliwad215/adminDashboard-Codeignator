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
    <div class="branch">
        <a class="btn btn-primary mb-3" href="<?= base_url('branches'); ?>">
        <i class="fa fa-list-ul"></i> List Of Branches
        </a>
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <br/><br/><br/>
        <div id="alert-div"></div>
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <div class="card-header">
                <h2 style="font-size:18px;text-transform: uppercase;">Create Branch</h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form id="branchForm">
                <div class="form-group">
                  <div class="mb-2">
                    <label>Name:</label><br>
                    <input type="text" name="name" id="name" class="form-control" required>
                    <div id="err_name" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label>Head:</label><br>
                    <input type="text" name="head" id="head" class="form-control" required>
                    <div id="err_head" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label>Phone Number:</label><br>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                    <div id="err_phone_number" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label>Email:</label><br>
                    <input type="email" id="email" name="email"class="form-control"  required>
                    <div id="err_email" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label>Address:</label><br>
                    <textarea id="address"  name="address" class="form-control" required></textarea>
                    <div id="err_address" class="error-msg"></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-2">
                    <label>Website URL:</label><br>
                    <input type="text" name="website_url" id="website_url" class="form-control">
                    <div id="err_website_url" class="error-msg"></div>
                  </div>
              </div>
              <button type="submit" class="btn btn-success">Save</button>
                <!-- /.card-body -->
            </form>
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
$("#branchForm").on("submit", function(e){
    e.preventDefault();

    let url = $('meta[name=app-url]').attr("content") + "branches/store";

    let data = {
        name: $("#name").val().trim(),
        head: $("#head").val().trim(),
        phone_number: $("#phone_number").val().trim(),
        email: $("#email").val().trim(),
        address: $("#address").val().trim(),
        website_url: $("#website_url").val().trim()
    };

    // 🔒 FRONTEND VALIDATION
    if(
        data.name === "" ||
        data.head === "" ||
        data.phone_number === "" ||
        data.email === "" ||
        data.address === ""
    ){
        $("#alert-div").html(
          '<div class="alert alert-danger">All required fields must be filled</div>'
        );
        return;
    }

    $.post(url, data, function(response){
        let res = JSON.parse(response);

        if(res.status){
            // Store message temporarily
            sessionStorage.setItem("branch_success", res.message);

            // Redirect
            window.location.href = "<?= base_url('branches'); ?>";
        }
    }).fail(function(xhr){
        console.error(xhr.responseText);
    });
});

</script>