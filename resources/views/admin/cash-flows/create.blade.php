<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Transaction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .page {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px 24px 64px;
            box-sizing: border-box;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            margin: 0 0 14px;
            color: #101828;
        }


        /* ---------- Top Action Cards ---------- */

        .cash-flow-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .cash-action-card {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 66px;
            padding: 11px 16px;
            box-sizing: border-box;
            background: white;
            border: 1px solid #D0D5DD;
            border-radius: 11px;
            text-decoration: none;
            color: #101828;
            box-shadow: 0 4px 8px rgba(16, 24, 40, 0.12);
            transition: 0.15s ease;
        }

        .cash-action-card:hover {
            background: #F9FAFB;
            border-color: #7F9CF5;
        }

        .cash-action-card.active {
            background: #DCE6FF;
            border: 2px solid #2B6FFF;
        }

        .cash-action-card.disabled {
            cursor: not-allowed;
        }

        .cash-action-card.disabled:hover {
            background: white;
            border-color: #D0D5DD;
        }

        .cash-action-icon {
            width: 29px;
            height: 29px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 5px;
            background: #DCE6FF;
            color: #2B6FFF;
        }

        .cash-action-card.active .cash-action-icon {
            background: #2B6FFF;
            color: white;
        }

        .cash-action-icon svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
        }

        .cash-action-plus {
            font-size: 22px;
            font-weight: 500;
        }

        .cash-action-text {
            display: flex;
            flex-direction: column;
        }

        .cash-action-title {
            font-size: 13px;
            font-weight: 700;
        }

        .cash-action-subtitle {
            margin-top: 3px;
            font-size: 10px;
            color: #98A2B3;
        }


        /* ---------- Main Create Layout ---------- */

        .create-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(280px, 0.95fr);
            gap: 20px;
            align-items: stretch;
        }


        /* ---------- Card ---------- */

        .form-card,
        .preview-card {
            background: white;
            border: 1px solid #2B6FFF;
            border-radius: 14px;
            box-shadow: 0 5px 10px rgba(43, 111, 255, 0.28);
            overflow: hidden;
        }

        .card-header {
            padding: 14px 16px;
            border-bottom: 1px solid #D0D5DD;
            font-size: 14px;
            font-weight: 700;
            color: #101828;
        }


        /* ---------- Form Content ---------- */

        .form-content {
            padding: 18px 22px 16px;
        }


        /* ---------- Cash In / Cash Out ---------- */

        .transaction-type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            margin: 0 0 28px;
        }

        .transaction-type {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            min-height: 52px;
            padding: 8px 12px;
            background: white;
            border-radius: 11px;
            cursor: pointer;
            box-sizing: border-box;
            transition: 0.15s ease;
            text-align: left;
        }

        .transaction-type.cash-in {
            border: 2px solid #16A34A;
        }

        .transaction-type.cash-out {
            border: 2px solid #EF4444;
        }

        .transaction-type.cash-in.selected {
            background: #F0FDF4;
            box-shadow: 0 4px 7px rgba(22, 163, 74, 0.18);
        }

        .transaction-type.cash-out.selected {
            background: #FEF2F2;
            box-shadow: 0 4px 7px rgba(239, 68, 68, 0.18);
        }

        .type-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 4px;
            font-size: 20px;
            font-weight: 600;
        }

        .cash-in .type-icon {
            background: #BBF7D0;
            color: #16A34A;
        }

        .cash-out .type-icon {
            background: #FECACA;
            color: #EF4444;
        }

        .type-copy {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .type-title {
            font-size: 11px;
            font-weight: 700;
            color: #101828;
        }

        .type-subtitle {
            margin-top: 2px;
            font-size: 11px;
            color: #98A2B3;
        }


        /* ---------- Form Fields ---------- */

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .form-row {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 18px;

        }

        .form-label {

            margin-bottom: 4px;

            font-size: 11px;

            font-weight: 500;

            color: #344054;

        }

        .form-control {

            width: 100%;

            height: 34px;

            box-sizing: border-box;

            padding: 6px 9px;

            border: 1px solid #D0D5DD;

            border-radius: 4px;

            font-family: 'Inter', system-ui, sans-serif;

            font-size: 11px;

            color: #101828;

            background: white;

            outline: none;

        }

        .form-control:focus {

            border-color: #2B6FFF;

        }

        textarea.form-control {

            min-height: 72px;

            resize: vertical;

        }

        /* ---------- Other Category Field ---------- */

        #other-category-field {
            margin-top: 8px;
            margin-bottom: 10px;
        }

        #other-category-field .form-label {
            margin-bottom: 4px;
            font-size: 11px;
            font-weight: 500;
            color: #344054;
        }

        #other-category-field .form-control {
            width: 100%;
            height: 34px;
            box-sizing: border-box;
            padding: 6px 9px;
            border: 1px solid #D0D5DD;
            border-radius: 4px;
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 11px;
            color: #101828;
            background: white;
            outline: none;
        }

        #other-category-field .form-control:focus {
            border-color: #2B6FFF;
        }

        #other-category-field .error-message {
            margin-top: 4px;
            color: #D92D20;
            font-size: 10px;
        }

        .error-message {
            margin-top: 4px;
            color: #D92D20;
            font-size: 10px;
        }


        /* ---------- Amount Field ---------- */

        .amount-wrapper {
            position: relative;
        }

        .amount-prefix {
            position: absolute;
            left: 9px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: #667085;
            pointer-events: none;
        }

        .amount-wrapper input {
            padding-left: 28px;
        }


        /* ---------- Buttons ---------- */

        .form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            margin-top: 6px;
        }

        .cancel-link {
            border: none;
            background: none;
            color: #039BEF;
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 10px;
            text-decoration: none;
            cursor: pointer;
        }

        .create-button {

            min-width: 72px;

            height: 28px;

            padding: 0 16px;

            border: none;

            border-radius: 4px;

            background: #039BEF;

            color: white;

            font-family: 'Inter', system-ui, sans-serif;

            font-size: 10px;

            cursor: pointer;

        }

        .create-button:hover {

            background: #0287D0;

        }


        /* ---------- Live Preview ---------- */

        .preview-content {

            padding: 18px 20px;

        }

        .preview-summary {

            text-align: center;

            margin-bottom: 18px;

        }

        .preview-type {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding: 3px 9px;

            border-radius: 6px;

            font-size: 14px;

            margin-bottom: 8px;

        }

        .preview-type.cash-in {

            background: #BBF7D0;

            color: #15803D;

        }

        .preview-type.cash-out {

            background: #FECACA;

            color: #DC2626;

        }

        .preview-amount {

            font-size: 42px;

            font-weight: 600;

            line-height: 1.1;

        }

        .preview-amount.cash-in {

            color: #4ADE80;

        }

        .preview-amount.cash-out {

            color: #EF4444;

        }

        .preview-item {

            margin-bottom: 12px;

        }

        .preview-label {

            margin-bottom: 2px;

            font-size: 14px;

            font-weight: 500;

            color: #101828;

        }

        .preview-value {

            font-size: 12px;

            line-height: 1.45;

            color: #98A2B3;

            word-break: break-word;

        }


        /* ---------- Responsive ---------- */

        @media(max-width:900px) {

            .cash-flow-actions {

                grid-template-columns: 1fr;

            }

            .create-grid {

                grid-template-columns: 1fr;

            }

        }

        @media(max-width:650px) {

            .transaction-type-grid,
            .form-row {

                grid-template-columns: 1fr;

            }

        }
    </style>

