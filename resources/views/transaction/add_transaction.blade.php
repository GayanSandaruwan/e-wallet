@extends('layouts.mdb')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Income/Expense</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('addTransaction') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="account_id" class="col-md-4 col-form-label text-md-right">Target Account</label>

                                <div class="col-md-6">
                                    <select class="browser-default custom-select form-control{{ $errors->has('account_id') ? ' is-invalid' : '' }}" name="account_id" required autofocus>
                                        <option selected>Select the Account for Transaction</option>
                                        @foreach($accounts as $account)
                                            <option value="{{$account->id}}">{{$account->account_name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('account_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">Income/Expense</label>

                                <div class="col-md-6">
                                    <select class="browser-default custom-select form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" required autofocus>
                                        <option selected>Select Transaction Type</option>
                                        <option value="income">Income</option>
                                        <option value="expense">expense</option>
                                    </select>

                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="trans_desc" class="col-md-4 col-form-label text-md-right">Description</label>

                                <div class="col-md-6">
                                    <input id="trans_desc" type="text" class="form-control{{ $errors->has('trans_desc') ? ' is-invalid' : '' }}" name="trans_desc" value="{{ old('trans_desc') }}" required autofocus>

                                    @if ($errors->has('trans_desc'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('trans_desc') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="effective_date" class="col-md-4 col-form-label text-md-right">Effective Date</label>

                                <div class="col-md-6">
                                    <input id="effective_date" type="text" class="date-picker form-control{{ $errors->has('effective_date') ? ' is-invalid' : '' }}" name="effective_date" value="{{ old('effective_date') }}" required autofocus>
                                    @if ($errors->has('effective_date'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('effective_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">Income/Expense Value</label>

                                <div class="col-md-6">
                                    <input id="amount" type="number" step="0.01" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" required autofocus>

                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-exchange-alt"></i> Add Transaction
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if (!empty($transaction))
                            <div class="col-md-6">

                                <span class="valid-feedback" style="display: inline-block">
                                        Transaction <strong>{{ $transaction->trans_desc }}</strong> with amount <strong>{{ $transaction->amount }}</strong> has successfully created
                                    </span>
                            </div>
                        @endif
                        @if (!empty($updated_account))
                            <div class="col-md-6">

                                <span class="valid-feedback" style="display: inline-block">
                                        Current balance of Account <strong>{{ $updated_account->account_name }}</strong> is  <strong>{{ $updated_account->balance }}</strong> has successfully updated
                                    </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body-js')
    <style>
        .bg {
            /* The image used */
            background-image: url("{{asset('/mdb/img/background/add income.jpg')}}");

        }
    </style>

    <script type="text/javascript">

        {{-- Data Picker Initialization--}}
    $('#effective_date').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            format: "yyyy-mm-dd",
    });
    </script>
    @endsection
