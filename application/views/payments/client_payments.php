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
              <button class="btn btn-primary" id="createBtn" onclick="createClientTransaction()">
                <i class="fa fa-plus-square"></i> Create Payment
              </button>
            </div>

          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                    <label><b>Payment Mode</b></label>
                    <select id="filter_payment_mode" class="form-control">
                    <option value="">- All Modes -</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label><b>Payment From Date</b></label>
                    <input type="date" id="date_from" class="form-control"> 
                </div>
                <div class="col-md-4">
                  <label><b>Payment To Date</b></label>
                  <input type="date" id="date_to" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                  <br/>
                  <button id="filterBtn" class="btn btn-primary w-100">
                    <i class="fa fa-filter"></i> Filter
                  </button>
                </div>
                <div class="col-md-4">
                  <br/>
                  <button id="resetFilterBtn" class="btn btn-secondary w-100">
                    <i class="fa fa-times"></i> Reset
                    </button>
                  </div>
              </div>
              <div id="payment-mode-buttons"></div>
            </div>
          </div>
          <div class="card-body">
            <marquee behavior="scroll" direction="left" scrollamount="5">
              <h6 style="color:red;font-size:16px;"> This table showing the records for the Client Payment Transaction Details List 2025-26</h6>
            </marquee>
            <table class="table table-bordered display" id="paymentTransactionsTable">
            <thead>
                <tr>
                <th>Client Id</th>
                <th>UserName, <br/> Mobile</th>
                <th>Payment Date</th>
                <th>Payment Mode</th>
                <th>Deposit Amount <br/>Deposit Type </th>
                <th>Total Deposit</th>
                <th width="80">Action</th>
                </tr>
            </thead>
            <tbody id="client-payment-body"></tbody>
              <tfoot>
                <th>Client Id</th>
                <th>UserName, <br/> Mobile</th>
                <th>Payment Date</th>
                <th>Payment Mode</th>
                <th>Deposit Amount <br/>Deposit Type </th>
                <th>Total Deposit</th>
                <th width="80">Action</th>
                </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
    </div>
  <!-- /.card -->
  </div>
  <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

  <!-- Create / Update Modal -->
  <div class="modal" id="client-transaction-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Payment Transaction</h5>
            <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
        </div>
        <div class="modal-body">
            <div id="modal-alert-div"></div>
            <form id="transaction-form">
            <input type="hidden" id="update_id">

            <div class="form-group">
                <label>Client Name</label>
                <select id="client_id" class="form-control" required></select>
            </div>

            <div class="form-group">
                <label>Payment Date</label>
                <input type="date" id="paymentDate" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Payment Mode</label>
                <select id="payment_mode_id" class="form-control" required></select>
            </div>

            <div class="form-group">
                <label>Deposit Type</label>
                <select id="deposit_type_id" class="form-control" required></select>
            </div>

            <div class="form-group">
                <label>Amount</label>
                <input type="number" id="security_depo" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Note / Remark</label>
                <input type="text" id="note" class="form-control">
            </div>

            <button type="submit" class="btn btn-outline-primary">Save</button>
            </form>
        </div>
        </div>
    </div>
  </div>

  <!-- View Modal For the payment transactions -->
  <div class="modal" id="viewClientTransModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">User Payment Transaction History</h5>
            <button type="button" class="close" onclick="closeViewModal()"><span>×</span></button>
        </div>
        <div class="modal-body">
            <!-- USER INFO -->
            <div class="row mb-2" style="font-size: 16px; font-weight: 600;">
                <div class="col-md-4">Client Id : <span id="v_clientid"></span></div>
                <div class="col-md-4">Clientname : <span id="v_name"></span></div>
                <div class="col-md-4">Mobile Number : <span id="v_phone"></span></div>
            </div>
            <div class="row mb-3" style="font-size: 16px; font-weight: 600;">
                <div class="col-md-12">Note : <span id="v_note"></span></div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Payment Date</th>
                        <th>Payment Mode</th>
                        <th>Deposit Type</th>
                        <th>Amount</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody id="viewPaymentsBody"></tbody>
            </table>
            <!-- TOTAL DEPOSIT -->
            <h5 class="text-right mt-3">Total Deposit: 
            <b style="color:green; font-size:18px;">₹ <span id="totalDeposit"></span></b>
            </h5>
        </div>
        </div>
    </div>
  </div>

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script>
var transactionTable = null;
let paymentTotals = {};
let allPaymentModes = {}; // id => name

