<div class="container-fluid p-0">
  <h2 class="text-center mb-3" style="color:green"><?= $title ?></h2>
  
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="card-body">
                    <h2 style="text-align:Center;font: size 20px;text-transform: uppercase;">Edit Branch Details</h2>
                     <div>
                        <a class="btn btn-primary mb-3" href="<?= base_url('branches'); ?>">
                            <i class="fa fa-list-ul"></i> List Of Branches
                        </a>
                    </div>
                    <form method="POST" action="<?= base_url('branches/update/'.$branch->id); ?>">
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $branch->name ?>">
                            </div>    
                        </div>

                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Head</label>
                                <input type="text" name="head" class="form-control" value="<?= $branch->head ?>">
                            </div>    
                        </div>
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>PhoneNumber</label>
                                <input type="text" name="phone_number" class="form-control" value="<?= $branch->phone_number ?>">
                            </div>
                        </div>

                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?= $branch->email ?>">
                            </div>
                        </div>
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Address</label>
                                <textarea name="address" class="form-control"><?= $branch->address ?></textarea>
                            </div>
                        </div>
                        <div class="field-wrapper">
                            <div class="mb-2">
                                <label>Website URL</label>
                                <input type="text" name="website_url" class="form-control" value="<?= $branch->website_url ?>">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="<?= base_url('branches'); ?>" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>