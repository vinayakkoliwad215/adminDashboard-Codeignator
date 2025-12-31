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
                <a class="btn btn-primary" id="createBtn" href="<?= base_url('branches/create') ?>">
                    <i class="fa fa-plus-square"></i> Add New Branch
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="branchTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Head</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody id="branches-table-body"></tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Head</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Website</th>
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
<!-- Branch View Modal -->
<div class="modal fade" id="branch-view-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Branch Details</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered table-sm">
          <tr><th width="35%">Branch ID</th><td id="v_id"></td></tr>
          <tr><th>Name</th><td id="v_name"></td></tr>
          <tr><th>Head</th><td id="v_head"></td></tr>
          <tr><th>Phone</th><td id="v_phone"></td></tr>
          <tr><th>Email</th><td id="v_email"></td></tr>
          <tr><th>Address</th><td id="v_address"></td></tr>
          <tr><th>Website</th><td id="v_website"></td></tr>
        </table>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
$(document).ready(function(){
    let msg = sessionStorage.getItem("branch_success");

    if(msg){
        $("#alert-div").html(
          '<div class="alert alert-success">' + msg + '</div>'
        );

        sessionStorage.removeItem("branch_success");

        setTimeout(() => {
            $("#alert-div").fadeOut();
        }, 3000);
    }
});
</script>
<script>
var branchTable = null;

$(document).ready(function(){
  showAllBranches();
});

/** Load all Payment Modes */
function showAllBranches() {
  let url = $('meta[name=app-url]').attr("content") + "branches/show_all";

  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function(branches) {

      // Destroy old DataTable if exists
      if (branchTable !== null) {
        $('#branchTable').DataTable().clear().destroy();
        $('#branches-table-body').empty();
      }

      let row = "";

        for (let i = 0; i < branches.length; i++) {

        let viewBtn = `<button class="btn btn-info btn-sm" onclick="viewBranch(${branches[i].id})">
                <i class="fa fa-eye"></i>
              </button>`;   
        let editBtn   = `<button class="btn btn-success btn-sm" onclick="editBranches(${branches[i].id})">
                          <i class="fa fa-edit"></i></button>`;

        let deleteBtn = `<button class="btn btn-danger btn-sm" onclick="deleteBranches(${branches[i].id})">
                          <i class="fa fa-trash"></i></button>`;

        row += `
          <tr>
            <td>${branches[i].id}</td>
            <td>${branches[i].name}</td>
            <td>${branches[i].head}</td>
            <td>${branches[i].phone_number}</td>
            <td>${branches[i].email}</td>
            <td>${branches[i].website_url}</td>
            <td>${viewBtn} ${editBtn} ${deleteBtn}</td>
          </tr>`;
      }

      $("#branches-table-body").append(row);

      // Reinitialize DataTable
      branchTable = $("#branchTable").DataTable({
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
      branchTable.buttons().container().appendTo('#exportButtons');

      // move DataTable search box
      $('#branchTable_filter').appendTo('#dataTableSearch');
      $('#branchTable_filter label').css('margin', '0');
    }
  });
}

/** Edit Branch */
function editBranches(id) {
    let branchUrl = $('meta[name=app-url]').attr("content") + "branches/edit/" + id;
    window.location.href = branchUrl;
}

//view Branch
function viewBranch(id)
{
  let url = $('meta[name=app-url]').attr("content") + "branches/view/" + id;
  console.log(url);
  $.get(url, function(branch){
    
    $("#v_id").text(branch.id);
    $("#v_name").text(branch.name);
    $("#v_head").text(branch.head);
    $("#v_phone").text(branch.phone_number);
    $("#v_email").text(branch.email);
    $("#v_address").text(branch.address);
    $("#v_website").html(
        branch.website_url 
        ? `<a href="${branch.website_url}" target="_blank">${branch.website_url}</a>` 
        : '-'
    );

    $("#branch-view-modal").modal('show');

  }, 'json').fail(function(xhr){
    console.error(xhr.responseText);
  });
}

$(document).on('click', '[data-dismiss="modal"]', function () {
    $(this).closest('.modal').modal('hide');
});

//Delete Branch
function deleteBranches(id){
    let branchUrl = $('meta[name=app-url]').attr("content") + "branches/delete/" + id;
    $.ajax({
    url: branchUrl,
    type: "POST",
    success:function(){
        Swal.fire("Deleted!", "Branch removed.", "success");
        showAllBranches();
    }
});

}
</script>