@extends('layouts.temp')
@section('content')
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body style="padding:0px; margin:0px; background-color:#fff;font-family:arial,helvetica,sans-serif,verdana,'Open Sans'">

<!-- #region Jssor Slider Begin -->
<!-- Generator: Jssor Slider Maker -->
<!-- Source: https://www.jssor.com -->


<table class="table table-striped text-right">
    <thead>
    <tr >
        <th scope="col">{{$user->UserName}}</th>
        <th scope="col">نام کاربری</th>


    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">{{$user->name}}</th>
        <td>نام</td>

    </tr>
    <tr>
        <th scope="row">{{$user->family}}</th>
        <td>نام خانوادگی</td>

    </tr>
    <tr>
        <th scope="row">{{$user->email}}</th>
        <td>پست الکترونیکی</td>

    </tr>
    </tbody>
</table>
<form method="get" action="{{url('changep')}}">
    <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            تغییر رمز عبور
        </button>
    </div>
</form>
<!-- #endregion Jssor Slider End -->
</body>
</html>


@endsection