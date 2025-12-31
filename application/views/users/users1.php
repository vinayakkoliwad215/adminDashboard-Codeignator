<div class="container-fluid p-0">
  <h2 class="text-center mb-3" style="color:green"><?= $title ?></h2>

  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center w-100">

        <!-- Left: Create -->
        <div>
          <button class="btn btn-primary" onclick="createUser()">
            <i class="fa fa-plus-square"></i> Create User
          </button>
        </div>

        <!-- Middle: Export buttons holder -->
        <div id="exportButtons"></div>

        <!-- Right: Search box holder -->
        <div id="dataTableSearch"></div>

      </div>
    </div>

    <div class="card-body">
      <div id="alert-div"></div>
        <div id="payment-mode-buttons"></div>
        <br/>
      <table class="table table-bordered display" id="userTable">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Status</th>
            <th>Login OTP</th>
            <th width="220px">Action</th>
          </tr>
        </thead>
        <tbody id="users-table-body"></tbody>
      </table>
    </div>
  </div>
</div>
<!-- Modal: form -->
<div class="modal" id="form-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Form</h5>
        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
      </div>
      <div class="modal-body">
        <div id="modal-alert-div"></div>
        <form id="user-form">
          <input type="hidden" id="update_id">

          <div class="form-group">
            <label>Username</label>
            <input type="text" id="username" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Mobile</label>
            <input type="text" id="mobilenumber" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" id="useremail" class="form-control" required>
          </div>

          <div class="form-group" id="passwordBox">
            <label>Password</label>
            <input type="password" id="password" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" id="date_of_birth" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Security Deposit Amount</label>
            <input type="text" class="form-control" id="security_depo" required>
          </div>

          <div class="form-group">
            <label>Payment Mode</label>
            <select id="payment_mode" class="form-control" require>
              <option value="">Select Payment Mode</option>
            </select>
          </div>

          <div class="form-group">
            <label>Status</label>
            <select id="status" class="form-control" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <button type="submit" id="save-user-btn" class="btn btn-outline-primary">Save User</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal: view -->
<div class="modal" id="view-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Details</h5>
        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
      </div>
      <div class="modal-body">
        <b>Username:</b><p id="username_info"></p>
        <b>Mobile:</b><p id="mobilenumber_info"></p>
        <b>Email:</b><p id="useremail_info"></p>
        <b>Status:</b><p id="status_info"></p>
      </div>
    </div>
  </div>
</div>