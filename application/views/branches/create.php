<div class="container-fluid p-0">
  <h2 class="text-center mb-3" style="color:green"><?= $title ?></h2>

  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center w-100">
        <div class="card-body">
        <div>
          <a class="btn btn-primary mb-3" href="<?= base_url('branches'); ?>">
            <i class="fa fa-list-ul"></i> List Of Branches
          </a>
        </div>

        <form method="post" action="<?= base_url('branches/store') ?>">

                    <div class="field-wrapper">
          <div class="mb-2">
            <label>Name:</label><br>
            <input type="text" name="name" class="form-control" required>
            </div>
</div>

        <div class="field-wrapper">
          <div class="mb-2">
            <label>Head:</label><br>
            <input type="text" name="head" class="form-control" required>
            </div>
</div>

                    <div class="field-wrapper">
          <div class="mb-2">
            <label>Phone Number:</label><br>
            <input type="text" name="phone_number" class="form-control" required>
            </div>
</div>

                    <div class="field-wrapper">
          <div class="mb-2">
            <label>Email:</label><br>
            <input type="email" name="email"class="form-control"  required>
            </div>
</div>

                    <div class="field-wrapper">
          <div class="mb-2">
            <label>Address:</label><br>
            <textarea name="address" class="form-control" required></textarea>
            </div>
</div>

                    <div class="field-wrapper">
          <div class="mb-2">
            <label>Website URL:</label><br>
            <input type="text" name="website_url" class="form-control">
</div>
</div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
        </div>
    </div>
</div>    