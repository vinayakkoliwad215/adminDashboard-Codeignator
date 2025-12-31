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
      <table class="table table-bordered display" id="loginEmailTable">
        <thead>
          <tr>
            <th>Id</th>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Message Data</th>
            <th>Response Data</th>
            <th>status</th>
            <th>Date/Time</th>
          </tr>
        </thead>
      </table>
    </div>
    </div>
  </div>