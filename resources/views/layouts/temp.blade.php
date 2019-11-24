<!DOCTYPE html>
<html lang="en">

<head>



    <title>امامزاده </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="{{asset('public/css/search1.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet">

</head>

<body style="background-color: #009688">
<div class="container">
<!-- Navigation -->
<nav class="navbar navbar-expand-lg  fixed-top" style="background-color: #00695c" >
    <div class="container" >
        @guest
            <li><a href="{{ route('login') }}">ورود</a></li>
            <li><a href="{{ route('register') }}">ثبت نام</a></li>
        @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                    </li>
                    <li>
                        <a href="{{ url('profile') }}/{{ Auth::user()->Uid }}">
                            profile
                        </a>

                    </li>
                </ul>
            </li>
        @endguest
        <a class="navbar-brand text-left" href="{!! url('/'); !!}">امامزاده </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-right" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{!! url('/search'); !!}">جستجو</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="{!! url('/'); !!}">صفحه اصلی</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{!! url('/imamzade/create'); !!}">اضافه کردن امامزاده</a>
                    </li>
                        @if( Auth::user()->access  == 1)
                            <li class="nav-item">
                            <a class="nav-link" href="{!! url('/manage'); !!}">مدیریت امامزادگان</a>
                             </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{!! url('/search'); !!}">جستجو</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{!! url('/'); !!}">صفحه اصلی</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->

    <!-- Heading Row -->

    @yield('content')




<!-- /.container -->

<!-- Footer -->
{{--<footer class="py-5 bg-dark">--}}
    {{--<div class="container">--}}
        {{--<p class="m-0 text-center text-white">Copyright &copy; imamzade 2018</p>--}}

    {{--</div>--}}
    {{--<!-- /.container -->--}}
{{--</footer>--}}

<!-- Bootstrap core JavaScript -->
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
</div>
</body>

</html>
