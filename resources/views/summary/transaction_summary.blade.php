@extends('layouts.mdb')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Summary</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('transactionSummary') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="account_id" class="col-md-4 col-form-label text-md-right">Target Account</label>

                                <div class="col-md-6">
                                    <select class="browser-default custom-select form-control{{ $errors->has('account_id') ? ' is-invalid' : '' }}" name="account_id" required autofocus>
                                        <option selected>Select Account</option>
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
                                <label for="start_month" class="col-md-4 col-form-label text-md-right">Starting Month</label>

                                <div class="col-md-6">
                                    <input id="start_month" type="text" class="date-picker form-control{{ $errors->has('start_month') ? ' is-invalid' : '' }}" name="start_month" value="{{ old('start_month') }}" required autofocus>
                                    @if ($errors->has('start_month'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('start_month') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="end_month" class="col-md-4 col-form-label text-md-right">Ending Month</label>

                                <div class="col-md-6">
                                    <input id="end_month" type="text" class="date-picker form-control{{ $errors->has('end_month') ? ' is-invalid' : '' }}" name="end_month" value="{{ old('end_month') }}" required autofocus>
                                    @if ($errors->has('end_month'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('end_month') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-recycle"></i> Generate Report
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($balances))
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">Summary of "{{$summary_account->account_name}}" &nbsp; &nbsp;
                        Current Balance : "{{$summary_account->balance}}" &nbsp; Available Balance : "{{$available_balance}}"</div>
                    <div class="card-body">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('body-js')
    <script type="text/javascript">

        {{-- Data Picker Initialization--}}
    $('#start_month').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"

        });

    $('#end_month').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        });

    @if(!empty($balances))
        {{--line chart--}}
            console.log(@json($labels));
        var ctxL = document.getElementById("lineChart").getContext('2d');
        var myLineChart = new Chart(ctxL, {
        type: 'line',
        data: {
        labels: @json($labels),
        datasets: [{
        label: "Expenses",
        data: @json($expenses),
        backgroundColor: [
        'rgba(105, 0, 132, .2)',
        ],
        borderColor: [
        'rgba(200, 99, 132, .7)',
        ],
        borderWidth: 2
        },
        {
        label: "Incomes",
        data: @json($incomes),
        backgroundColor: [
        'rgba(0, 137, 0, .2)',
        ],
        borderColor: [
        'rgba(0, 137, 0, .7)',
        ],
        borderWidth: 2
        },
            {
                label: "Balance Progress",
                data: @json($balances),
                backgroundColor: [
                    'rgba(0, 137, 132, .2)',
                ],
                borderColor: [
                    'rgba(0, 10, 130, .7)',
                ],
                borderWidth: 2
            }
        ]
        },
        options: {
        responsive: true
        }
        });
        @endif
    </script>
@endsection
