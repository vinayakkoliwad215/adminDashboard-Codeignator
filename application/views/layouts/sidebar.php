<div class="col-md-2 p-0 sidebar sidebarmenus">
  <nav class="nav flex-column p-2">
    <a class="nav-link" href="<?= base_url('dashboard') ?>">
      <i class="fa fa-tachometer"></i>
      Dashboard
    </a>
    <a class="nav-link" href="<?= base_url('products') ?>">
      <i class="fa fa-shopping-cart"></i> Products
    </a>
    <a class="nav-link" href="<?= base_url('users') ?>">
      <i class="fa fa-users"></i> Users
    </a>
    <a class="nav-link" href="<?= base_url('payment-modes') ?>">
      <i class="fa fa-credit-card"></i> Payment Modes
    </a>
    <a class="nav-link" href="<?= base_url('deposit-types') ?>">
      <i class="fas fa-piggy-bank"></i> Deposit Types
    </a>
    <a class="nav-link" href="<?= base_url('users-credentials') ?>">
      <i class="fa fa-user-lock"></i> User Credentials
    </a>
    <a class="nav-link" href="<?= base_url('users-payments') ?>">
      <i class="fa fa-inr"></i> Payment Transactions
    </a>
    <a class="nav-link" href="<?= base_url('clients') ?>">
      <i class="fa fa-address-book"></i> Clients
    </a>
    <a class="nav-link" href="<?= base_url('branches') ?>">
      <i class="fa fa-university"></i> Branches
    </a>
  </nav>
  <!-- Reports Main Menu -->
  <div class="nav-item">
    <a class="nav-link d-flex justify-content-between <?= (in_array(uri_string(), ['sms-reports','email-reports']) ? 'active' : '') ?>"
      data-toggle="collapse"
      href="#reportsMenu"
      role="button"
      aria-expanded="<?= (in_array(uri_string(), ['sms-reports','email-reports']) ? 'true' : 'false') ?>"
      aria-controls="reportsMenu">
      <span><i class="fa fa-flag-o"></i> Reports</span>
      <i class="fa fa-chevron-down"></i>
    </a>

    <div class="collapse <?= (in_array(uri_string(), ['sms-reports','email-reports']) ? 'show' : '') ?>" id="reportsMenu">
      <nav class="nav flex-column ml-3">
        <a class="nav-link <?= (uri_string()=='sms-reports' ? 'active' : '') ?>" href="<?= base_url('sms-reports') ?>">
          <i class="fa fa-comment"></i> SMS Reports
        </a>
        <a class="nav-link <?= (uri_string()=='email-reports' ? 'active' : '') ?>" href="<?= base_url('email-reports') ?>">
          <i class="fa fa-envelope"></i> Email Reports
        </a>
      </nav>
    </div>
  </div>
   <nav class="nav flex-column p-2">
    <a class="nav-link <?= (uri_string()=='generalSettings'?'active':'') ?>" href="<?= base_url('generalSettings') ?>">
      <i class="fa fa-cog"></i>
      General Settings
    </a>
    <a class="nav-link" href="<?= base_url('logout') ?>">
      <i class="fa fa-power-off"></i> Logout
    </a>

  </nav>
</div>
<div class="col-md-10 p-3">
