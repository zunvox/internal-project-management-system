<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create New Invoice</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<style>

  /* ---------- Page layout ---------- */

  .page{
    width: 90%;
    max-width:1400px;
    margin:0 auto;
    padding:20px 24px 64px;
  }

  .breadcrumb{
    font-size:13px;
    color:#98A2B3;
    margin-bottom:6px;
  }

  .breadcrumb .current{
    color:#101828;
    font-weight:700;
  }

  .page-title{
    font-size:28px;
    font-weight:800;
    margin:0 0 4px;
  }

  .back-link{
    display:inline-block;
    font-size:13px;
    color:#101828;
    text-decoration:none;
    margin-bottom:18px;
  }

  .back-link:hover{
    text-decoration:none;
  }

  .columns{
    display:grid;
    grid-template-columns:1.3fr 1fr;
    gap:24px;
    align-items:start;
  }

  .card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    box-shadow:0 20px 50px rgba(43,111,255,0.18);
  }

  .card-header{
    padding:18px 24px;
    border-bottom:1px solid #E4E7EC;
  }

  .card-header h2{
    font-size:17px;
    font-weight:700;
    margin:0;
  }

  .card-body{
    padding:22px 24px 26px;
  }

  /* ---------- Form fields ---------- */

  .form-field{
    display:flex;
    flex-direction:column;
    gap:8px;
  }

  .form-field label{
    font-size:14px;
    font-weight:700;
    color:#101828;
  }

  .form-field input,
  .form-field select,
  .form-field textarea{
    width:100%;
    padding:10px 14px;
    font-size:13px;
    font-family:'Inter',system-ui,sans-serif;
    color:black;
    background-color:#ffffff;
    border:1px solid #D0D5DD;
    border-radius:10px;
    outline:none;
    transition:border-color 0.15s ease, box-shadow 0.15s ease;
  }

  .form-field textarea{
    resize:vertical;
    min-height:70px;
    font-family:'Inter',system-ui,sans-serif;
  }

  .form-field input:focus,
  .form-field select:focus,
  .form-field textarea:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 4px rgba(53, 56, 205, 0.14);
  }

  .field-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:22px;
  }

  .section-label{
    font-size:15px;
    font-weight:700;
    margin:0 0 14px;
  }

  /* ---------- Invoice items table ---------- */

  .items-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:10px;
  }

  .items-table th{
    text-align:left;
    font-size:12px;
    font-weight:700;
    color:#101828;
    padding:0 8px 8px 0;
  }

  .items-table td{
    padding:0 8px 10px 0;
    vertical-align:middle;
  }

  .items-table th.col-qty,
  .items-table td.col-qty{ width:70px; }

  .items-table th.col-price,
  .items-table td.col-price,
  .items-table th.col-amount,
  .items-table td.col-amount{ width:100px; }

  .items-table th.col-del,
  .items-table td.col-del{ width:28px; }

  .items-table input{
    width:100%;
    padding:8px 10px;
    font-size:12px;
    font-family:'Inter',system-ui,sans-serif;
    color:black;
    background:white;
    border:1px solid #D0D5DD;
    border-radius:8px;
    outline:none;
  }

  .items-table input:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 3px rgba(53, 56, 205, 0.14);
  }

  .items-table input::placeholder{
    color:#98A2B3;
  }

  .row-delete{
    display:flex;
    align-items:center;
    justify-content:center;
    width:28px;
    height:28px;
    border:none;
    background:none;
    cursor:pointer;
  }

  .row-delete svg{
    width:15px;
    height:15px;
    fill:#98A2B3;
  }

  .row-delete:hover svg{
    fill:#F04438;
  }

  .add-item-row{
    text-align:center;
    padding-top:2px;
    border-top:1px solid #E4E7EC;
    margin-bottom:22px;
  }

  .add-item-link{
    background:none;
    border:none;
    color:#2B6FFF;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    padding:10px 0 0;
  }

  .add-item-link:hover{
    text-decoration:underline;
  }

  /* ---------- Tax + Discount ---------- */

