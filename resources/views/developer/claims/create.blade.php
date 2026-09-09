<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create New Claim</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<style>

.page{
    width:90%;
    max-width:1400px;
    margin:0 auto;
    padding:28px 24px 64px;
    box-sizing:border-box;
}

.breadcrumb{
    font-size:13px;
    color:#98A2B3;
    margin-bottom:6px;
}

.breadcrumb a{
    color:#98A2B3;
    text-decoration:none;
}

.breadcrumb a:hover{
    color:#2B6FFF;
}

.breadcrumb .current{
    color:#101828;
    font-weight:700;
}

.page-title{
    font-size:28px;
    font-weight:800;
    margin:0 0 24px;
}


/* ---------- Form card ---------- */

.form-wrap{
    display:flex;
    justify-content:center;
}

.card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    box-shadow:0 20px 50px rgba(43,111,255,0.18);
    width:100%;
    max-width:800px;
    padding:22px 24px 24px;
}

.card-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    margin-bottom:18px;
}

.card-title{
    font-size:17px;
    font-weight:700;
    margin:0;
}

.claim-id{
    display:flex;
    flex-direction:column;
    align-items:flex-end;
    flex-shrink:0;
}

.claim-id-label{
    font-size:10px;
    font-weight:600;
    color:#98A2B3;
    text-transform:uppercase;
    letter-spacing:0.04em;
}

.claim-id-value{
    margin-top:3px;
    font-size:14px;
    font-weight:700;
    color:#101828;
}

.form-field{
    display:flex;
    flex-direction:column;
    gap:8px;
    margin-bottom:18px;
}

.form-field label{
    font-size:13px;
    font-weight:600;
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
}

.form-field input::placeholder,
.form-field textarea::placeholder{
    color:#98A2B3;
}

.form-field input:focus,
.form-field select:focus,
.form-field textarea:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 4px rgba(53,56,205,0.14);
}

.amount-input-wrap{
    position:relative;
}

.amount-input-wrap span{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    font-size:13px;
    color:#101828;
    font-weight:600;
    pointer-events:none;
}

.amount-input-wrap input{
    padding-left:38px;
}


/* ---------- Receipt upload ---------- */

.receipt-input{
    display:none;
}

.receipt-box{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:8px;
    border:1px dashed #A9C4FF;
    border-radius:10px;
    padding:16px 20px;
    background:#F5F8FF;
    text-align:center;
    cursor:pointer;
}

.receipt-box:hover{
    background:#EEF3FF;
}

