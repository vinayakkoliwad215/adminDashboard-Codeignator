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
                  <a class="btn btn-primary"  id="createBtn" href="<?= base_url('email-reports'); ?>">
                    <i class="fa fa-envelope"></i> Email Reports
                  </a>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              <table id="loginsmsTable" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Mobile</th>
                    <th>Message Data</th>
                    <th>Response Data</th>
                    <th>status</th>
                    <th>Date/Time</th>
                  </tr>
                </thead>
                <tbody id="loginsms-table-body"></tbody>
                <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Mobile</th>
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
<div class="modal fade" id="smsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">SMS Message</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="smsModalBody"></div>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
let loginsmsTable;

$(document).ready(function(){            
  loadLoginSmsReports(); 
});

$(document).on("click", ".viewFull", function(e){
  e.preventDefault();
  $('#smsModalBody').html($(this).data("msg"));
  $('#smsModal').modal('show');
});
$('#smsModal').modal('hide');

function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}
/** Load all SMS Reports */
function loadLoginSmsReports() {
  let url = $('meta[name=app-url]').attr("content") + "sms-reports/show_all";

  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function(smsreports) {

      // Destroy old DataTable if exists
      if (loginsmsTable !== null) {
        $('#loginsmsTable').DataTable().clear().destroy();
        $('#loginsms-table-body').empty();
      }

      let row = "";

      for (let i = 0; i < smsreports.length; i++) {

        let messageBody = smsreports[i].message_body ?? '';

        let msg = messageBody.length > 50
            ? escapeHtml(messageBody.substring(0, 50)) +
            '... <a href="#" class="viewFull" data-msg="' + escapeHtml(messageBody) + '">View</a>'
            : escapeHtml(messageBody);

        let statusText = smsreports[i].status === "success"
            ? '<span style="color:green; font-weight:500; font-size:14px;"><b>SMS Delivered Successfully</b></span>'
            : '<span style="color:red; font-weight:500; font-size:14px;"><b>SMS Delivery Failed</b></span>';

        row += '<tr>' +
            '<td>' + smsreports[i].id + '</td>' +
            '<td>' + smsreports[i].user_id + '</td>' +
            '<td>' + smsreports[i].username + '</td>' +
            '<td>' + smsreports[i].mobilenumber + '</td>' +
            '<td>' + msg + '</td>' +
            '<td>' + escapeHtml(smsreports[i].response_message ?? '') + '</td>' +
            '<td>' + statusText + '</td>' +
            '<td>' + smsreports[i].created_at + '</td>' +
        '</tr>';
    }
    $("#loginsms-table-body").append(row);

    // Reinitialize DataTable
    loginsmsTable = $("#loginsmsTable").DataTable({
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
      loginsmsTable.buttons().container().appendTo('#exportButtons');

      // move DataTable search box
      $('#loginsmsTable_filter').appendTo('#dataTableSearch');
      $('#loginsmsTable_filter label').css('margin', '0');
    }
  });
}
</script>