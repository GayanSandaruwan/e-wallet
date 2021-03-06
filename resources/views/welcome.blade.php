<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        {{--Mdb bootstrap styles--}}
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <!-- Bootstrap core CSS -->
        <link href="{{asset('mdb/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="{{asset('mdb/css/mdb.min.css')}}" rel="stylesheet">
        <!-- Your custom styles (optional) -->
        <link href="{{asset('mdb/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('mdb/css/addons/bootstrap-datepicker.css')}}" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .icon-size{
                .fa-2x
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            @media only screen and (min-width: 768px) {
                .icon-size{
                    .fa-4x
                }
                .title {
                    font-size: 84px;
                }
            }
            .bg {
                /* The image used */
                /* Half height */
                height: 90%;
                background-image: url("{{asset('/mdb/img/background/home.jpg')}}");
                /* Center and scale the image nicely */
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height bg">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md animated bounceOutRight infinite slower delay-3s">
                    <span><i class="fab icon-size fa-google-wallet"></i></span>
                </div>
                <div class="title m-b-md">
                    Welcome to E-Wallet
                </div>
                @auth
                    <div class="links animated pulse infinite fast">
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="{{url('/about')}}">About Us</a>
                    </div>
                @else
                    <div class="links animated pulse infinite fast">
                        <a href="{{route('login')}}">Login</a>
                        <a href="{{route('register')}}">Register</a>
                        <a href="{{url('/about')}}">About Us</a>

                    </div>
                @endauth

            </div>
        </div>
        <script type="text/javascript" src="{{asset('mdb/js/jquery-3.3.1.min.js')}}"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="{{asset('mdb/js/popper.min.js')}}"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="{{asset('mdb/js/bootstrap.min.js')}}"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="{{asset('mdb/js/mdb.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('mdb/js/addons/datatables.js')}}"></script>
        <script type="text/javascript" src="{{asset('mdb/js/addons/bootstrap-datepicker.js')}}"></script>
        <footer class="page-footer font-small aqua-gradient">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2019 Copyright:
                <a href="https://mdbootstrap.com/education/bootstrap/"> ewalletlk.herokuapp.com</a>
            </div>
            <!-- Copyright -->

        </footer>
    </body>
</html>
