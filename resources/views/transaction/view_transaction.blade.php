@extends('layouts.mdb')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header" align="center">View Income/Expense</div>

                    <div class="card-body">
                        {{--<div class="col-md-12">--}}
                            <table id="transactionTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Trans Desc</th>
                                    <th>Income/Exp</th>
                                    <th> Effective Date</th>
                                    <th>Amount</th>
                                    <th>Account Name</th>
                                    <th>Edit Transaction</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTransaction" tabindex="-1" role="dialog" aria-labelledby="editTransaction"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{--<h5 class="modal-title" id="editTransactionLabel">Edit Transaction</h5>--}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">Add Income/Expense</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('editTransaction') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="account_name" class="col-md-4 col-form-label text-md-right">Target Account</label>
                                    <div class="col-md-6">
                                        <input id="account_name" type="text" class="form-control" disabled>
                                        <input id="account_id" name="account_id" type="text" class="form-control" hidden>
                                        <input id="transaction_id" name="transaction_id" type="text" class="form-control" hidden>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="type" class="col-md-4 col-form-label text-md-center">Income/Expense</label>

                                    <div class="col-md-6">
                                        <select class="browser-default custom-select form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" id="type"required autofocus>
                                            <option selected>Select Transaction Type</option>
                                            <option value="income">Income</option>
                                            <option value="expense">expense</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="trans_desc" class="col-md-4 col-form-label text-md-right">Description</label>

                                    <div class="col-md-6">
                                        <input id="trans_desc" type="text" class="form-control{{ $errors->has('trans_desc') ? ' is-invalid' : '' }}" name="trans_desc" value="{{ old('trans_desc') }}" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="effective_date" class="col-md-4 col-form-label text-md-right">Effective Date</label>

                                    <div class="col-md-6">
                                        <input id="effective_date" type="text" class="date-picker form-control{{ $errors->has('effective_date') ? ' is-invalid' : '' }}" name="effective_date" value="{{ old('effective_date') }}" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">Income/Expense Value</label>

                                    <div class="col-md-6">
                                        <input id="amount" type="number" step="0.01" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-exchange-alt"></i> Save Changes</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteTransaction" tabindex="-1" role="dialog" aria-labelledby="deleteTransaction"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{--<h5 class="modal-title" id="editTransactionLabel">Edit Transaction</h5>--}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">Delete Income/Expense</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('deleteTransaction') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="account_name" class="col-md-4 col-form-label text-md-right">Target Account</label>
                                    <div class="col-md-6">
                                        <input id="del_account_name" type="text" class="form-control" disabled>
                                        <input id="del_account_id" name="account_id" type="text" class="form-control" hidden>
                                        <input id="del_transaction_id" name="transaction_id" type="text" class="form-control" hidden>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="type" class="col-md-4 col-form-label text-md-center">Income/Expense</label>

                                    <div class="col-md-6">
                                        <select class="browser-default custom-select form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" id="del_type" disabled autofocus>
                                            <option selected>Select Transaction Type</option>
                                            <option value="income">Income</option>
                                            <option value="expense">expense</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="trans_desc" class="col-md-4 col-form-label text-md-right">Description</label>

                                    <div class="col-md-6">
                                        <input id="del_trans_desc" type="text" class="form-control{{ $errors->has('trans_desc') ? ' is-invalid' : '' }}" name="trans_desc" value="{{ old('trans_desc') }}" disabled autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="effective_date" class="col-md-4 col-form-label text-md-right">Effective Date</label>

                                    <div class="col-md-6">
                                        <input id="del_effective_date" type="text" class="date-picker form-control{{ $errors->has('effective_date') ? ' is-invalid' : '' }}" name="effective_date" value="{{ old('effective_date') }}" disabled autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">Income/Expense Value</label>

                                    <div class="col-md-6">
                                        <input id="del_amount" type="number" step="0.01" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" disabled autofocus>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-exchange-alt"></i> Confirm Deletion</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('body-js')

    <script type="text/javascript">

        var transactions = @json($transactions);
        var thisDocument = this;

        function showTable() {
            console.log(transactions);

            dataTable = $('#transactionTable').DataTable(
                {
                    data: transactions,
                    columns: [
                        // {data : "conversionId"},
                        {data: "trans_desc"},
                        {data: "type"},
                        {data: "effective_date"},
                        {data: "amount"},
                        {data: "account_name"},

                        // {data: "outputFileName"},
                        // {data: "inputFilePath"},
                        // {data: "outputFilePath"},
                        {
                            data: "transaction_id" , render : function ( data, type, row, meta ) {
                                return type === 'display'  ?
                                    '<div class=row>'
                                    +'<div class="col">'
                                    +'<button class="btn btn-info btn-rounded" onclick="thisDocument.editTransaction(this.id)" id="'+ data +'" ><i class="far fa-edit"></i></button>'
                                    +'</div>'
                                    +'<div class="col">'
                                    +'<button class="btn btn-danger btn-rounded" onclick="thisDocument.deleteTransaction(this.id)" id="'+ data +'" ><i class="fas fa-trash-alt"></i></button>'
                                    +'</div>'
                                    +'</div>'
                                    :
                                    data;
                            }
                        },

                    ],
                }
            );

        }

        function editTransaction(transactionId) {
            console.log(transactionId);
            $('#editTransaction').modal('show')
            var result = transactions.filter(obj => {
                return obj.transaction_id == transactionId
            })
            console.log(result[0]);
            var transaction = result[0];
            $('#account_name').val(transaction["account_name"]);
            $('#trans_desc').val(transaction["trans_desc"]);
            $('#effective_date').val(transaction["effective_date"]);
            $('#amount').val(transaction["amount"]);
            $('#type').val(transaction["type"]);
            $('#account_id').val(transaction["account_id"]);
            $('#transaction_id').val(transaction["transaction_id"]);

        }

        function deleteTransaction(transactionId) {
            console.log(transactionId);
            $('#deleteTransaction').modal('show')
            var result = transactions.filter(obj => {
                return obj.transaction_id == transactionId
            })
            console.log(result[0]);
            var transaction = result[0];

            $('#del_account_name').val(transaction["account_name"]);
            $('#del_trans_desc').val(transaction["trans_desc"]);
            $('#del_effective_date').val(transaction["effective_date"]);
            $('#del_amount').val(transaction["amount"]);
            $('#del_type').val(transaction["type"]);
            $('#del_account_id').val(transaction["account_id"]);
            $('#del_transaction_id').val(transaction["transaction_id"]);

        }


        $(document).ready(
            function () {
                showTable();

            }
        );
    </script>
@endsection
