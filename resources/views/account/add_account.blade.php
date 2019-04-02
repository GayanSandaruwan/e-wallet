@extends('layouts.mdb')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Account</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('addAccount') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="account_name" class="col-md-4 col-form-label text-md-right">Account Name</label>

                                <div class="col-md-6">
                                    <input id="account_name" type="text" class="form-control{{ $errors->has('account_name') ? ' is-invalid' : '' }}" name="account_name" value="{{ old('account_name') }}" required autofocus>

                                    @if ($errors->has('account_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="account_desc" class="col-md-4 col-form-label text-md-right">Account Description</label>

                                <div class="col-md-6">
                                    <input id="account_desc" type="textarea" class="form-control{{ $errors->has('account_desc') ? ' is-invalid' : '' }}" name="account_desc" value="{{ old('account_desc') }}" required autofocus>

                                    @if ($errors->has('account_desc'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account_desc') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-business-time"></i> Add Account
                                    </button>
                                </div>
                            </div>
                        </form>
                            @if (!empty($account))
                            <div class="col-md-6">

                                <span class="valid-feedback" style="display: inline-block">
                                        Account <strong>{{ $account->account_name }}</strong> has successfully created
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
            background-image: url("{{asset('/mdb/img/background/add account.jpg')}}");

        }
    </style>

    @endsection
