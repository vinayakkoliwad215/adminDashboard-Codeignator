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
                <button class="btn btn-primary" id="createBtn" onclick="createDepositType()">
                    <i class="fa fa-plus-square"></i> Create Deposit Type
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="depositTypeTable" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Deposit Type</th>
                    <th>Status</th>
                    <th width="200px">Action</th>
                  </tr>
                </thead>
                <tbody id="deposit-type-table-body"></tbody>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Deposit Type</th>
                    <th>Status</th>
                    <th width="200px">Action</th>
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
        <h5 class="modal-title">Deposit Type Form</h5>
        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
      </div>

      <div class="modal-body">
        <div id="modal-alert-div"></div>
        <form id="deposit-type-form">
          <input type="hidden" id="update_id">

          <label>Deposit Type</label>
          <input type="text" id="deposit_type" class="form-control mb-3" required>

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
var depositTypeTable = null;
$(document).ready(function(){
  showAllDepositTypes();

  // handle form submit (create / update)
  $("#deposit-type-form").on('submit', function(e){
    e.preventDefault();
    if ($("#update_id").val() == "") {
      storeDepositType();
    } else {
      updateDepositType();
    }
  });
});

/** Load all Payment Modes */
function showAllDepositTypes() {
  let url = $('meta[name=app-url]').attr("content") + "deposit-types/depositTypes_all";

  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function(depositTypes) {

      // Destroy old DataTable if exists
      if (depositTypeTable !== null) {
        depositTypeTable.destroy();
        $("#deposit-type-table-body").html("");
      }

      let row = "";

      for (let i = 0; i < depositTypes.length; i++) {

        let editBtn = '<button class="btn btn-success btn-sm" onclick="editDepositType('+depositTypes[i].id+')"><i class="fa fa-edit"></i></button>';
        let deleteBtn = '<button class="btn btn-danger btn-sm" onclick="deleteDepositTypes('+depositTypes[i].id+')"><i class="fa fa-trash"></i></button>';

        row += '<tr>' +
                '<td>'+depositTypes[i].id+'</td>' +
                '<td>'+depositTypes[i].deposit_type+'</td>' +
                '<td>'+depositTypes[i].status+'</td>' +
                '<td>'+editBtn+' '+deleteBtn+'</td>' +
               '</tr>';
      }

      $("#deposit-type-table-body").append(row);

      // Reinitialize DataTable
      depositTypeTable = $("#depositTypeTable").DataTable({
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
    }
  });
}

/** Open Create Modal */
function createDepositType() {
  $("#alert-div").html("");
  $("#modal-alert-div").html('');
  $("#deposit_type").val("");
  $("#status").val("active");
  $("#update_id").val("");
  $("#form-modal").modal("show");
}

function storeDepositType()
{
  let url = $('meta[name=app-url]').attr("content") + "deposit-types/store";
  let data = {
    deposit_type: $("#deposit_type").val(),
    status: $("#status").val()
  };

  $.post(url, data, function(response){
    $("#alert-div").html('<div class="alert alert-success">Deposit Type Added Successfully</div>');
    $("#form-modal").modal('hide');
    showAllDepositTypes();
  }).fail(function(xhr){ console.error(xhr.responseText); });

  setTimeout(function() {
    $("#alert-div").html('');
  }, 3000);
}

/** Edit */
function editDepositType(id) {
  let url = $('meta[name=app-url]').attr("content") + "deposit-types/edit/" + id;
  $.get(url, function(depositTypes){
    $("#modal-alert-div").html('');
    $("#update_id").val(depositTypes.id);
    $("#deposit_type").val(depositTypes.deposit_type);
    $("#status").val(depositTypes.status);
    $("#form-modal").modal("show");
  },'json').fail(function(xhr){ console.error(xhr.responseText); });
}
//Update
function updateDepositType()
{
  let id = $("#update_id").val();
  let url = $('meta[name=app-url]').attr("content") + "deposit-types/update/" + id;

  let data = {
    deposit_type: $("#deposit_type").val(),
    status: $("#status").val(),
  };

  $.post(url, data, function(response){
    $("#alert-div").html('<div class="alert alert-success">Deposit Type Updated Successfully</div>');
    $("#form-modal").modal('hide');
    showAllDepositTypes();
  }).fail(function(xhr){ console.error(xhr.responseText); });

  setTimeout(function() {
    $("#alert-div").html('');
  }, 3000);
}
//Delete mode
function deleteDepositTypes(id) {
  if (!confirm("Are you sure to delete this deposit type?")) return;
    let deleteUrl = $('meta[name=app-url]').attr("content") + "deposit-types/delete/" + id;
    $.get(deleteUrl, function(res) {
    let data = JSON.parse(res);
    $("#alert-div").html('<div class="alert alert-success">Deposit Type Deleted Successfully</div>');
    showAllDepositTypes();
  }).fail(function(xhr){ console.error(xhr.responseText); });

  setTimeout(function() {
    $("#alert-div").html('');
  }, 3000);
}



</script>