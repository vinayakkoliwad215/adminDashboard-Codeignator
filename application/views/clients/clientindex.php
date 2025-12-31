<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="color:darkgreen"><?= $title ?></h1>
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
                <a class="btn btn-primary" id="createBtn" href="<?= base_url('clients'); ?>">
                    <i class="fa fa-plus-square"></i> Create Clients
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="clientTable" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th width="80px">Action</th>
                  </tr>
                </thead>
                <tbody id="clients-table-body"></tbody>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th width="80px">Action</th>
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
<div class="modal" id="form-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Payment Mode Form</h5>
        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
      </div>

      <div class="modal-body">
        <div id="modal-alert-div"></div>
        <form id="payment-form">
          <input type="hidden" id="update_id">

          <label>Payment Mode</label>
          <input type="text" id="payment_mode" class="form-control mb-3" required>

          <label>Status</label>
          <select id="status" class="form-control mb-3">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>

          <button type="submit" class="btn btn-outline-primary">Save</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
var clientTable = null;
$(document).ready(function(){
  showAllClients();
});

/** Load all Clients */
function showAllClients() {
  let url = $('meta[name=app-url]').attr("content") + "clients/show_all";

  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function(clients) {

      // Destroy old DataTable if exists
      if (clientTable !== null) {
        $('#clientTable').DataTable().clear().destroy();
        $('#clients-table-body').empty();
      }

      let row = "";

      for (let i = 0; i < clients.length; i++) {

        let editBtn = '<button class="btn btn-success btn-sm" onclick="editClient('+clients[i].id+')"><i class="fa fa-edit"></i></button>';
        let deleteBtn = '<button class="btn btn-danger btn-sm" onclick="deleteClient('+clients[i].id+')"><i class="fa fa-trash"></i></button>';

        row += '<tr>' +
                '<td>'+clients[i].id+'</td>' +
                '<td>'+clients[i].name+'</td>' +
                '<td>'+clients[i].email+'</td>' +
                '<td>'+clients[i].phone+'</td>' +
                '<td>'+clients[i].designation+'</td>' +
                '<td>'+clients[i].department+'</td>' +
                '<td>'+editBtn+' '+deleteBtn+'</td>' +
               '</tr>';
      }

      $("#clients-table-body").append(row);

      // Reinitialize DataTable
      clientTable = $("#clientTable").DataTable({
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
                titleAttr: 'Download CSV',
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
      clientTable.buttons().container().appendTo('#exportButtons');

      // move DataTable search box
      $('#clientTable_filter').appendTo('#dataTableSearch');
      $('#clientTable_filter label').css('margin', '0');
    }
  });
}

function editClient(id){
    let clientUrl = $('meta[name=app-url]').attr("content") + "clients/edit/" + id;
    window.location.href = clientUrl;
}

function deleteClient(id){
    let clientDeleteUrl = $('meta[name=app-url]').attr("content") + "clients/delete/" + id;
    Swal.fire({
      title: "Are you sure?",
      text: "This will delete the client!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!"
    }).then((result)=>{
        if(result.isConfirmed){
            $.ajax({
                url: clientDeleteUrl,
                type: "GET",
                success:function(){
                    Swal.fire("Deleted!", "Client removed.", "success");
                    showAllClients();
                }
            });
        }
    });
}
</script>