.calculation-fields{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
    margin-bottom:22px;
}

.calculation-field{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.calculation-field label{
    font-size:14px;
    font-weight:700;
    color:#101828;
}

.calculation-field input{
    width:100%;
    box-sizing:border-box;

    padding:8px 12px;

    font-size:13px;
    font-family:'Inter',system-ui,sans-serif;

    border:1px solid #D0D5DD;
    border-radius:8px;

    outline:none;

    background:white;
}

.calculation-field input:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 3px rgba(53,56,205,0.14);
}

  /* ---------- Attachment ---------- */

  .attachment-box{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    border:1px dashed #D0D5DD;
    border-radius:10px;
    padding:16px;
    background:#F9FAFB;
    color:#98A2B3;
    font-size:13px;
    cursor:pointer;
    margin-bottom:22px;
  }

  .attachment-box:hover{
    background:#F2F4F7;
  }

  .attachment-box .plus-icon{
    width:26px;
    height:26px;
    border:1px solid #98A2B3;
    border-radius:6px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
    color:#667085;
  }

  /* ---------- Preview card ---------- */

  .preview-subject{
    font-size:20px;
    font-weight:800;
    margin:0 0 2px;
  }

  .preview-invnum{
    font-size:12px;
    color:#98A2B3;
    padding-bottom:14px;
    border-bottom:1px solid #E4E7EC;
  }

  .preview-info{
    display:flex;
    justify-content:space-between;
    padding:16px 0;
    border-bottom:1px solid #E4E7EC;
  }

  .preview-info .label{
    font-size:12px;
    color:#98A2B3;
    margin-bottom:4px;
  }

  .preview-info .value{
    font-size:13px;
    color:#101828;
    line-height:1.5;
  }

  .preview-section-label{
    font-size:12px;
    color:#98A2B3;
    margin:16px 0 10px;
  }

  .preview-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:6px;
  }

  .preview-table th{
    text-align:left;
    font-size:11px;
    color:#98A2B3;
    font-weight:600;
    padding-bottom:8px;
  }

  .preview-table th.align-right,
  .preview-table td.align-right{
    text-align:right;
  }

  .preview-table td{
    font-size:13px;
    color:#101828;
    padding:4px 0;
  }

  .preview-empty-row td{
    text-align:center;
    color:#98A2B3;
    padding:16px 0;
    font-size:12px;
}

  .preview-summary{
    padding-top:8px;
  }

  .summary-line{
    display:flex;
    justify-content:space-between;
    font-size:13px;
    color:#101828;
    padding:6px 0;
  }

  .summary-line.total{
    font-weight:700;
    font-size:14px;
    border-top:1px solid #E4E7EC;
    margin-top:4px;
    padding-top:12px;
  }

  .preview-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    padding:18px 24px 22px;
    border-top:1px solid #E4E7EC;
    margin-top:8px;
  }

  .btn{
    border-radius:5px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    padding:7px 20px;
    display:inline-flex;
    align-items:center;
    gap:6px;
  }

  .btn svg{
    width:14px;
    height:14px;
  }

  .btn-draft{
    background:white;
    border:1px solid #D0D5DD;
    color:#101828;
  }

  .btn-draft:hover{
    background:#F9FAFB;
  }

  .btn-send{
    background:#2B6FFF;
    border:none;
    color:white;
  }

  .btn-send svg{
    fill:white;
  }

  .btn-draft svg{
    fill:#101828;
  }

  .btn-send:hover{
    background:#1f5ae0;
  }

</style>

</head>
<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

