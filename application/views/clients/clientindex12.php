<div class="container-fluid p-0">
  <h2 class="text-center mb-3" style="color:green;text-transform: uppercase;"><?= $title ?></h2>

  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center w-100">
        <!-- Left: Create -->
        <div>
          <a class="btn btn-primary mb-3" href="<?= base_url('clients'); ?>">
            <i class="fa fa-plus-square"></i> Create Clients
        </a>
        </div>
          
        <!-- Middle: Export buttons holder -->
        <div id="exportButtons"></div>

        <!-- Right: Search box holder -->
        <div id="dataTableSearch"></div>
      </div>
    </div>

    <div class="card-body">
      <div id="alert-div"></div>
      <table class="table table-bordered display" id="clientTable">
        <thead class="thead-light">
        <tr>
          <th>ID</th>
          <th>Client Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Designation</th>
          <th>Department</th>
          <th width="80px">Action</th>
        </tr>
      </thead>
      <tbody id="clients-table-body"></tbody>
  </table>
  </div>
  </div>
</div>