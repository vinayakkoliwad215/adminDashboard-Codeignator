<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="color:green"><?= $title ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><?= $title ?></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
    <div id="alert-div"></div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-12">
            <div class="card">
              <div class="card-header">   
                <h3 class="card-title"><?= $tableName ?></h3>
                <button class="btn btn-primary" id="createBtn" onclick="createUser()">
                  <i class="fa fa-plus-square"></i> Create User
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="userTable" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Branch Names</th>
                    <th>Login OTP</th>
                    <th width="100px">Action</th>
                  </tr>
                </thead>
                <tbody id="user-table-body"></tbody>
                <tfoot>
                  <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Branch Names</th>
                    <th>Login OTP</th>
                    <th width="100px">Action</th>
                  </tr>
                </tfoot>
              </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
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
            <label>Branches</label>
            <select name="branch_id[]" id="branch_id" class="form-control" multiple required>
                <?php foreach ($branches as $b): ?>
                    <option value="<?= $b->id ?>"><?= $b->name ?></option>
                <?php endforeach; ?>
            </select>
            <small class="text-muted">Hold Ctrl to select multiple</small>
          </div>

          <div class="form-group">
            <label>Status</label>
            <select id="status" class="form-control" required>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
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
        <b>Branches:</b>
        <div id="branches_info"></div>
        <b>Status:</b><p id="status_info"></p>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
var userTable=null;

$(document).ready(function(){
  showAllUsers();
  loadPaymentModeButtons();

  // handle form submit (create / update)
  $("#user-form").on('submit', function(e){
    e.preventDefault();
    if ($("#update_id").val() == "") {
      storeUser();
    } else {
      updateUser();
    }
  });
});

$(document).on('change', '.otpToggle', function () {
    let id = $(this).data("id");
    let otp_status = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: $('meta[name=app-url]').attr("content") + "users/update_otp_status",
        type: "POST",
        data: {
            id: id,
            otp_status: otp_status
        },
        dataType: "json",
        success: function (res) {

            Swal.fire({
                icon: otp_status == 1 ? 'success' : 'warning',
                title: res.message,
                timer: 1500,
                showConfirmButton: false
            });
        },
        error: function (xhr) {
            Swal.fire("Error", xhr.responseText, "error");
            console.log(xhr.responseText);
        }
    });

});
//formated date
function formatDate(d) {
  let date = new Date(d);

  const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

  let formattedDate =
    ("0" + date.getDate()).slice(-2) + "-" +
    ("0" + (date.getMonth() + 1)).slice(-2) + "-" +
    date.getFullYear();

  let weekday = days[date.getDay()];

  return formattedDate + "<br><small class='text-primary'> - " +   weekday+ "</small>";
}

//branches show the numbers
function formatBranches(branchNames) {
    if (!branchNames) {
        return '<span class="text-muted">No branches</span>';
    }

    let branches = branchNames.split(',');
    let html = '<ol style="padding-left:18px;margin:0">';

    branches.forEach(function(name){
        html += '<li>' + escapeHtml(name.trim()) + '</li>';
    });

    html += '</ol>';
    return html;
}


