<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Update Transaction Record</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        body {

            margin: 0;

            display: flex;

            flex-direction: column;

            font-family: 'Inter', system-ui, sans-serif;

            color: black;

            min-height: 100vh;

        }


        /* ---------- Page ---------- */

        .page {

            width: 90%;

            max-width: 1400px;

            margin: 0 auto;

            padding: 10px 24px 64px;

            box-sizing: border-box;

        }


        /* ---------- Breadcrumb ---------- */

        .breadcrumb {

            margin-bottom: 8px;

            font-size: 10px;

            font-weight: 600;

            color: #344054;

        }

        .breadcrumb span {

            color: #98A2B3;

        }


        /* ---------- Heading ---------- */

        .page-title {

            margin: 0;

            font-size: 34px;

            font-weight: 800;

            color: #101828;

        }

        .page-subtitle {

            margin-top: 8px;

            margin-left: 10px;

            font-size: 10px;

            color: #98A2B3;

        }


        /* ---------- Form Card ---------- */

        .form-card {

            margin-top: 18px;

            background: white;

            border: 1px solid #2B6FFF;

            border-radius: 14px;

            box-shadow: 0 5px 10px rgba(43, 111, 255, 0.28);

            overflow: hidden;

        }

        .form-card-header {

            padding: 16px 18px;

            border-bottom: 1px solid #D0D5DD;

            font-size: 17px;

            font-weight: 700;

            color: #101828;

        }

        .form-card-body {

            padding: 22px 24px 12px;

        }


        /* ---------- Form ---------- */

        .form-group {

            display: flex;

            flex-direction: column;

            margin-bottom: 12px;

        }

        .form-row {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 60px;

        }

        .form-label {

            margin-bottom: 4px;

            font-size: 13px;

            font-weight: 500;

            color: #101828;

        }

        .form-control {

            width: 100%;

            height: 31px;

            padding: 5px 12px;

            box-sizing: border-box;

            border: 1px solid #D0D5DD;

            border-radius: 4px;

            outline: none;

            background: white;

            font-family: 'Inter', system-ui, sans-serif;

            font-size: 11px;

            color: #101828;

        }

        .form-control:focus {

            border-color: #2B6FFF;

        }

        .form-control[readonly] {

            background: #D9D9D9;

            color: #475467;

        }

        textarea.form-control {

            min-height: 60px;

            resize: vertical;

        }


        /* ---------- Amount ---------- */

        .amount-wrapper {

            position: relative;

        }

        .amount-prefix {

            position: absolute;

            left: 18px;

            top: 50%;

            transform: translateY(-50%);

            font-size: 11px;

            color: #667085;

            pointer-events: none;

        }

        .amount-wrapper input {

            padding-left: 45px;

        }


        /* ---------- Error ---------- */

        .error-message {

            margin-top: 4px;

            color: #D92D20;

            font-size: 10px;

        }


        /* ---------- Actions ---------- */

        .form-actions {

            display: flex;

            justify-content: flex-end;

            align-items: center;

            gap: 12px;

            margin-top: 18px;

        }

        .cancel-link {

            font-size: 10px;

            color: #039BEF;

            text-decoration: none;

        }

        .save-button {

            min-width: 126px;

            height: 28px;

            border: none;

            border-radius: 5px;

            background: #039BEF;

            color: white;

            font-family: 'Inter', system-ui, sans-serif;

            font-size: 10px;

            cursor: pointer;

        }

        .save-button:hover {

            background: #0287D0;

        }


        /* ---------- Responsive ---------- */

        @media(max-width:800px) {

            .form-row {

                grid-template-columns: 1fr;

                gap: 0;

            }

            .page-title {

                font-size: 27px;

            }

        }
    </style>

</head>

