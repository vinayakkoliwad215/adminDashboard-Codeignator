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
        <br/><br/><br/>
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <div class="card-header">
                <h2 style="font-size:18px;text-transform: uppercase;">Edit Branch</h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form id="branchUpdateForm">
                    <input type="hidden" id="update_id" value="<?= $branch->id ?>">
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?= $branch->name ?>">
                            </div>    
                        </div>

                        <div class="field-wrapper">
                            <div class="mb-2">
                               <label>Head</label>
                                <input type="text" id="head" name="head" class="form-control" value="<?= $branch->head ?>">
                            </div>
                        </div>
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>PhoneNumber</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control" value="<?= $branch->phone_number ?>">
                            </div>
                        </div>

                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?= $branch->email ?>">
                            </div>
                        </div>

                        <div class="field-wrapper">
                            <div class="mb-2">
                               <label>Address</label>
                                <textarea id="address" name="address" class="form-control"><?= $branch->address ?></textarea>
                            </div>
                        </div>
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Website URL</label>
                                <input type="text" id="website_url" name="website_url" class="form-control" value="<?= $branch->website_url ?>">
                            </div>
                        </div>
                        <br>
                         <button type="submit" class="btn btn-success">Update</button>
                        <a href="<?= base_url('branches'); ?>" class="btn btn-secondary">Back</a>
                    </form>
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
<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
$("#branchUpdateForm").on("submit", function(e){
    e.preventDefault(); // 🔴 STOP normal submit

    let id = $("#update_id").val();
    let url = $('meta[name=app-url]').attr("content") + "branches/update/" + id;

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
            // Store message for redirect page
            sessionStorage.setItem("branch_success", res.message);

            // Redirect to list page
            window.location.href = "<?= base_url('branches'); ?>";
        }
    }).fail(function(xhr){
        console.error(xhr.responseText);
    });
});
</script>