<div class = "stage">
<div class="page">

  <div class="breadcrumb">My Invoices &gt; <span class="current">Create</span></div>
  <h1 class="page-title">Create New Invoice</h1>
  <a class="back-link" href="{{ route('developer.invoices.index') }}"> &larr; Back to My Invoices</a>

  <form action="{{ route('developer.invoices.store') }}" method="POST" enctype="multipart/form-data" id="invoice-form">
    
    @csrf

  <div class="columns">

    <!-- Invoice Detail -->
    <div class="card">
      <div class="card-header">
        <h2>Invoice Detail</h2>
      </div>

      <div class="card-body">

        <div class="field-row">
          <div class="form-field">
            <label for="subject">Invoice Subject</label>
            <input id="subject" type="text" name="subject" value="{{ old('subject') }}" placeholder="e.g. Cloud Hosting & Support"required>
          </div>

            <div class="form-field">
                <label for="project">Project Name</label>

                <select id="project" name="project_id" required>

                    <option value="" disabled {{ old('project_id') ? '' : 'selected' }}>
                        Select project
                    </option>

                    @foreach ($projects as $project)

                        <option
                            value="{{ $project->id }}"
                            {{ old('project_id') == $project->id ? 'selected' : '' }}
                        >
                            {{ $project->name }}
                        </option>

                    @endforeach
                </select>
            </div>
        </div>

        <h3 class="section-label">Invoice Items/Services</h3>

        <table class="items-table">
          <thead>
            <tr>
              <th>Items</th>
              <th class="col-qty">Quantity</th>
              <th class="col-price">Unit Price</th>
              <th class="col-amount">Amount</th>
              <th class="col-del"></th>
            </tr>
          </thead>
          <tbody id="items-body">

                <tr class="item-row">

                    <td>
                        <input
                            type="text"
                            name="items[0][item_name]"
                            class="item-name"
                            placeholder="Insert item..."
                            required
                        >
                    </td>

                    <td class="col-qty">
                        <input
                            type="number"
                            name="items[0][quantity]"
                            class="item-quantity"
                            min="1"
                            value="1"
                            required
                        >
                    </td>

                    <td class="col-price">
                        <input
                            type="number"
                            name="items[0][unit_price]"
                            class="item-price"
                            min="0"
                            step="0.01"
                            value="0"
                            required
                        >
                    </td>

                    <td class="col-amount">
                        <input
                            type="text"
                            class="item-total"
                            value="RM 0.00"
                            readonly
                        >
                    </td>

                    <td class="col-del">

                        <button
                            class="row-delete"
                            type="button"
                        >
                            <svg viewBox="0 0 24 24">
                                <path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H4v2h16V4h-4.5l-1-1ZM18 7H6v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7Z"/>
                            </svg>
                        </button>

                    </td>

                </tr>

            </tbody>
        </table>

        <div class="add-item-row">
          <button class="add-item-link" type="button" id="add-item-btn">+ Add New Item</button>
        </div>

        <div class="calculation-fields">

        <div class="calculation-field">

            <label for="tax_percentage">
            Tax (%)
            </label>

            <input
            id="tax_percentage"
            name="tax_percentage"
            type="number"
            min="0"
            max="100"
            step="0.01"
            value="10"
            placeholder="0"
            >

        </div>


        <div class="calculation-field">

            <label for="discount_amount">
            Discount (RM)
            </label>

            <input
            id="discount_amount"
            name="discount_amount"
            type="number"
            min="0"
            step="0.01"
            value="0"
            placeholder="0.00"
            >

        </div>

        </div>

        <label class="attachment-box" for="attachment">
            <span class="plus-icon">+</span>

            <span id="attachment-label">
                Insert Supporting Document Attachment (Optional)
            </span>
        </label>

        <input id="attachment" type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png" hidden>

        <div class="form-field">

    <label for="description">
        Description
    </label>

    <textarea
        id="description"
        name="description"
        placeholder="Enter additional invoice details or notes"
    >{{ old('description') }}</textarea>

