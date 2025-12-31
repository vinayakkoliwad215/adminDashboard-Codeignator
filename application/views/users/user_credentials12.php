<div class="container-fluid p-0">
  <h2 class="text-center mb-3" style="color:green"><?= $title ?></h2>

  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center w-100">
        <!-- Middle: Export buttons holder -->
        <div id="exportButtons"></div>

        <!-- Right: Search box holder -->
        <div id="dataTableSearch"></div>
      </div>
    </div>

    <div class="card-body">
      <div id="alert-div"></div>
      <table class="table table-bordered display" id="userCredentialTable">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Status</th>
            <th>Select</th>
          </tr>
        </thead>
      </table>

        <button id="sendSmsEmailBtn" onclick="sendSmsAndEmail()" class="btn btn-primary">
          <i class="fa fa-paper-plane"></i> Send SMS & Email
        </button>
        <span id="smsEmailLoader" style="display:none; margin-left:10px;">
          <i class="fa fa-spinner fa-spin"></i> Sending...
        </span>
    </div>
  </div>
</div>