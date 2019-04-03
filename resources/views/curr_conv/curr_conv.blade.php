@extends('layouts.mdb')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Convert Currency</div>

                    <div class="card-body">
                        <div class="jumbotron">
                            <div class="container">
                                <h2>Currency Calculator</h2>
                                <p class="lead">Convert the currency</p>
                                <form class="form-inline">
                                    <div class="form-group mb-2">
                                        <input type="number" class="form-control" id="amount"/>
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <select class="form-control" id="currency-1" required>
                                            <option>PLN</option>
                                            <option>EUR</option>
                                            <option>USD</option>
                                            <option>LKR</option>
                                        </select>
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label>convert to</label>
                                        <select class="form-control" id="currency-2" required>
                                            <option>EUR</option>
                                            <option>USD</option>
                                            <option>PLN</option>
                                            <option>LKR</option>
                                        </select>
                                    </div>
                                    <button class="btn calculate-btn btn-primary mb-2">Show me the result!</button>
                                </form>
                                <div class="result">
                                    <p>
                                        <span class="given-amount"></span>
                                        <span class="base-currency"></span>
                                        <span class="final-result"></span>
                                        <span class="second-currency"></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('body-js')

    <script>
        var crrncy = {'EUR': {'PLN': 4.15, 'USD': 0.83, 'LKR': 196.42}, 'USD': {'PLN': 3.45, 'EUR': 1.2, 'LKR': 174.71}}
        var btn = document.querySelector('.calculate-btn');
        var baseCurrencyInput = document.getElementById('currency-1');
        var secondCurrencyInput = document.getElementById('currency-2');
        var amountInput = document.getElementById('amount');
        var toShowAmount = document.querySelector('.given-amount');
        var toShowBase = document.querySelector('.base-currency');
        var toShowSecond = document.querySelector('.second-currency');
        var toShowResult = document.querySelector('.final-result');

        function convertCurrency(event) {
            event.preventDefault();
            var amount = amountInput.value;
            var from = baseCurrencyInput.value;
            var to = secondCurrencyInput.value;
            var result = 0;

            try{
                if (from == to){
                    result = amount;
                } else {
                    result = amount * crrncy[from][to];
                }
            }
            catch(err) {
                result = amount * (1 / crrncy[to][from]);
            }

            toShowAmount.innerHTML = amount;
            toShowBase.textContent = from + ' = ';
            toShowSecond.textContent = to;
            toShowResult.textContent = result;
        }

        btn.addEventListener('click', convertCurrency);


    </script>
@endsection
