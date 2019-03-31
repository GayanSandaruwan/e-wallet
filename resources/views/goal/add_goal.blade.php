@extends('layouts.mdb')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Goal</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('addGoal') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="goal_name" class="col-md-4 col-form-label text-md-right">Goal Name</label>

                                <div class="col-md-6">
                                    <input id="goal_name" type="text" class="form-control{{ $errors->has('goal_name') ? ' is-invalid' : '' }}" name="goal_name" value="{{ old('goal_name') }}" required autofocus>

                                    @if ($errors->has('goal_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('goal_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="target_value" class="col-md-4 col-form-label text-md-right">Target value</label>

                                <div class="col-md-6">
                                    <input id="target_value" type="number" step="0.01" class="form-control{{ $errors->has('target_value') ? ' is-invalid' : '' }}" name="target_value" value="{{ old('target_value') }}" required autofocus>

                                    @if ($errors->has('target_value'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('target_value') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="account_id" class="col-md-4 col-form-label text-md-right">Target Account</label>

                                <div class="col-md-6">
                                    <select class="browser-default custom-select form-control{{ $errors->has('account_id') ? ' is-invalid' : '' }}" name="account_id" required autofocus>
                                        <option selected>Select the Account for the goal</option>
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
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-arrows-alt"></i> Add Goal
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if (!empty($goal))
                            <div class="col-md-6">

                                <span class="valid-feedback" style="display: inline-block">
                                        Goal <strong>{{ $goal->goal_name }}</strong> has successfully created
                                    </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
