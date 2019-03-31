@extends('layouts.mdb')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach($goals as $goal)
                <div class="col-md-4">
                    <div class="card">

                        <!-- Card image -->
                        <div class="title m-b-md animated rotateOut infinite slower delay-3s" align="center" style="padding-top: 2%">
                            <span><i class="fas fa-6x fa-spinner"></i></span>
                        </div>
                        <!-- Card content -->
                        <div class="card-body">

                            <!-- Title -->
                            <h4 class="card-title"><a>{{$goal->goal_name}}</a></h4>
                            <!-- Text -->
                            <p class="card-text">Goal set for account <strong>{{$goal->account["account_name"]}}</strong> has not achieved its target value of <strong>{{$goal->target_value}} </strong><br/>
                                Created Date : {{$goal->created_at}} <br/>
                                Updated Date : {{$goal->updated_at}} <br/>
                                Current balance of target_account : {{$goal->account["balance"]}}
                            </p>
                            <!-- Button -->
                            <a href="#" class="btn btn-primary"><i class="fas fa-check-double"></i> Mark as Completed</a>

                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
