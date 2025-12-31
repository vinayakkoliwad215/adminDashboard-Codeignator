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
                <a class="btn btn-primary"  id="createBtn" href="<?= base_url('sms-reports'); ?>">
                  <i class="fa fa-comment"></i> SMS Reports
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="loginEmailTable" class="table table-bordered table-hover">
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
                <tbody id="loginEmail-table-body"></tbody>
                <tfoot>
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
<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Email Message</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="emailModalBody"></div>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>

<script>
var loginEmailTable = null;
$(document).ready(function(){
  showAllPaymentModes();
});
$(document).on("click", ".viewFull", function(e){
  e.preventDefault();
  $('#emailModalBody').html($(this).data("msg"));
  $('#emailModal').modal('show');
});
$('#emailModal').modal('hide');

function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}

/** Load all Email Reports */
function showAllPaymentModes() {
  let url = $('meta[name=app-url]').attr("content") + "email-reports/loginEmails";

  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function(emailreports) {

      // Destroy old DataTable if exists
      if (loginEmailTable !== null) {
        $('#loginEmailTable').DataTable().clear().destroy();
        $('#loginEmail-table-body').empty();
      }

      let row = "";

      for (let i = 0; i < emailreports.length; i++) {

        let messageBody = emailreports[i].message ?? '';

        let plainText = messageBody.replace(/<[^>]*>?/gm, ''); // strip tags for preview

        let msg = plainText.length > 50
            ? plainText.substring(0, 50) +
            '... <a href="#" class="viewFull" data-msg=\'' + messageBody.replace(/'/g, "&apos;") + '\'>View</a>'
            : messageBody;


        let statusText = emailreports[i].status == "sent"
        ? '<span style="color:green; font-weight:600;font-size:14px;">Email Sent Successfully</span>'
        : '<span style="color:red; font-weight:600;font-size:14px;">Email Failed</span>';

                // If role = 1 then show "Super Admin" below username
        let usernameWithRole = escapeHtml(emailreports[i].username);
        if (emailreports[i].role == 1) {
          usernameWithRole += `<br><span style="color: green; font-size: 12px; font-weight: bold;">Super Admin</span>`;
        }

        row += '<tr>' +
                '<td>'+emailreports[i].id+'</td>' +
                '<td>'+emailreports[i].user_id+'</td>' +
                '<td>'+usernameWithRole+'</td>' +
                '<td>'+emailreports[i].email+'</td>' +
                '<td>'+emailreports[i].subject+'</td>' +
                '<td>'+msg+'</td>' +
                '<td>'+statusText+'</td>' +
                '<td>'+emailreports[i].created_at+'</td>' +
               '</tr>';
      }

      $("#loginEmail-table-body").append(row);

      // Reinitialize DataTable
      loginEmailTable = $("#loginEmailTable").DataTable({
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
      loginEmailTable.buttons().container().appendTo('#exportButtons');

      // move DataTable search box
      $('#loginEmailTable_filter').appendTo('#dataTableSearch');
      $('#loginEmailTable_filter label').css('margin', '0');
    }
  });
}
</script>