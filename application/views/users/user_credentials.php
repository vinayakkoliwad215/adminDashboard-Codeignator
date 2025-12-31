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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="userCredentialTable" class="table table-bordered table-hover">
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
                <tbody id="user-credentials-table-body"></tbody>
                <tfoot>
                  <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Status</th>
                    <th>Select</th>
                  </tr>
                </tfoot>
              </table>
                <button id="sendSmsEmailBtn" onclick="sendSmsAndEmail()" class="btn btn-primary">
                <i class="fa fa-paper-plane"></i> Send SMS & Email
                </button>
                <span id="smsEmailLoader" style="display:none; margin-left:10px;">
                <i class="fa fa-spinner fa-spin"></i> Sending...
                </span>
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

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
let userCredentialTable;

$(document).ready(function(){           
  showAllUserCredentials(); 
});

function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return "";
    return String(unsafe)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

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

/** Load all User Credentials */
function showAllUserCredentials() {
  let url = $('meta[name=app-url]').attr("content") + "users-credentials/show_all";

  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function(users) {

      // Destroy old DataTable if exists
      if (userCredentialTable !== null) {
        $('#userCredentialTable').DataTable().clear().destroy();
        $('#user-credentials-table-body').empty();
      }

      let row = "";
      
      for (let i = 0; i < users.length; i++) {
        let formattedDOB = users[i].date_of_birth ? formatDate(users[i].date_of_birth) : '';
        let UserStatus = users[i].status == 1 ? 'Active' : 'Inactive';
        row += '<tr>' +
            '<td>' + users[i].display_user_id + '</td>' +
            '<td>' + users[i].username + '</td>' +
            '<td>' + users[i].mobilenumber + '</td>' +
            '<td>' + users[i].useremail + '</td>' +
            '<td>' + formattedDOB + '</td>' +
            '<td>' + UserStatus + '</td>' +
            '<td>' + `<input type="checkbox" class="userCheckbox" value="${escapeHtml(users[i].mobilenumber)}">`+ '</td>' +
        '</tr>';
      }

      $("#user-credentials-table-body").append(row);

      // Reinitialize DataTable
      userCredentialTable = $("#userCredentialTable").DataTable({
        "autoWidth": false,
        "responsive": true,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        dom:
          "<'row mb-2'<'col-md-6 d-flex align-items-center'B><'col-md-6 text-right'f>>" +
          "<'row'<'col-md-12'tr>>" +
          "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",
              
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-secondary buttons-copy buttons-html5',
                titleAttr: 'Copy',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'csv',
                className: 'btn btn-secondary buttons-csv buttons-html5',
                titleAttr: 'Download Excel',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'excel',
                className: 'btn btn-secondary buttons-excel buttons-html5',
                titleAttr: 'Download Excel',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-secondary buttons-pdf buttons-html5',
                titleAttr: 'Download PDF',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'print',
                className: 'btn btn-secondary buttons-print',
                titleAttr: 'Print Table',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },
            {
                extend: 'colvis',
                className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                titleAttr: 'Show/Hide Columns'
            }   
        ]
      });
      // place export buttons in header center and search in right
      userCredentialTable.buttons().container().appendTo('#exportButtons');

      // move DataTable search box
      $('#userCredentialTable_filter').appendTo('#dataTableSearch');
      $('#userCredentialTable_filter label').css('margin', '0');
    }
  });
}

function sendSMS() {
  let selected = [];
  $(".smsCheckbox:checked").each(function () {
    selected.push($(this).val());
  });

  if (selected.length === 0) {
    alert("Select at least one user");
    return;
  }

  //   let message = prompt("Enter SMS text:");
  //   if (!message) {
  //     alert("Message is required");
  //     return;
  //   }

  $.ajax({
    url: $('meta[name=app-url]').attr("content") + "users-credentials/send-sms",
    type: "POST",
    dataType: "json",
    data: { numbers: selected},
    success: function(res) {
      alert(res.message);
    }
  });
}

function sendSmsAndEmail() {
    let selected = [];
    $(".userCheckbox:checked").each(function () {
        selected.push($(this).val());
    });

    if (selected.length === 0) {
        Swal.fire({
            icon: "warning",
            title: "No Users Selected!",
            text: "Please select at least one user."
        });
        return;
    }

    // Confirm before sending
    Swal.fire({
        title: "Send SMS & Email?",
        text: "Are you sure you want to send login credentials?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, Send",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (!result.isConfirmed) return;

        // Show loader popup
        Swal.fire({
            title: "Processing...",
            text: "Sending SMS and Email to selected users...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // disable button + show loader on UI
        $("#sendSmsEmailBtn").prop("disabled", true);
        $("#smsEmailLoader").show();

        $.ajax({
            url: $('meta[name=app-url]').attr("content") + "users-credentials/send-sms-email",
            type: "POST",
            data: { numbers: selected },
            dataType: "json",
            success: function(res) {
                Swal.close(); // hide loader

                Swal.fire({
                    icon: res.status ? "success" : "warning",
                    title: res.status ? "Success!" : "Failed!",
                    text: res.message ?? (res.status ? "SMS / Email sent successfully" : "Something went wrong")
                });
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Error sending SMS/Email. Try again."
                });
            },
            complete: function() {
                $("#sendSmsEmailBtn").prop("disabled", false);
                $("#smsEmailLoader").hide();
            }
        });
    });
}

</script>