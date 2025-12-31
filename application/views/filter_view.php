<div class="container-fluid p-0">
  <h2 class="text-center mb-3" style="color:green">User Payments</h2>

  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center w-100">
        <div>
            <h1>Filter the Records Based on the Payment Modes</h1>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div id="alert-div"></div><br/>
      <div class="card mb-3 p-3" style="background:hsla(0, 0%, 97%, 0.84)">
        <div class="row">
            <div class="col-md-3">
                <label>Select Payment Mode:</label>
                <select id="payment_mode_dropdown" class="form-control">
                    <option value=""> -- All -- </option>
                    <?php foreach($payment_modes as $pm): ?>
                        <option value="<?= $pm->id ?>"><?= $pm->payment_mode ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button id="filterBtn" class="btn btn-primary w-100">
                <i class="fa fa-filter"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <button id="resetBtn" disabled class="btn btn-secondary w-100">
                <i class="fa fa-times"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <div id="paymentModeButtons"></div>

    <h3 id="totalAmount">Total Amount: 0.00</h3>

    <table id="paymentTabl" class="table table-bordered display">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Payment Mode</th>
                <th>Deposit Type</th>
                <th>Payment Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    </div>
  </div>
</div>
</div>