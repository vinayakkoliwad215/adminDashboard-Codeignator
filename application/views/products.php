<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="app-url" content="<?= base_url(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="stylesheet" 
      href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <link rel="stylesheet" 
      href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<style>
@media (max-width: 768px) {
    .modal-body .form-group label {
        font-size: 14px;
    }
    .btn {
        margin-bottom: 8px;
    }
}
</style>

</head>
<body>

<div class="container">
    <h2 class="text-center mt-5 mb-3"><?php echo $title; ?></h2>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" onclick="createProduct()"> 
                <i class="fa fa-plus-square"> Create New Product</i>
            </button>
        </div>
        <div class="card-body">
            <div id="alert-div"></div>
            <div class="table-responsive">
                <table id="productTable" class="table table-bordered display">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <!-- <th>Description</th> -->
                            <th>Price</th>
                            <th>Status</th>
                            <th width="240px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="products-table-body"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- modal for creating and editing -->
<div class="modal" tabindex="-1" role="dialog" id="form-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Product Form</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>×</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modal-alert-div"></div>
        
        <form>
            <input type="hidden" id="update_id">

            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" id="description" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" id="price">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-outline-primary" id="save-product-btn">
              Save Product
            </button>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- view record modal -->
<div class="modal" tabindex="-1" role="dialog" id="view-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Product Information</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>×</span>
        </button>
      </div>
      <div class="modal-body">
        <b>Name:</b>
        <p id="name-info"></p>

        <b>Description:</b>
        <p id="description-info"></p>

        <b>Price:</b>
        <p id="price-info"></p>

        <b>Status:</b>
        <p id="status-info"></p>
      </div>
    </div>
  </div>
</div>
</body>
</html>