</head>


<body>


    @include('admin.partials.admin-topbar')

    @include('admin.partials.admin-nav')


    <div class="stage">

        <div class="page">


            <h1 class="page-title">

                Record Transaction

            </h1>


            <!-- Top Action Cards -->

            <div class="cash-flow-actions">


                <!-- Record Transaction -->

                <a href="{{ route('admin.cash-flows.create') }}" class="cash-action-card active">

                    <div class="cash-action-icon cash-action-plus">

                        +

                    </div>

                    <div class="cash-action-text">

                        <span class="cash-action-title">

                            Record Transaction

                        </span>

                        <span class="cash-action-subtitle">

                            Log a new cash in/out entry

                        </span>

                    </div>

                </a>



                <!-- View All Transactions -->

                <a href="{{ route('admin.cash-flows.index') }}" class="cash-action-card">

                    <div class="cash-action-icon">

                        <svg viewBox="0 0 24 24">

                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"></path>

                            <circle cx="12" cy="12" r="3"></circle>

                        </svg>

                    </div>

                    <div class="cash-action-text">

                        <span class="cash-action-title">

                            View All Transactions

                        </span>

                        <span class="cash-action-subtitle">

                            Full list of every transaction made

                        </span>

                    </div>

                </a>



                <!-- Generate Report -->

                <a href="{{ route('admin.cash-flows.report') }}" class="cash-action-card">
                    <div class="cash-action-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>

                    </div>

                    <div class="cash-action-text">

                        <span class="cash-action-title">Generate Report</span>
                        <span class="cash-action-subtitle">Export as PDF or CSV</span>

                    </div>
                </a>


            </div>



            <!-- Main Content -->

            <div class="create-grid">


                <!-- Transaction Form -->

                <div class="form-card">


                    <div class="card-header">

                        Transaction Record Form

                    </div>


                    <form action="{{ route('admin.cash-flows.store') }}" method="POST" id="cash-flow-form">

                        @csrf


                        <div class="form-content">


                            <!-- Hidden Type -->

                            <input type="hidden" name="type" id="type" value="{{ old('type', 'Cash In') }}">



                            <!-- Cash In / Cash Out Selection -->

                            <div class="transaction-type-grid">


                                <button type="button" class="transaction-type cash-in" id="cash-in-button">

                                    <div class="type-icon">

                                        ↑

                                    </div>

                                    <div class="type-copy">

                                        <span class="type-title">

                                            Cash In

                                        </span>

                                        <span class="type-subtitle">

                                            Money Received

                                        </span>

                                    </div>

                                </button>



                                <button type="button" class="transaction-type cash-out" id="cash-out-button">

                                    <div class="type-icon">

                                        ↓

                                    </div>

                                    <div class="type-copy">

                                        <span class="type-title">

                                            Cash Out

                                        </span>

                                        <span class="type-subtitle">

                                            Money Paid Out

                                        </span>

                                    </div>

                                </button>


                            </div>


                            @error('type')
                                <div class="error-message">

                                    {{ $message }}

                                </div>
                            @enderror



                            <!-- Subject -->

                            <div class="form-group">

                                <label for="subject" class="form-label">

                                    Subject

                                </label>


                                <input type="text" name="subject" id="subject" class="form-control"
                                    value="{{ old('subject') }}" placeholder="Enter transaction subject..." required>


                                @error('subject')
                                    <div class="error-message">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>



                            <!-- Category + Date -->

                            <div class="form-row">


                                <div class="form-group">

                                    <label for="flowcategory_id" class="form-label">

                                        Category

                                    </label>


                                    <select name="flowcategory_id" id="flowcategory_id" class="form-control" required>

                                        <option value="">

                                            Select Category

                                        </option>


                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                data-type="{{ $category->cash_flow_type }}"
                                                data-name="{{ $category->category_name }}"
                                                {{ old('flowcategory_id') == $category->id ? 'selected' : '' }}>

                                                {{ $category->category_name }}

                                            </option>
                                        @endforeach

                                    </select>

                                    @error('flowcategory_id')
                                        <div class="error-message">

                                            {{ $message }}

                                        </div>
                                    @enderror

                                </div>



                                <div class="form-group">

                                    <label for="transaction_date" class="form-label">

                                        Date

                                    </label>


                                    <input type="date" name="transaction_date" id="transaction_date"
                                        class="form-control"
                                        value="{{ old('transaction_date', now()->format('Y-m-d')) }}"
                                        required>


                                    @error('transaction_date')
                                        <div class="error-message">

                                            {{ $message }}

                                        </div>
                                    @enderror

                                </div>


                            </div>

                            <div class="form-group" id="other-category-field" style="display:none;">

                                <label for="other_category" class="form-label">Specify Category</label>
                                <input type="text" name="other_category" id="other_category" class="form-control"
                                    value="{{ old('other_category') }}" maxlength="100">

                                @error('other_category')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror

                            </div>



                            <!-- Amount -->

                            <div class="form-group">

                                <label for="amount" class="form-label">

                                    Amount

                                </label>


                                <div class="amount-wrapper">

                                    <span class="amount-prefix">

                                        RM

                                    </span>


                                    <input type="number" name="amount" id="amount" class="form-control"
                                        value="{{ old('amount') }}" min="0.01" step="0.01"
                                        placeholder="0.00" required>

                                </div>


                                @error('amount')
                                    <div class="error-message">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>



                            <!-- Description -->

                            <div class="form-group">

                                <label for="description" class="form-label">

                                    Description

                                </label>


                                <textarea name="description" id="description" class="form-control" placeholder="Enter transaction description...">{{ old('description') }}</textarea>


                                @error('description')
                                    <div class="error-message">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>



                            <!-- Actions -->

                            <div class="form-actions">


                                <a href="{{ route('admin.cash-flows.index') }}" class="cancel-link">

                                    Cancel

                                </a>


                                <button type="submit" class="create-button">

                                    Create

                                </button>


                            </div>


                        </div>


                    </form>


                </div>



                <!-- Live Preview -->

                <div class="preview-card">


                    <div class="card-header">

                        Live Preview

                    </div>


                    <div class="preview-content">


                        <div class="preview-summary">


                            <div class="preview-type cash-in" id="preview-type">

                                ↑ Cash In

                            </div>


                            <div class="preview-amount cash-in" id="preview-amount">

                                RM0.00

                            </div>


                        </div>



                        <div class="preview-item">

                            <div class="preview-label">

                                Subject

                            </div>

                            <div class="preview-value" id="preview-subject">

                                No subject entered

                            </div>

                        </div>



                        <div class="preview-item">

                            <div class="preview-label">

                                Category

                            </div>

                            <div class="preview-value" id="preview-category">

                                No category selected

                            </div>

                        </div>



                        <div class="preview-item">

                            <div class="preview-label">

                                Date

                            </div>

                            <div class="preview-value" id="preview-date">

                                -

                            </div>

                        </div>



                        <div class="preview-item">

                            <div class="preview-label">

                                Description

                            </div>

                            <div class="preview-value" id="preview-description">

                                No description entered

                            </div>

                        </div>


                    </div>


                </div>


            </div>


        </div>

    </div>



    <script>
        const typeInput =
            document.getElementById('type');

        const cashInButton =
            document.getElementById('cash-in-button');

        const cashOutButton =
            document.getElementById('cash-out-button');

        const categorySelect =
            document.getElementById('flowcategory_id');

        const subjectInput =

            document.getElementById('subject');

        const dateInput =
            document.getElementById('transaction_date');

        const amountInput =
            document.getElementById('amount');

        const descriptionInput =
            document.getElementById('description');

        const previewType =
            document.getElementById('preview-type');

        const previewAmount =
            document.getElementById('preview-amount');

        const previewSubject =
            document.getElementById('preview-subject');

        const previewCategory =
            document.getElementById('preview-category');

        const previewDate =
            document.getElementById('preview-date');

        const previewDescription =
            document.getElementById('preview-description');

        const otherCategoryField =
            document.getElementById('other-category-field');

        const otherCategoryInput =
            document.getElementById('other_category');


        function setTransactionType(type) {

            typeInput.value = type;


            cashInButton.classList.toggle(
                'selected',
                type === 'Cash In'
            );


            cashOutButton.classList.toggle(
                'selected',
                type === 'Cash Out'
            );


            previewType.className =

                type === 'Cash In' ?
                'preview-type cash-in' :
                'preview-type cash-out';


            previewType.textContent =

                type === 'Cash In' ?
                '↑ Cash In' :
                '↓ Cash Out';


            previewAmount.className =

                type === 'Cash In' ?
                'preview-amount cash-in' :
                'preview-amount cash-out';


            updateCategoryOptions();

            toggleOtherCategoryField();

            updatePreview();

        }


        function updateCategoryOptions() {

            const selectedType =

                typeInput.value;


            Array.from(
                categorySelect.options
            ).forEach(function(option) {

                if (!option.value) {

                    option.hidden = false;

                    return;

                }


                option.hidden =

                    option.dataset.type !== selectedType;

            });


            const currentOption =

                categorySelect.options[
                    categorySelect.selectedIndex
                ];


            if (
                currentOption &&
                currentOption.value &&
                currentOption.dataset.type !== selectedType
            ) {

                categorySelect.value = '';

            }

        }


        function formatPreviewDate(value) {

            if (!value) {

                return '-';

            }


            const parts = value.split('-');


            if (parts.length !== 3) {

                return value;

            }


            return parts[2] +
                '/' +
                parts[1] +
                '/' +
                parts[0];

        }


        function updatePreview() {

            const amount =

                parseFloat(amountInput.value || 0);


            previewAmount.textContent =

                'RM' + amount.toFixed(2);



            previewSubject.textContent =

                subjectInput.value.trim() ||
                'No subject entered';



            const selectedCategory =
                categorySelect.options[
                    categorySelect.selectedIndex
                ];

            if (
                selectedCategory &&
                selectedCategory.value
            ) {
                const categoryName =
                    selectedCategory.dataset.name;

                const isOther =
                    categoryName === 'Other Income' ||
                    categoryName === 'Other Expense';

                if (
                    isOther &&
                    otherCategoryInput.value.trim()
                ) {
                    previewCategory.textContent =
                        categoryName +
                        ' — ' +
                        otherCategoryInput.value.trim();
                } else {
                    previewCategory.textContent =
                        categoryName;
                }
            } else {
                previewCategory.textContent =
                    'No category selected';
            }

        }


        cashInButton.addEventListener(
            'click',
            function() {

                setTransactionType('Cash In');

            }
        );


        cashOutButton.addEventListener(
            'click',
            function() {

                setTransactionType('Cash Out');

            }
        );


        subjectInput.addEventListener(
            'input',
            updatePreview
        );


        dateInput.addEventListener(
            'change',
            updatePreview
        );


        amountInput.addEventListener(
            'input',
            updatePreview
        );

        otherCategoryInput.addEventListener(
            'input',
            updatePreview
        );


        descriptionInput.addEventListener(
            'input',
            updatePreview
        );



        setTransactionType(
            typeInput.value || 'Cash In'
        );


        updatePreview();

        const cashFlowForm =
            document.getElementById('cash-flow-form');


        cashFlowForm.addEventListener(
            'submit',
            function(event) {
                const confirmed = confirm(
                    'Are you sure you want to create this transaction?'
                );


                if (!confirmed) {

                    event.preventDefault();

                }
            }
        );

        function toggleOtherCategoryField() {
            const selectedOption =
                categorySelect.options[
                    categorySelect.selectedIndex
                ];

            const categoryName =
                selectedOption ?
                selectedOption.dataset.name :
                '';

            const isOther =
                categoryName === 'Other Income' ||
                categoryName === 'Other Expense';


            otherCategoryField.style.display =
                isOther ? '' : 'none';


            otherCategoryInput.required =
                isOther;


            if (!isOther) {
                otherCategoryInput.value = '';
            }
        }


        categorySelect.addEventListener(
            'change',
            function() {
                toggleOtherCategoryField();
                updatePreview();
            }
        );


        toggleOtherCategoryField();
    </script>


</body>

</html>
