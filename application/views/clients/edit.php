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
                <form method="POST" action="<?= base_url('clients/update/'.$client->id); ?>">
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $client->name ?>">
                            </div>    
                        </div>

                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="<?= $client->email ?>">
                            </div>
                        </div>
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?= $client->phone ?>">
                            </div>
                        </div>

                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Designation</label>
                                <input type="text" name="designation" class="form-control" value="<?= $client->designation ?>">
                            </div>
                        </div>

                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Department</label>
                                <input type="text" name="department" class="form-control" value="<?= $client->department ?>">
                            </div>
                        </div>
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Address</label>
                                <textarea name="address" class="form-control"><?= $client->address ?></textarea>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="<?= base_url('clients/list'); ?>" class="btn btn-secondary">Back</a>
                    </form>
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