</div>

      </div>
    </div>

    <!-- Preview -->
    <div class="card">
      <div class="card-header">
        <h2>Preview</h2>
      </div>

      <div class="card-body">

        <h3 class="preview-subject" id="preview-subject">Invoice Subject</h3>
        <div class="preview-invnum">Invoice Number INV-0120</div>

        <div class="preview-info">
          <div>
              <div class="label">Prepared By:</div>

              <div class="value">{{ auth()->user()->fullname ?? auth()->user()->username }}</div>

              <div class="label" style="margin-top:10px;">Project: </div>

              <div class="value" id="preview-project">No project selected</div>
          </div>

          <div>
              <div class="label">Date Issued:</div>
              <div class="value">{{ now()->format('F j, Y') }}</div>
          </div>
      </div>

        <div class="preview-section-label">Invoice Details</div>

        <table class="preview-table">
          <thead>
            <tr>
              <th>Items/ Services</th>
              <th class="align-right">Quantity</th>
              <th class="align-right">Unit Price</th>
              <th class="align-right">Total</th>
            </tr>
          </thead>
          <tbody id="preview-items-body">
              <tr class="preview-empty-row">
                  <td colspan="4">No invoice items added yet.</td>
              </tr>
          </tbody>
        </table>

        <div class="preview-summary">

            <div class="summary-line">

                <span>
                    Subtotal
                </span>

                <span id="preview-subtotal">
                    RM 0.00
                </span>

            </div>


            <div class="summary-line">

                <span id="preview-tax-label">
                    Tax (0%)
                </span>

                <span id="preview-tax">
                    RM 0.00
                </span>

            </div>


            <div class="summary-line">

                <span>
                    Discount
                </span>

                <span id="preview-discount">
                    RM 0.00
                </span>

            </div>


            <div class="summary-line total">

                <span>
                    Grand Total
                </span>

                <span id="preview-grand-total">
                    RM 0.00
                </span>

            </div>

        </div>

      </div>

      <div class="preview-actions">
                <button
            class="btn btn-draft"
            type="submit"
            name="status"
            value="Draft"
        >
            Save as Draft
        </button>

        <button
            class="btn btn-send"
            type="submit"
            name="status"
            value="Submitted"
        >
            Submit Invoice
        </button>
      </div>
    </div>

  </div>
