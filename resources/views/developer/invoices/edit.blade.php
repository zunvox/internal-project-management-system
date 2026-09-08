<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Draft Invoice</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<style>

  /* ---------- Page layout ---------- */

  .page{
    width:90%;
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

  .page-header-row{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
  }

  .title-row{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:2px;
  }

  .page-title{
    font-size:28px;
    font-weight:800;
    margin:0;
  }

  .status-pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
  }

  .status-pill::before{
    content:"";
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
  }

  .status-draft{
    background:#EAECF0;
    color:#667085;
  }

  .back-link{
    display:inline-block;
    font-size:13px;
    color:#101828;
    text-decoration:none;
  }

  .back-link:hover{
    text-decoration:none;
  }

  .btn-download{
    background:#2B6FFF;
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:5px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    gap:8px;
    white-space:nowrap;
    margin-top:2px;
  }

  .btn-download svg{
    width:14px;
    height:14px;
    fill:white;
  }

  .btn-download:hover{
    background:#1f5ae0;
  }

  /* ---------- Card ---------- */

  .card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    box-shadow:0 20px 50px rgba(43,111,255,0.18);
    padding:22px 28px 26px;
    margin-top:16px;
  }

  .card-title{
    font-size:18px;
    font-weight:700;
    margin:0 0 18px;
  }

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
    margin-bottom:20px;
  }

  hr.divider{
    border:none;
    border-top:1px solid #E4E7EC;
    margin:20px 0;
  }

  .section-label{
    font-size:15px;
    font-weight:700;
    margin:0 0 12px;
  }

  /* ---------- Items + Description row ---------- */

  .items-description-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    align-items:start;
    margin-bottom:20px;
  }

  .items-table{
    width:100%;
    border-collapse:collapse;
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
  }

  .items-table th.col-qty,
  .items-table td.col-qty{ width:70px; }

  .items-table th.col-price,
  .items-table td.col-price{ width:100px; }

  .items-table th.col-del,
  .items-table td.col-del{ width:26px; }

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
    width:26px;
    height:26px;
    border:none;
    background:none;
    cursor:pointer;
  }

  .row-delete svg{
    width:14px;
    height:14px;
    fill:#98A2B3;
  }

  .row-delete:hover svg{
    fill:#F04438;
  }

  .add-item-row{
    text-align:center;
    padding-top:2px;
    border-top:1px solid #E4E7EC;
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

  .description-field textarea{
    height:100%;
    min-height:150px;
    resize:vertical;
    font-family:'Inter',system-ui,sans-serif;
  }

  /* ---------- Tax / Discount / Attachment row ---------- */

  .bottom-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    align-items:start;
    margin-bottom:24px;
  }

  .discount-input-wrap{
    position:relative;
  }

  .discount-input-wrap span{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    font-size:13px;
    color:#667085;
  }

  .discount-input-wrap input{
    padding-left:38px;
  }

  .tax-discount-row{
    display:grid;
    grid-template-columns:200px 1fr;
    gap:28px;
    align-items:start;
  } 

  .attachment-box{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:8px;
    border:1px dashed #D0D5DD;
    border-radius:10px;
    padding:16px;
    background:#F9FAFB;
    color:#98A2B3;
    font-size:12px;
    cursor:pointer;
    text-align:center;
    height:100%;
    min-height:70px;
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

  .attachment-actions{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:14px;
    margin-top:6px;
  }

  .current-attachment-link,
  .remove-attachment-btn{
    display:inline-flex;
    align-items:center;
    line-height:1;
    font-size:12px;
  }

  .current-attachment-link{
    color:#2B6FFF;
    text-decoration:none;
  }

  .remove-attachment-btn{
    border:none;
    background:none;
    padding:0;
    margin:0;
    color:#F04438;
    font-weight:600;
    font-family:'Inter', system-ui, sans-serif;
    cursor:pointer;
  }

  .remove-attachment-btn:hover{
    text-decoration:underline;
  }

  /* ---------- Actions ---------- */

  .card-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
  }

  .btn{
    border:none;
    border-radius:5px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    padding:10px 20px;
    display:inline-flex;
    align-items:center;
    gap:8px;
  }

  .btn svg{
    width:14px;
    height:14px;
    fill:white;
  }

  .btn-delete{
    background:#F04438;
    color:white;
  }

  .btn-delete:hover{
    background:#d92d20;
  }

  .btn-draft{
    background:#667085;
    color:white;
  }

  .btn-draft:hover{
    background:#475467;
  }

  .btn-send{
    background:#12B76A;
    color:white;
  }

  .btn-send:hover{
    background:#0d9c58;
  }