$(document).ready(function () {
    initTransactionTable();
    loadAllPaymentModes().then(() => {
      showAllTransactions();
    });

    // Filter button
    $("#filterBtn").on("click", function () {
      applyFilter();
      renderPaymentModeButtons(paymentTotals);
    });

    // Reset filter
    $("#resetFilterBtn").on("click", function () {
      $("#filter_payment_mode").val("");
      $("#date_from").val("");
      $("#date_to").val("");
      applyFilter(); // reload table without filters
      renderPaymentModeButtons(paymentTotals);
    });

    $("#transaction-form").on("submit", function (e) {
      e.preventDefault();
      storeTransaction();
    });
});

function loadAllPaymentModes() {
  let url = $('meta[name=app-url]').attr("content") + "payment-modes/list";

  return $.get(url, function (data) {
    allPaymentModes = {};
    data.forEach(m => {
      allPaymentModes[m.id] = m.payment_mode;
    });

    buildPaymentModeDropdown();
  }, "json");
}


function initTransactionTable() {
  if (!$.fn.DataTable.isDataTable('#paymentTransactionsTable')) {

    transactionTable = $("#paymentTransactionsTable").DataTable({
      "autoWidth": false,
      "responsive": true,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      dom:
      "<'row mb-2'<'col-md-6 d-flex align-items-center'B><'col-md-6 text-left'f>>" +
          "<'row'<'col-md-12'tr>>" +
          "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",
      buttons: [
        {
          extend: 'copy',
          titleAttr: 'Copy',
          exportOptions: { columns: ':visible:not(:last-child)' },
          action: function () { copyTableWithRowspan(); }
        },
        {
          extend: 'excel',
          titleAttr: 'Download Excel',
          exportOptions: { columns: ':visible:not(:last-child)' },
          action: function () {
              $('#paymentTransactionsTable').find('th:last-child, td:last-child').hide();
              exportExcelWithRowspan();
              $('#paymentTransactionsTable').find('th:last-child, td:last-child').show();
          }
        },
        {
          extend: 'csv',
          titleAttr: 'Download CSV',
          action: function () {
              $('#paymentTransactionsTable').find('th:last-child, td:last-child').hide();
              exportCsvWithRowspan();
              $('#paymentTransactionsTable').find('th:last-child, td:last-child').show();
          }
        },
        {
            extend: 'pdf',
            titleAttr: 'Download PDF',
            action: function () {
                exportPdfWithRowspan();
            }
        },
        {
          extend: 'print', 
          titleAttr: 'Print Table',
          exportOptions: { columns: ':visible:not(:last-child)' },
          action: function () {
              $('#paymentTransactionsTable').find('th:last-child, td:last-child').hide();
              printTableWithRowspan();
              $('#paymentTransactionsTable').find('th:last-child, td:last-child').show();
          }
        },
        { extend: 'colvis', titleAttr: 'Show/Hide Columns'}
      ]
    });

    transactionTable.buttons().container().appendTo('#exportButtons');
    // move DataTable search box
    $('#paymentTransactionsTable_filter').appendTo('#dataTableSearch');
    $('#paymentTransactionsTable_filter label').css('margin', '0');
  }
}