/** Load all Users */
function showAllUsers() {

    let url = $('meta[name=app-url]').attr("content") + "users/show_all";

    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (users) {

            // Destroy old DataTable if exists
            if (userTable !== null) {
                $('#userTable').DataTable().clear().destroy();
                $('#user-table-body').empty();
            }

            let row = '';
            let totalSecurity = 0;
            let paymentTotals = {};

            for (let i = 0; i < users.length; i++) {

                let sec = users[i].security_depo ? parseFloat(users[i].security_depo) : 0;
                totalSecurity += sec;

                let mode = users[i].payment_mode_name || 'N/A';
                if (!paymentTotals[mode]) paymentTotals[mode] = 0;
                paymentTotals[mode] += sec;

                let dob = users[i].date_of_birth ? formatDate(users[i].date_of_birth) : '';

                let editBtn = '<button class="btn btn-success btn-sm" title="Edit User" onclick="editUser(' + users[i].id + ')">' +
                    '<i class="fa fa-edit"></i></button>';

                let showBtn = '<button class="btn btn-info btn-sm" title="View User" onclick="viewUser('+users[i].id+')">' +
                        '<i class="fa fa-eye"></i></button>';

                let deleteBtn =
                    '<button class="btn btn-danger btn-sm"  title="Delete User" onclick="destroyUser('+ users[i].id+')">' +
                    '<i class="fa fa-trash"></i></button>';

                row += '<tr>' +
                    '<td>' + users[i].display_user_id + '</td>' +
                    '<td>' + users[i].username + '</td>' +
                    '<td>' + users[i].mobilenumber + '</td>' +
                    '<td>' + users[i].useremail + '</td>' +
                    '<td>' + dob + '</td>' +
                    '<td>' + formatBranches(users[i].branch_names) + '</td>' +
                   
                    '<td>' +
                        '<input type="checkbox" class="otpToggle" data-id="' + users[i].id + '" ' +
                        (users[i].otp_status == 1 ? 'checked' : '') + '>' +
                    '</td>' +
                   '<td class="text-center">' +
                        editBtn + ' ' + deleteBtn + ' ' + showBtn +
                        '<br>' +
                            '<span class="badge ' +
                            (users[i].status == 1 ? 'badge-success' : 'badge-danger') +
                        '">' +
                            (users[i].status == 1 ? 'Active' : 'Inactive') +
                        '</span>' +
                    '</td>' +

                    '</tr>';
            }

            $("#user-table-body").append(row);

            // Initialize DataTable
            userTable = $("#userTable").DataTable({
                autoWidth: false,
                responsive: true,
                paging: true,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                dom:
                    "<'row mb-2'<'col-md-6 d-flex align-items-center'B><'col-md-6 text-right'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-secondary buttons-copy buttons-html5',
                        titleAttr: 'Copy',
                        exportOptions: { columns: ':visible:not(:last-child)' }
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-secondary buttons-csv buttons-html5',
                        titleAttr: 'Download CSV',
                        exportOptions: { columns: ':visible:not(:last-child)' }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-secondary buttons-excel buttons-html5',
                        titleAttr: 'Download Excel',
                        exportOptions: { columns: ':visible:not(:last-child)' }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-secondary buttons-pdf buttons-html5',
                        titleAttr: 'Download PDF',
                        exportOptions: { columns: ':visible:not(:last-child)' }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-secondary buttons-print',
                        titleAttr: 'Print Table',
                        exportOptions: { columns: ':visible:not(:last-child)' }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                        titleAttr: 'Show/Hide Columns'
                    }
                ]
            });

            // Place buttons & search
            userTable.buttons().container().appendTo('#exportButtons');
            $('#userTable_filter').appendTo('#dataTableSearch');
            $('#userTable_filter label').css('margin', '0');
        }
    });
}

//load Payment Mode Buttons
function loadPaymentModeButtons(paymentTotals) {
  let url = $('meta[name=app-url]').attr("content") + "payment-modes/show_all";

  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function(modes) {
      
      let html = "";
      for (let mode in paymentTotals) {
        html += `<span class="payModebtn">
            ${mode} : ${paymentTotals[mode].toFixed(2)}
        </span>`;
      }
      $("#payment-mode-buttons").html(html);
    },
    error: function(xhr) {
      console.log(xhr.responseText);
    }
  });
}