.receipt-box .plus-icon{
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

.receipt-box .receipt-main{
    font-size:12px;
    color:#475467;
}

.receipt-box .receipt-sub{
    font-size:11px;
    color:#98A2B3;
}

.receipt-file-name{
    font-size:11px;
    font-weight:600;
    color:#344054;
    word-break:break-word;
}

.field-error{
    display:flex;
    align-items:center;
    gap:5px;
    font-size:11px;
    font-weight:600;
    color:#F04438;
    margin-top:6px;
}

.field-error svg{
    width:12px;
    height:12px;
    fill:#F04438;
    flex-shrink:0;
}


/* ---------- Acknowledgement ---------- */

.acknowledgement{
    display:flex;
    align-items:flex-start;
    gap:8px;
    margin-bottom:20px;
}

.acknowledgement input{
    width:16px;
    height:16px;
    margin-top:2px;
    accent-color:#2B6FFF;
    cursor:pointer;
}

.acknowledgement label{
    font-size:12px;
    color:#475467;
    line-height:1.5;
}


/* ---------- Actions ---------- */

.card-actions{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:16px;
}

.link-cancel{
    font-size:13px;
    font-weight:600;
    color:#2B6FFF;
    background:none;
    border:none;
    cursor:pointer;
    text-decoration:none;
}

.btn-confirm{
    background:#2B6FFF;
    color:white;
    border:none;
    padding:9px 24px;
    border-radius:5px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
}

.btn-confirm:hover{
    background:#1f5ae0;
}

</style>

</head>

<body>

@include('admin.partials.admin-topbar')
@include('admin.partials.admin-nav')

<div class="stage">
<div class="page">

    <div class="breadcrumb">

        <a href="{{ route('developer.claims.index') }}">My Claims</a>

        &gt;

        <span class="current">Create</span>

    </div>

    <h1 class="page-title">Create New Claim</h1>


    <div class="form-wrap">
        <div class="card">

            <div class="card-header">
                <h2 class="card-title">Expenses Claim Form</h2>

                <div class="claim-id">
                    <span class="claim-id-label">Claim ID</span>
                    <span class="claim-id-value">{{ $claimCode }}</span>
                </div>
            </div>


            <form action="{{ route('developer.claims.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <!-- Claim Title -->

                <div class="form-field">
                    <label for="claim_title">Claim Title</label>
                    <input
                        id="claim_title"
                        name="title"
                        type="text"
                        value="{{ old('title') }}"
                        placeholder="For example: Client meeting lunch"
                        required
                    >

                    @error('title')

                        <div class="field-error">
                            <svg viewBox="0 0 24 24"><path d="M12 2 1 21h22L12 2Zm0 15a1.2 1.2 0 1 1 0-2.4 1.2 1.2 0 0 1 0 2.4Zm1-4h-2V9h2v4Z"/></svg>
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- Claim Category -->

                <div class="form-field">
                    <label for="claim_category">Claim Category</label>
                    <select id="claim_category" name="category_id" required>

                        <option value="">Select Category</option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                data-category-name="{{ $category->category_name }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->category_name }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')

                        <div class="field-error">
                            <svg viewBox="0 0 24 24"><path d="M12 2 1 21h22L12 2Zm0 15a1.2 1.2 0 1 1 0-2.4 1.2 1.2 0 0 1 0 2.4Zm1-4h-2V9h2v4Z"/></svg>
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <!-- Other Category -->
                <div
                    class="form-field"
                    id="other-category-field"
                    style="display:none;"
                >
                    <label for="other_category">
                        Specify Category
                    </label>

                    <input
                        id="other_category"
                        name="other_category"
                        type="text"
                        value="{{ old('other_category') }}"
                        placeholder="Enter claim category"
                        maxlength="100"
                    >

                    @error('other_category')
                        <div class="field-error">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 2 1 21h22L12 2Zm0 15a1.2 1.2 0 1 1 0-2.4 1.2 1.2 0 0 1 0 2.4Zm1-4h-2V9h2v4Z"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Claim Amount -->

                <div class="form-field">
                    <label for="claim_amount">Claim Amount</label>
                    <div class="amount-input-wrap">

                        <span>RM</span>

                        <input
                            id="claim_amount"
                            name="amount"
                            type="number"
                            step="0.01"
                            min="0.01"
                            value="{{ old('amount') }}"
                            placeholder="0.00"
                            required
                        >

                    </div>

                    @error('amount')

                        <div class="field-error">
                            <svg viewBox="0 0 24 24"><path d="M12 2 1 21h22L12 2Zm0 15a1.2 1.2 0 1 1 0-2.4 1.2 1.2 0 0 1 0 2.4Zm1-4h-2V9h2v4Z"/></svg>
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <!-- Upload Receipt -->

                <div class="form-field">

                    <label>Upload Receipt</label>

                    <input
                        id="receipt"
                        class="receipt-input"
                        name="receipt"
                        type="file"
                        accept=".jpg,.jpeg,.png,.pdf"
                    >


                    <label for="receipt" class="receipt-box">

                        <span class="plus-icon">+</span>
                        <span class="receipt-main">A receipt is required before this claim can be submitted</span>
                        <span class="receipt-sub">Accepted: JPG, PNG, PDF · Max 10MB</span>
                        <span id="receipt-file-name" class="receipt-file-name"></span>

                    </label>


                    <div
                        id="receipt-error"
                        class="field-error"

                        @if (!$errors->has('receipt'))
                            style="display:none;"

                        @endif
                        >
                        <svg viewBox="0 0 24 24"><path d="M12 2 1 21h22L12 2Zm0 15a1.2 1.2 0 1 1 0-2.4 1.2 1.2 0 0 1 0 2.4Zm1-4h-2V9h2v4Z"/></svg>

                        <span id="receipt-error-text">
                            @error('receipt')
                                {{ $message }}
                            @else
                                Receipt Required
                            @enderror
                        </span>
                    </div>

                </div>


                <!-- Description -->

                <div class="form-field">

                    <label for="description">Description</label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Add any relevant details..."
                    >{{ old('description') }}</textarea>

                    @error('description')

                        <div class="field-error">
                            <svg viewBox="0 0 24 24"><path d="M12 2 1 21h22L12 2Zm0 15a1.2 1.2 0 1 1 0-2.4 1.2 1.2 0 0 1 0 2.4Zm1-4h-2V9h2v4Z"/></svg>
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- Acknowledgement -->

                <div class="acknowledgement">

                    <input
                        id="ack"
                        name="acknowledgement"
                        type="checkbox"
                        value="1"
                        required
                        {{ old('acknowledgement', true) ? 'checked' : '' }}
                    >

                    <label for="ack">I confirm this expense is accurate and compliant.</label>

                </div>


                <!-- Actions -->

                <div class="card-actions">
                    <a href="{{ route('developer.claims.index') }}" class="link-cancel">Cancel</a>
                    <button class="btn-confirm" type="submit">Confirm</button>
                </div>

            </form>

        </div>

    </div>

</div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function ()
    {
        /*
         * Other category field
         */
        const categorySelect =
            document.getElementById('claim_category');

        const otherCategoryField =
            document.getElementById('other-category-field');

        const otherCategoryInput =
            document.getElementById('other_category');

        function toggleOtherCategory()
        {
            const selectedOption =
                categorySelect.options[
                    categorySelect.selectedIndex
                ];

            const categoryName =
                selectedOption
                    ? selectedOption.dataset.categoryName
                    : '';

            if (categoryName === 'Other')
            {
                otherCategoryField.style.display =
                    'flex';

                otherCategoryInput.required =
                    true;
            }
            else
            {
                otherCategoryField.style.display =
                    'none';

                otherCategoryInput.required =
                    false;

                otherCategoryInput.value =
                    '';
            }
        }

        categorySelect.addEventListener(
            'change',
            toggleOtherCategory
        );

        toggleOtherCategory();


        /*
         * Receipt upload
         */
        const receiptInput =
            document.getElementById('receipt');

        const fileNameDisplay =
            document.getElementById('receipt-file-name');

        const receiptError =
            document.getElementById('receipt-error');

        const claimForm =
            receiptInput.closest('form');

        receiptInput.addEventListener(
            'change',
            function ()
            {
                if (this.files.length > 0)
                {
                    fileNameDisplay.textContent =
                        this.files[0].name;

                    receiptError.style.display =
                        'none';
                }
                else
                {
                    fileNameDisplay.textContent =
                        '';
                }
            }
        );

        claimForm.addEventListener(
            'submit',
            function (event)
            {
                if (
                    !receiptInput.files
                    || receiptInput.files.length === 0
                )
                {
                    event.preventDefault();

                    receiptError.style.display =
                        'flex';

                    receiptInput
                        .closest('.form-field')
                        .scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                }
            }
        );
    }
);
</script>

</body>

</html>