</style>
</head>
<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')
    
<div class="stage">
<div class="page">

  <div class="breadcrumb">My Invoices &gt;<span class="current">{{ $invoice->invoice_code }}</span></div>

  <div class="page-header-row">
    <div>
      <div class="title-row">
        <h1 class="page-title">Invoice {{ $invoice->invoice_code }}</h1>
        <span class="status-pill status-draft">{{ $invoice->status }}</span>
      </div>
      <a
    class="back-link"
    href="{{ route('developer.invoices.index') }}">&larr; Back to My Invoices</a>
    </div>

    <button class="btn-download" type="button">
      <svg viewBox="0 0 24 24"><path d="M5 20h14v-2H5v2ZM19 9h-4V3H9v6H5l7 7 7-7Z"/></svg>
      Download PDF
    </button>
  </div>

  <div class="card">
    <h2 class="card-title">Invoice Detail</h2>

    <form action="{{ route('developer.invoices.update', $invoice) }}" method="POST" enctype="multipart/form-data" id="invoice-edit-form">

    @csrf
    @method('PUT')

    @if ($errors->any())
    <div style="background:#FEE4E2; color:#B42318; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
        <strong>Please fix the following:</strong>

        <ul style="margin:8px 0 0 18px;">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>
    </div>

    @endif

    <div class="field-row">
      <div class="form-field">
        <label for="subject">Invoice Subject</label>
        <input id="subject" name="subject" type="text" value="{{ old('subject', $invoice->subject) }}" required>
      </div>

      <div class="form-field">
          <label for="project_id">Project Name</label>

          <select id="project_id" name="project_id" required>

              @foreach ($projects as $project)

                  <option
    value="{{ $project->id }}" {{ old('project_id', $invoice->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>

              @endforeach

          </select>
      </div>
    </div>

    <hr class="divider">

    <div class="items-description-row">
      <div>
        <h3 class="section-label">Invoice Items/ Services</h3>

        <table class="items-table">
          <thead>
            <tr>
              <th>Items</th>
              <th class="col-qty">Quantity</th>
              <th class="col-price">Unit Price</th>
              <th class="col-del"></th>
            </tr>
          </thead>
          <tbody id="items-body">

              @foreach ($invoice->items as $index => $item)

                  <tr class="item-row">

                      <td>
                          <input
                              type="text"
                              name="items[{{ $index }}][item_name]"
                              class="item-name"
                              value="{{ old("items.$index.item_name", $item->item_name) }}"
                              placeholder="Insert New Item..."
                              required
                          >
                      </td>

                      <td class="col-qty">
                          <input
                              type="number"
                              name="items[{{ $index }}][quantity]"
                              class="item-quantity"
                              value="{{ old("items.$index.quantity", $item->quantity) }}"
                              min="1"
                              required
                          >
                      </td>

                      <td class="col-price">
                          <input
                              type="number"
                              name="items[{{ $index }}][unit_price]"
                              class="item-price"
                              value="{{ old("items.$index.unit_price", $item->unit_price) }}"
                              min="0"
                              step="0.01"
                              required
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

              @endforeach

          </tbody>
        </table>

        <div class="add-item-row">
          <button class="add-item-link" id="add-item-btn" type="button">+ Add New Items</button>
        </div>
      </div>

      <div class="form-field description-field">
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Add any additional notes or payment instructions">{{ old('description', $invoice->description) }}</textarea>
      </div>
    </div>

    <div class="bottom-row">

        <div class="tax-discount-row">

            <div class="form-field">
                <label for="tax_percentage">Tax Percentage (%)</label>

                <input
                    id="tax_percentage"
                    name="tax_percentage"
                    type="number"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('tax_percentage', (float) ($invoice->tax_percentage ?? 0)) }}"
                    placeholder="Enter tax percentage"
                    required>
            </div>


            <div class="form-field">

                <label for="discount">
                    Discount (Optional)
                </label>

                <div class="discount-input-wrap">

                    <span>RM</span>

                    <input
                        id="discount"
                        name="discount_amount"
                        type="number"
                        min="0"
                        step="0.01"
                        value="{{ old('discount_amount', $invoice->discount_amount) }}"
                        placeholder="Enter discount amount"
                    >

                </div>

            </div>

        </div>


        <div class="form-field">

            <label for="attachment">Supporting Document (Optional)</label>

            <label
                for="attachment"
                class="attachment-box"
                id="attachment-box"
            >
                <span class="plus-icon">+</span>

                <span id="attachment-text">

                    @if ($invoice->attachment)

                        {{ basename($invoice->attachment) }}

                    @else

                        Insert Supporting Document Attachment

                    @endif

                </span>
            </label>

            <input
                id="attachment"
                name="attachment"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png"
                hidden
            >

            <input
                type="hidden"
                name="remove_attachment"
                id="remove_attachment"
                value="0"
            >

            @if ($invoice->attachment)

                <div class="attachment-actions" id="current-attachment-actions">

                    <a
                        href="{{ asset('storage/' . $invoice->attachment) }}"
                        target="_blank"
                        class="current-attachment-link"
                    >
                        View Attachment
                    </a>

                    <button type="button" class="remove-attachment-btn" id="remove-attachment-btn">Remove Attachment</button>

                </div>

            @endif

        </div>

    </div>

      <div class="card-actions">

        <button class="btn btn-delete" type="button" id="delete-invoice-btn">
            <svg viewBox="0 0 24 24"><path d="M6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Zm3-3h6l1 2h4v2H4V6h4l1-2Z"/></svg>
            Delete Invoice
        </button>

          <button class="btn btn-draft" type="submit" name="status" value="Draft">Save Draft</button>

          <button class="btn btn-send" type="submit" name="status" value="Submitted">
              <svg viewBox="0 0 24 24"><path d="M2 21 23 12 2 3v7l15 2-15 2v7Z"/></svg>
              Send Invoice
          </button>
      </div>

    </form>

    <form id="delete-invoice-form" action="{{ route('developer.invoices.destroy', $invoice) }}" method="POST" style="display:none;">

        @csrf
        @method('DELETE')
    </form>
    </div>
  </div>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const itemsBody = document.getElementById('items-body');
    const addItemButton = document.getElementById('add-item-btn');

    let itemIndex = itemsBody.querySelectorAll('.item-row').length;

    addItemButton.addEventListener('click', function () {

        const row = document.createElement('tr');

        row.classList.add('item-row');

        row.innerHTML = `
            <td>
                <input
                    type="text"
                    name="items[${itemIndex}][item_name]"
                    class="item-name"
                    placeholder="Insert New Item..."
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
                    placeholder="0.00"
                    required
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
    });


    itemsBody.addEventListener('click', function (event) {

        const deleteButton = event.target.closest('.row-delete');

        if (!deleteButton) {
            return;
        }

        const rows = itemsBody.querySelectorAll('.item-row');

        if (rows.length <= 1) {
            alert('An invoice must contain at least one item.');
            return;
        }

        deleteButton.closest('.item-row').remove();
    });

    const attachmentInput = document.getElementById('attachment');

    const attachmentText = document.getElementById('attachment-text');

    const removeAttachmentInput = document.getElementById('remove_attachment');

    const removeAttachmentButton = document.getElementById('remove-attachment-btn');

    const currentAttachmentActions = document.getElementById('current-attachment-actions');


    attachmentInput.addEventListener('change', function () 
    {

        if (this.files.length > 0) 
        {

            attachmentText.textContent = this.files[0].name;

            removeAttachmentInput.value = '0';

            if (currentAttachmentActions) 
            { 
              currentAttachmentActions.style.display = 'none';
            }
        }

    });


    if (removeAttachmentButton) 
    {

        removeAttachmentButton.addEventListener('click', function () {

            removeAttachmentInput.value = '1';

            attachmentInput.value = '';

            attachmentText.textContent = 'No attachment selected';

            currentAttachmentActions.style.display = 'none';
        });

    }

    const deleteInvoiceButton = document.getElementById('delete-invoice-btn');

    const deleteInvoiceForm = document.getElementById('delete-invoice-form');

    deleteInvoiceButton.addEventListener('click', function () 
    {

        const confirmed = confirm('Are you sure you want to delete this invoice? This action cannot be undone.');

        if (confirmed) 
        {
            deleteInvoiceForm.submit();
        }

    });

});
</script>

</body>
</html>