function showAllTransactions(filters = {}) {
  let url = $('meta[name=app-url]').attr("content") + "client-transactions/transactions_all";
  let dataParams = {};

  if (filters.mode) dataParams.mode = filters.mode;
  if (filters.from) dataParams.from = filters.from;
  if (filters.to) dataParams.to = filters.to;

  $.get(url, dataParams, function (data) {

    $("#client-payment-body").html("");

    let groups = {};
    let grandTotal = 0;
    let paymentTotals = {};

    data.forEach(t => {

      // group by client
      if (!groups[t.clientid]) groups[t.clientid] = [];
      groups[t.clientid].push(t);

      let amount = parseFloat(t.security_depo || 0);
      grandTotal += amount;

      // store ALL payment modes globally
      allPaymentModes[t.payment_mode_id] = t.payment_mode_name;

      // calculate totals per mode
      let modeName = t.payment_mode_name;
      if (!paymentTotals[modeName]) paymentTotals[modeName] = 0;
      paymentTotals[modeName] += amount;
    });

    let selectedMode = $("#filter_payment_mode").val();

    Object.values(groups).forEach(group => {
      let rowspan = group.length;

      group.forEach((t, index) => {

        let tr = `<tr data-mode-id="${t.payment_mode_id}">`;

        if (index === 0) {
          tr += `
            <td rowspan="${rowspan}">${t.clientid}</td>
            <td rowspan="${rowspan}">
              ${escapeHtml(t.name)}<br>
              Mob: ${escapeHtml(t.phone)}
            </td>`;
        }

        tr += `
          <td>${t.paymentDate ? formatDate(t.paymentDate) : ''}</td>
          <td>${escapeHtml(t.payment_mode_name)}</td>
          <td class="cell-amount">
            ${parseFloat(t.security_depo || 0).toFixed(2)}
            <br><small>${escapeHtml(t.depositType)}</small>
          </td>`;

        if (index === 0) {
          let amountToShow = selectedMode
            ? parseFloat(t.total_deposit_mode || 0)
            : parseFloat(t.total_deposit || 0);

          tr += `<td rowspan="${rowspan}" class="user_total"><b>${amountToShow.toFixed(2)}</b></td>
                 <td rowspan="${rowspan}">
                   <button class="btn btn-warning btn-sm" onclick="viewClientTransactions(${t.clientid})">
                     <i class="fa fa-eye"></i>
                   </button>
                   <button class="btn btn-success btn-sm" onclick="downloadReceipt(${t.clientid})">
                     <i class="fa fa-download"></i>
                   </button>
                 </td>`;
        }

        tr += `</tr>`;
        $("#client-payment-body").append(tr);
      });
    });

    // Grand Total
    $("#client-payment-body").append(`
      <tr>
        <td colspan="4" class="text-right"><b>Grand Total</b></td>
        <td><b>${grandTotal.toFixed(2)}</b></td>
        <td><b>${grandTotal.toFixed(2)}</b></td>
        <td></td>
      </tr>
    `);

    // ✅ BUILD DROPDOWN FROM ALL MODES
    let pmHtml = '<option value="">- All Modes -</option>';
    Object.keys(allPaymentModes).forEach(id => {
      pmHtml += `<option value="${id}">${allPaymentModes[id]}</option>`;
    });
    $("#filter_payment_mode").html(pmHtml);

    if (filters.mode) {
      $("#filter_payment_mode").val(filters.mode);
    }

    renderPaymentModeButtons(paymentTotals);
    initTransactionTable();

  }, "json");
}


/**
 * Called when filter button is clicked. It fetches filtered dataset from server
 * and rebuilds the grouped table so rowspan stays correct.
 */
function applyFilter() {
  let filters = {
    mode: $("#filter_payment_mode").val(),
    from: $("#date_from").val(),
    to: $("#date_to").val()
  };
  showAllTransactions(filters);
}

function buildPaymentModeDropdown() {
  let html = '<option value="">- All Modes -</option>';

  Object.keys(allPaymentModes).forEach(id => {
    html += `<option value="${id}">${allPaymentModes[id]}</option>`;
  });

  $("#filter_payment_mode").html(html);
}

function renderPaymentModeButtons(paymentTotals) {
  let selectedModeId = $("#filter_payment_mode").val();
  let html = "";

  Object.keys(allPaymentModes).forEach(id => {
    let modeName = allPaymentModes[id];
    let amount = paymentTotals[modeName] || 0;

    // filter display if mode selected
    if (selectedModeId && id != selectedModeId) return;

    html += `
      <span class="payModebtn">
        ${modeName} : <b>${amount.toFixed(2)}</b>
      </span>
    `;
  });

  $("#payment-mode-buttons").html(html);
}

// function restoreActionColumn() {
//     $("#paymentTransactionsTable th:last-child").show();
//     $("#paymentTransactionsTable td:last-child").show();
// }

// --- Custom PDF Export Function (Handles rowspan visually) ---

// function buildCleanPdfTable() {

//     let cleanHtml = `
//         <table border="1" cellspacing="0" cellpadding="6" 
//                style="width:100%; font-size:12px; border-collapse: collapse;">
//             <thead style="display: table-header-group;">
//                 <tr>
//                     <th>User ID</th>
//                     <th>UserName, Mobile</th>
//                     <th>Payment Date</th>
//                     <th>Payment Mode</th>
//                     <th>Deposit Amount</th>
//                     <th>Deposit Type</th>
//                     <th>Total Deposit</th>
//                 </tr>
//             </thead>
//             <tbody>
//     `;

//     // Loop through table rows in original table
//     $("#paymentBody tr").each(function () {

//         let cols = $(this).find("td").not(".actionColumn"); // REMOVE action column

//         cleanHtml += "<tr>";

//         cols.each(function () {
//             cleanHtml += `<td>${$(this).html()}</td>`;
//         });

//         cleanHtml += "</tr>";
//     });

//     cleanHtml += `</tbody></table>`;

