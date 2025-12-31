<div class="container-fluid p-0">
  <h2 class="text-center mb-3" style="color:green"><?= $title ?></h2>

  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center w-100">
        <div>
          <button class="btn btn-primary" onclick="createTransaction()">
            <i class="fa fa-plus-square"></i> Create Payment
          </button>
        </div>
        <div id="exportButtons"></div>
        <div id="dataTableSearch"></div>
      </div>
    </div>

    <div class="card-body">
      <div id="alert-div"></div><br/>
      <div class="card mb-3 p-3" style="background:hsla(0, 0%, 97%, 0.84)">
        <div class="row">
          <div class="col-md-3">
            <label><b>Payment Mode</b></label>
            <select id="filter_payment_mode" class="form-control">
              <option value="">- All Modes -</option>
            </select>
          </div>

          <div class="col-md-3">
            <label><b>Payment Date</b></label>
              <input type="date" id="date_from" class="form-control">
              <input type="date" id="date_to" class="form-control">
          </div>
          <div class="col-md-3">
            <br/>
            <button id="filterBtn" class="btn btn-primary w-100">
              <i class="fa fa-filter"></i> Filter
            </button>
            <br/> <br/>
            <button id="resetFilterBtn" class="btn btn-secondary w-100">
              <i class="fa fa-times"></i> Reset
            </button>
          </div>
        </div>
      </div>

      <div id="payment-mode-buttons"></div>
        <div id="pdf-area">
          <!-- <div id="pdf-wrapper"></div> -->
        <marquee behavior="scroll" direction="left" scrollamount="5">
          <h6 style="color:red;font: size 20px;"> This table showing the records for the User Payment Transaction Details List 2025-26</h6>
        </marquee>

        <table class="table table-bordered display" id="paymentTransactionsTable">
          <thead>
            <tr>
              <th>User Id</th>
              <th>UserName, <br/> Mobile</th>
              <th>Payment Date</th>
              <th>Payment Mode</th>
              <th>Deposit Amount <br/>Deposit Type </th>
              <th>Total Deposit</th>
              <th width="80">Action</th>
            </tr>
          </thead>
          <tbody id="paymentBody"></tbody>
        </table>
        </div>
  </div>
</div>
</div>

<!-- Create / Update Modal -->
<div class="modal" id="transaction-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Transaction</h5>
        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
      </div>
      <div class="modal-body">
        <div id="modal-alert-div"></div>
        <form id="transaction-form">
          <input type="hidden" id="update_id">

          <div class="form-group">
            <label>User</label>
            <select id="user_id" class="form-control" required></select>
          </div>

          <div class="form-group">
            <label>Payment Date</label>
            <input type="date" id="paymentDate" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Payment Mode</label>
            <select id="payment_mode_id" class="form-control" required></select>
          </div>

          <div class="form-group">
            <label>Deposit Type</label>
            <select id="deposit_type_id" class="form-control" required></select>
          </div>

          <div class="form-group">
            <label>Amount</label>
            <input type="number" id="security_depo" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Note / Remark</label>
            <input type="text" id="note" class="form-control">
          </div>

          <button type="submit" class="btn btn-outline-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- View Modal For the payment transactions -->
<div class="modal" id="viewTransactionsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Payment Transaction History</h5>
        <button type="button" class="close" onclick="closeViewModal()"><span>×</span></button>
      </div>
      <div class="modal-body">
        <!-- USER INFO -->
        <div class="row mb-2" style="font-size: 16px; font-weight: 600;">
            <div class="col-md-4">User Id : <span id="v_userid"></span></div>
            <div class="col-md-4">Username : <span id="v_username"></span></div>
            <div class="col-md-4">Mobile Number : <span id="v_mobile"></span></div>
        </div>
        <div class="row mb-3" style="font-size: 16px; font-weight: 600;">
            <div class="col-md-12">Note : <span id="v_note"></span></div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Payment Date</th>
                    <th>Payment Mode</th>
                    <th>Deposit Type</th>
                    <th>Amount</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody id="viewPaymentsBody"></tbody>
        </table>
        <!-- TOTAL DEPOSIT -->
        <h5 class="text-right mt-3">Total Deposit: 
          <b style="color:green; font-size:18px;">₹ <span id="totalDeposit"></span></b>
        </h5>
      </div>
    </div>
  </div>
</div>