<body>


    @include('admin.partials.admin-topbar')

    @include('admin.partials.admin-nav')


    <div class="stage">

        <div class="page">


            <!-- Breadcrumb -->

            <div class="breadcrumb">

                Cash Flow Transaction

                <span>
                    >
                </span>

                {{ $cashFlow->transaction_code }}

            </div>


            <!-- Heading -->

            <h1 class="page-title">

                Update Transaction Record

            </h1>


            <div class="page-subtitle">

                {{ $cashFlow->subject }}

                —

                last updated

                {{ $cashFlow->updated_at ? $cashFlow->updated_at->format('j F Y') : '-' }}

            </div>



            <!-- Form Card -->

            <div class="form-card">


                <div class="form-card-header">

                    Transaction Record Form

                </div>


                <div class="form-card-body">


                    <form action="{{ route('admin.cash-flows.update', $cashFlow) }}" method="POST"
                        id="cash-flow-edit-form">

                        @csrf

                        @method('PUT')



                        <!-- Transaction ID -->

                        <div class="form-group">

                            <label for="transaction_code" class="form-label">

                                Transaction ID

                            </label>


                            <input type="text" id="transaction_code" class="form-control"
                                value="{{ $cashFlow->transaction_code }}" readonly>

                        </div>



                        <!-- Subject -->

                        <div class="form-group">

                            <label for="subject" class="form-label">

                                Subject

                            </label>


                            <input type="text" name="subject" id="subject" class="form-control"
                                value="{{ old('subject', $cashFlow->subject) }}"
                                placeholder="Enter transaction subject..." required>


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
                                        <option value="{{ $category->id }}" data-name="{{ $category->category_name }}"
                                            data-type="{{ $category->cash_flow_type }}"
                                            {{ old('flowcategory_id', $cashFlow->flowcategory_id) == $category->id ? 'selected' : '' }}>

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


                                <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                                    value="{{ old('transaction_date', $cashFlow->transaction_date ? $cashFlow->transaction_date->format('Y-m-d') : '') }}"
                                    required>


                                @error('transaction_date')
                                    <div class="error-message">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>


                        </div>

                        <div class="form-group" id="other-category-field" style="display:none;">
                            <label for="other_category" class="form-label">
                                Specify Category
                            </label>

                            <input type="text" name="other_category" id="other_category" class="form-control"
                                value="{{ old('other_category', $cashFlow->other_category) }}" maxlength="100">

                            @error('other_category')
                                <div class="error-message">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        <!-- Amount + Type -->

                        <div class="form-row">


                            <div class="form-group">

                                <label for="amount" class="form-label">

                                    Amount

                                </label>


                                <div class="amount-wrapper">

                                    <span class="amount-prefix">

                                        RM

                                    </span>


                                    <input type="number" name="amount" id="amount" class="form-control"
                                        value="{{ old('amount', $cashFlow->amount) }}" min="0.01" step="0.01"
                                        required>

                                </div>


                                @error('amount')
                                    <div class="error-message">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>



                            <div class="form-group">

                                <label for="type" class="form-label">

                                    Type

                                </label>


                                <select name="type" id="type" class="form-control" required>

                                    <option value="Cash In"
                                        {{ old('type', $cashFlow->type) === 'Cash In' ? 'selected' : '' }}>

                                        Cash In

                                    </option>


                                    <option value="Cash Out"
                                        {{ old('type', $cashFlow->type) === 'Cash Out' ? 'selected' : '' }}>

                                        Cash Out

                                    </option>

                                </select>


                                @error('type')
                                    <div class="error-message">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>


                        </div>



                        <!-- Description -->

                        <div class="form-group">

                            <label for="description" class="form-label">

                                Description

                            </label>


                            <textarea name="description" id="description" class="form-control">{{ old('description', $cashFlow->description) }}</textarea>


                            @error('description')
                                <div class="error-message">

                                    {{ $message }}

                                </div>
                            @enderror

                        </div>



                        <!-- Actions -->

                        <div class="form-actions">


                            <a href="{{ route('admin.cash-flows.show', $cashFlow) }}" class="cancel-link">

                                Cancel

                            </a>


                            <button type="submit" class="save-button">

                                Save changes

                            </button>


                        </div>


                    </form>


                </div>


            </div>


        </div>

    </div>


    <script>
        const typeSelect =
            document.getElementById('type');

        const categorySelect =
            document.getElementById('flowcategory_id');

        const otherCategoryField =
            document.getElementById('other-category-field');

        const otherCategoryInput =
            document.getElementById('other_category');



        function updateCategoryOptions() {

            const selectedType =

                typeSelect.value;


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



            const selectedOption =

                categorySelect.options[
                    categorySelect.selectedIndex
                ];


            if (
                selectedOption &&
                selectedOption.value &&
                selectedOption.dataset.type !== selectedType
            ) {

                categorySelect.value = '';

            }

        }



        typeSelect.addEventListener(
            'change',
            updateCategoryOptions
        );


        updateCategoryOptions();



        const editForm =

            document.getElementById('cash-flow-edit-form');


        editForm.addEventListener(
            'submit',
            function(event) {

                const confirmed = confirm(
                    'Are you sure you want to save these changes?'
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
            }
        );


        toggleOtherCategoryField();
    </script>


</body>

</html>