//     $("#pdf-wrapper").html(cleanHtml); // Ready for PDF
// }

// function exportPdfWithRowspan() {

//     // Build PDF table first
//     buildCleanPdfTable();

//     // Select the table for PDF
//     const element = document.getElementById("pdf-wrapper");

//     // PDF options
//     const opt = {
//         margin: 5,
//         filename: "UserPayment-Transactions.pdf",
//         image: { type: "jpeg", quality: 1 },
//         html2canvas: { scale: 2 },
//         jsPDF: { unit: "mm", format: "a4", orientation: "landscape" },
//         pagebreak: { mode: ["css","legacy"] }
//     };

//     // Generate + Download PDF
//     html2pdf().set(opt).from(element).save();
// }

function exportPdfWithRowspan() {

    let element = document.getElementById('pdf-area');

    let opt = {
        margin:       10,
        filename:     'UserPayment-Transactions.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' },
        pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
    };

    html2pdf()
      .set(opt)
      .from(element)
      .save();
}

function exportCsvWithRowspan() {
    let csv = [];
    let rows = document.querySelectorAll("#paymentTransactionsTable tr");

    rows.forEach(row => {
        let cols = row.querySelectorAll("th, td");
        let rowData = [];

        cols.forEach(col => {
            let text = col.innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
            rowData.push('"' + text + '"');
        });

        csv.push(rowData.join(","));
    });

    // Download CSV file
    let csvString = csv.join("\n");
    let blob = new Blob([csvString], { type: "text/csv;charset=utf-8;" });
    let url = URL.createObjectURL(blob);
    let link = document.createElement("a");
    link.href = url;
    link.download = "UserPayment-Transactions-2025-26.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function exportExcelWithRowspan() {
  let table = document.getElementById('paymentTransactionsTable');
  let cloned = table.cloneNode(true);

  // Remove DataTables sorting arrows, filters etc.
  cloned.querySelectorAll('span, i').forEach(e => e.remove());

  // Convert to worksheet
  let wb = XLSX.utils.book_new();
  let ws = XLSX.utils.table_to_sheet(cloned, { raw: true });

  // Auto column width
  let colWidth = [];
  const range = XLSX.utils.decode_range(ws['!ref']);
  for(let C = range.s.c; C <= range.e.c; ++C) {
      colWidth.push({ wch: 20 });
  }
  ws['!cols'] = colWidth;

  // Add bold styling for Total Deposit column
  Object.keys(ws).forEach(cell => {
      if (cell.match(/^[A-Z]+\d+$/)) {
          if (ws[cell].v && ws[cell].v.toString().toLowerCase().includes("total")) {
              ws[cell].s = { font: { bold: true } };
          }
      }
  });

  XLSX.utils.book_append_sheet(wb, ws, "Transactions");
  XLSX.writeFile(wb, "UserPayment-Transactions-2025-26.xlsx");
}

function copyTableWithRowspan() {
  let range = document.createRange();
  range.selectNode(document.getElementById("paymentTransactionsTable"));
  window.getSelection().removeAllRanges();
  window.getSelection().addRange(range);
  document.execCommand("copy");
  alert("Table copied successfully!");
}

function printTableWithRowspan() {
  let tableHTML = document.getElementById("paymentTransactionsTable").outerHTML;

  let printWindow = window.open("", "", "height=700,width=1000");
  printWindow.document.write(`
      <html>
      <head>
        <title>Print Table</title>
        <style>
          table { width:100%; border-collapse: collapse; }
          th, td { border: 1px solid #000; padding: 8px; }
          b { font-weight: bold; }
        </style>
      </head>
      <body>
        <h2 style="text-align:center;">User Payment Transaction Report</h2>
        ${tableHTML}
      </body>
      </html>
  `);
  printWindow.document.close();
  printWindow.print();
}
function downloadReceipt(clientid) {
    let url = $('meta[name=app-url]').attr("content") + "client-transactions/receipt-download/" + clientid;
    window.open(url, "_self");
}

function createClientTransaction(){
  $("#update_id").val("");
  loadClients();
  loadPaymentModes();
  loadDepositTypes();
  $("#security_depo").val("");
  $("#paymentDate").val("");
  $("#note").val("");
  $("#client-transaction-modal").modal("show");
}