// small helper to escape HTML shown in table
function escapeHtml(text) {
  if (text === null || text === undefined) return '';
  return String(text)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

$(document).on('click', '[data-dismiss="modal"]', function () {
    $(this).closest('.modal').modal('hide');
});

//load Paymentmodes
function loadPaymentModes() {
  let url = $('meta[name=app-url]').attr("content") + "payment-modes/list";

  $.get(url, function(data) {
    let options = '<option value="">Select Payment Mode</option>';
    $.each(data, function(i, mode) {
      options += `<option value="${mode.id}">${mode.payment_mode}</option>`;
    });
    $("#payment_mode").html(options);
  }, 'json');
}
// Create User
function createUser()
{
  $("#alert-div").html("");
  $("#modal-alert-div").html("");

  $("#update_id").val("");
  $("#user_id").val("");
  $("#username").val("");
  $("#mobilenumber").val("");
  $("#useremail").val("");
  $("#date_of_birth").val("");
  $("#branch_id").val("");
  $("#status").val("active");

  // Show the password box container 
  $("#passwordBox").hide(); 
  $("#password").prop("required", false).prop("disabled", true);
  $("#form-modal").modal('show');
}
function storeUser()
{
  let url = $('meta[name=app-url]').attr("content") + "users/store";

  let data = {
    user_id: $("#user_id").val(),
    username: $("#username").val(),
    mobilenumber: $("#mobilenumber").val(),
    useremail: $("#useremail").val(),
    date_of_birth:  $("#date_of_birth").val(),
    branch_id:$("#branch_id").val(),
    //password: $("#password").val(),
    status: $("#status").val()
  };

  $.post(url, data, function(response){
    $("#alert-div").html('<div class="alert alert-success">User Added Successfully</div>');
    $("#form-modal").modal('hide');
    showAllUsers();
  }).fail(function(xhr){ console.error(xhr.responseText); });

  setTimeout(function() {
    $("#alert-div").html('');
  }, 3000);
}

function editUser(id)
{
  let url = $('meta[name=app-url]').attr("content") + "users/edit/" + id;
  $.get(url, function(user){
    $("#update_id").val(user.id);
    $("#user_id").val(user.user_id);
    $("#username").val(user.username);
    $("#mobilenumber").val(user.mobilenumber);
    $("#useremail").val(user.useremail);
    $("#date_of_birth").val(user.date_of_birth);
   
     // ✅ FIX HERE
    if (user.branch_ids) {
        let branches = user.branch_ids.split(','); // CSV → array
        $("#branch_id").val(branches);
    } else {
        $("#branch_id").val([]);
    }

    $("#status").val(user.status);
    //$("#password").val(user.password).show(); // masked
    $("#passwordBox").show();
    $("#password").val(user.password);
    $("#password").prop("required", true).prop("disabled", false); 
    $("#form-modal").modal('show');
  }, 'json').fail(function(xhr){ console.error(xhr.responseText); });
}

function updateUser()
{
  let id = $("#update_id").val();
  let url = $('meta[name=app-url]').attr("content") + "users/update/" + id;

  let pwd = $("#password").val();

  let data = {
    user_id: $("#user_id").val(),
    username: $("#username").val(),
    mobilenumber: $("#mobilenumber").val(),
    useremail: $("#useremail").val(),
    date_of_birth: $("#date_of_birth").val(),
    branch_id: $("#branch_id").val(),
    status: $("#status").val()
  };

   // Only send the password if it's been updated (and thus enabled/not '****')
  if (!$("#password").prop("disabled") && $("#password").val() !== "") {
    data.password = $("#password").val();
  }
  // if (pwd !== "****" && pwd !== "") {   // password changed
  //   data.password = pwd;
  // }

  $.post(url, data, function(response){
    $("#alert-div").html('<div class="alert alert-success">User Updated Successfully</div>');
    $("#form-modal").modal('hide');
    showAllUsers();
  }).fail(function(xhr){ console.error(xhr.responseText); });

  setTimeout(function() {
    $("#alert-div").html('');
  }, 3000);
}


function viewUser(id)
{
  let url = $('meta[name=app-url]').attr("content") + "users/edit/" + id;

  $.get(url, function(user){
     let userStatus = user.status == 1 ? 'Active' : 'Inactive';
    let badgeClass = user.status == 1 ? 'badge-success' : 'badge-danger';
    $("#user_id_info").html(escapeHtml(user.user_id));
    $("#username_info").html(escapeHtml(user.username));
    $("#mobilenumber_info").html(escapeHtml(user.mobilenumber));
    $("#useremail_info").html(escapeHtml(user.useremail));
   
    // Status with badge
    $("#status_info").html(
        '<strong class="badge ' + badgeClass + '">' + userStatus + '</strong>'
    );
    // Branch display
    let html = '';
    if (user.branch_names) {
        let branches = user.branch_names.split(',');
        html = '<ol style="padding-left:18px;margin:0">';
        branches.forEach(function(name){
            html += '<li>' + escapeHtml(name.trim()) + '</li>';
        });
        html += '</ol>';
    } else {
        html = '<span class="text-muted">No branches assigned</span>';
    }

    $("#branches_info").html(html);
    
    $("#view-modal").modal('show');
  }, 'json').fail(function(xhr){ console.error(xhr.responseText); });
}

function destroyUser(id)
{
  if (!confirm('Are you sure to delete this user?')) return;

  let deleteUrl = $('meta[name=app-url]').attr("content") + "users/delete/" + id;
  console.log(deleteUrl);
  $.post(deleteUrl, {}, function(response){
    let data = JSON.parse(response);
    $("#alert-div").html('<div class="alert alert-success">User Deleted Successfully</div>');
    showAllUsers();
  }).fail(function(xhr){ console.error(xhr.responseText); });
}

</script>