</form>
</div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () 
{

    const itemsBody = document.getElementById('items-body');

    const addItemButton = document.getElementById('add-item-btn');

    const taxInput = document.getElementById('tax_percentage');

    const discountInput = document.getElementById('discount_amount');

    const subjectInput = document.getElementById('subject');

    const previewSubject = document.getElementById('preview-subject');

    const projectInput = document.getElementById('project');
    
    const previewProject = document.getElementById('preview-project');

    const previewItemsBody = document.getElementById('preview-items-body');

    const attachmentInput = document.getElementById('attachment');
    
    const attachmentLabel = document.getElementById('attachment-label');

    let itemIndex = 1;

    subjectInput.addEventListener('input', function () 
    {
      previewSubject.textContent = subjectInput.value.trim() || 'Invoice Subject';
    });

    function formatMoney(value) 
    {
        return 'RM ' + Number(value).toFixed(2);
    }

    projectInput.addEventListener('change', function () {

    const selectedOption = projectInput.options[projectInput.selectedIndex];

    previewProject.textContent = projectInput.value ? selectedOption.text : 'No project selected';
  
  });

  attachmentInput.addEventListener('change', function () 
    {
        if (attachmentInput.files.length > 0) 
        {
            attachmentLabel.textContent = attachmentInput.files[0].name;
        } 
        else 
        {
            attachmentLabel.textContent = 'Insert Supporting Document Attachment (Optional)';
        }
    }
);

    function updatePreviewItems() {

        const rows = document.querySelectorAll('.item-row');

        previewItemsBody.innerHTML = '';

        let hasItem = false;


        rows.forEach(function (row) 
        {

            const itemName = row.querySelector('.item-name').value.trim();

            const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;

            const price = parseFloat(row.querySelector('.item-price').value) || 0;

            if (!itemName) 
            {
                return;
            }

            hasItem = true;

            const total = quantity * price;


            const previewRow = document.createElement('tr');


            previewRow.innerHTML = `
                <td>
                    ${escapeHtml(itemName)}
                </td>

                <td class="align-right">
                    ${quantity}
                </td>

                <td class="align-right">
                    ${formatMoney(price)}
                </td>

                <td class="align-right">
                    ${formatMoney(total)}
                </td>`;


            previewItemsBody.appendChild(previewRow);
        });


        if (!hasItem) 
        {

            previewItemsBody.innerHTML = `
                <tr class="preview-empty-row">
                    <td colspan="4">No invoice items added yet.</td>
                </tr>`;
        }
    }

    function escapeHtml(value) 
    {
      const div = document.createElement('div');
      div.textContent = value;

      return div.innerHTML;
    }

    function calculateInvoice() 
    {

        let subtotal = 0;

        document
            .querySelectorAll('.item-row')
            .forEach(function (row) {

                const quantity =
                    parseFloat(
                        row.querySelector(
                            '.item-quantity'
                        ).value
                    ) || 0;

                const price =
                    parseFloat(
                        row.querySelector(
                            '.item-price'
                        ).value
                    ) || 0;

                const total =
                    quantity * price;

                row.querySelector(
                    '.item-total'
                ).value =
                    formatMoney(total);

                subtotal += total;

            });


        const taxPercentage = parseFloat(taxInput.value) || 0;

        const discount = parseFloat(discountInput.value) || 0;

        const taxAmount = subtotal * (taxPercentage / 100);

        const grandTotal = subtotal + taxAmount - discount;

        document.getElementById('preview-subtotal').textContent = formatMoney(subtotal);

        document.getElementById('preview-tax-label').textContent = `Tax (${taxPercentage}%)`;

        document.getElementById('preview-tax').textContent = formatMoney(taxAmount);

        document.getElementById('preview-discount').textContent = formatMoney(discount);

        document.getElementById('preview-grand-total').textContent = formatMoney(Math.max(grandTotal, 0));
        
        updatePreviewItems();

    }


    addItemButton.addEventListener(
        'click',
        function () {

            const row =
                document.createElement('tr');

            row.classList.add('item-row');

            row.innerHTML = `

                <td>
                    <input
                        type="text"
                        name="items[${itemIndex}][item_name]"
                        class="item-name"
                        placeholder="Insert item..."
                        required
                    >
                </td>

                <td class="col-qty">

                    <input
                        type="number"
                        name="items[${itemIndex}][quantity]"
                        class="item-quantity"
                        min="1"
                        value="1"
                        required
                    >

                </td>

                <td class="col-price">

                    <input
                        type="number"
                        name="items[${itemIndex}][unit_price]"
                        class="item-price"
                        min="0"
                        step="0.01"
                        value="0"
                        required
                    >

                </td>

                <td class="col-amount">

                    <input
                        type="text"
                        class="item-total"
                        value="RM 0.00"
                        readonly
                    >

                </td>

                <td class="col-del">

                    <button
                        class="row-delete"
                        type="button"
                    >

                        <svg viewBox="0 0 24 24">
                            <path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H4v2h16V4h-4.5l-1-1ZM18 7H6v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7Z"/>
                        </svg>

                    </button>

                </td>

            `;

            itemsBody.appendChild(row);

            itemIndex++;

            calculateInvoice();

        }
    );


    itemsBody.addEventListener('input', function (event) 
    {
            if (event.target.classList.contains('item-name') || event.target.classList.contains('item-quantity') || event.target.classList.contains('item-price')) 
            {
              calculateInvoice();
            }
    }
);


    itemsBody.addEventListener(
        'click',
        function (event) {

            const deleteButton =
                event.target.closest(
                    '.row-delete'
                );

            if (!deleteButton) {
                return;
            }

            const rows =
                itemsBody.querySelectorAll(
                    '.item-row'
                );


            if (rows.length <= 1) {

                alert(
                    'At least one invoice item is required.'
                );

                return;

            }


            deleteButton
                .closest('.item-row')
                .remove();


            calculateInvoice();

        }
    );


    taxInput.addEventListener(
        'input',
        calculateInvoice
    );


    discountInput.addEventListener(
        'input',
        calculateInvoice
    );

    previewSubject.textContent =
    subjectInput.value.trim() || 'Invoice Subject';


if (projectInput.value) {

    previewProject.textContent =
        projectInput.options[
            projectInput.selectedIndex
        ].text;

}

    calculateInvoice();

});

</script>

</body>
</html>