function storeTransaction(){
  let url = $('meta[name=app-url]').attr("content") + "client-transactions/store";
  let data = {
    client_id: $("#client_id").val(),
    payment_mode_id: $("#payment_mode_id").val(),
    deposit_type_id: $("#deposit_type_id").val(),
    security_depo: $("#security_depo").val(),
    paymentDate: $("#paymentDate").val(),
    note:$("#note").val()
  };
  $.post(url, data, function(){
    $("#alert-div").html('<div class="alert alert-success">Payment Added Successfully</div>');
    $("#client-transaction-modal").modal("hide");
    
  });
  setTimeout(function() {
    $("#alert-div").html('');
  }, 3000);
}

function viewClientTransactions(clientid) {
  let viewurl = $('meta[name=app-url]').attr("content") + "client-transactions/view/" + clientid;
    $.ajax({
        url: viewurl,
        type: "GET",
        dataType: "json",
        success: function(res) {
            console.log(res);
            if (res.length === 0) return;
            // user details from first record
            $("#v_clientid").text(res[0].clientid);
            $("#v_name").text(res[0].name);
            $("#v_phone").text(res[0].phone);
            $("#v_note").text(res[0].note ?? "-");
            
            let rows = "";
            
            let total = 0;
            
            res.forEach((p) => {
                rows += `
                    <tr>
                        <td>${formatDate(p.paymentDate)}</td>
                        <td>${p.payment_mode}</td>
                        <td>${p.deposit_type}</td>
                        <td><b>₹ ${p.security_depo}</b></td>
                        <td><b>${p.note ? p.note : ""}</b></td>
                    </tr>
                `;
                 total += parseFloat(p.security_depo);
            });
            $("#viewPaymentsBody").html(rows);
            // show total deposit
            $("#totalDeposit").text(total.toFixed(2));
            $("#viewClientTransModal").modal("show");
        }
    });
}

function editTransaction(id) {
  let url = $('meta[name=app-url]').attr("content") + "payment-transactions/edit/" + id;
  $.get(url, function(t){
    loadUsers(); loadPaymentModes();

    setTimeout(() => {
      $("#user_id").val(t.user_id);
      $("#payment_mode_id").val(t.payment_mode_id);
    }, 200);

    $("#update_id").val(t.id);
    $("#amount").val(t.amount);
    $("#transaction-modal").modal("show");
  }, "json");
}

function updateTransaction(){
  let id = $("#update_id").val();
  let url = $('meta[name=app-url]').attr("content") + "payment-transactions/update/" + id;

  let data = {
    user_id: $("#user_id").val(),
    payment_mode_id: $("#payment_mode_id").val(),
    amount: $("#amount").val()
  };

  $.post(url, data, function(){
    $("#alert-div").html('<div class="alert alert-success">Payment Updated Successfully</div>');
    $("#transaction-modal").modal("hide");
    showAllTransactions();
  });
}

function destroyTransaction(id){
  if (!confirm("Are you sure?")) return;

  let url = $('meta[name=app-url]').attr("content") + "payment-transactions/delete/" + id;
  $.post(url, {}, function(){
    $("#alert-div").html('<div class="alert alert-success">Payment Deleted Successfully</div>');
    showAllTransactions();
  });
}

function loadClients(){
  let url = $('meta[name=app-url]').attr("content") + "client-loads";
  $.get(url, function(data){
    console.log(data);
    let opt = '<option value="">Select User</option>';
    data.forEach(c => opt += `<option value="${c.id}">${c.name} (${c.phone}) - [${c.id}]</option>`);
    $("#client_id").html(opt);
  }, "json");
}

function loadPaymentModes(){
  let url = $('meta[name=app-url]').attr("content") + "payment-modes/list";
  $.get(url, function(data){
    let opt = '<option value="">Select Mode</option>';
    data.forEach(m => opt += `<option value="${m.id}">${m.payment_mode}</option>`);
    $("#payment_mode_id").html(opt);
  }, "json");
}

function loadDepositTypes(){
  let url = $('meta[name=app-url]').attr("content") + "depositTypes/list";
  $.get(url, function(res){
    console.log(res);
    let opt = '<option value="">Select Deposit Type</option>';
    res.forEach(d => opt += `<option value="${d.id}">${d.deposit_type}</option>`);
    $("#deposit_type_id").html(opt);
  }, "json");
}
function escapeHtml(text){
  return text ? text.replace(/[&<>"]/g, c => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c])) : "";
}

function formatDate(d) {
  let date = new Date(d);

  const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

  let formattedDate =
    ("0" + date.getDate()).slice(-2) + "-" +
    ("0" + (date.getMonth() + 1)).slice(-2) + "-" +
    date.getFullYear();

  let weekday = days[date.getDay()];

  return formattedDate + "<br><small class='text-primary'>" + weekday + "</small>";
}

</script>