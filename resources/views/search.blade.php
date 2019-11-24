
{{--/**--}}
{{--* Created by PhpStorm.--}}
{{--* User: mahdi--}}
{{--* Date: 5/8/2018--}}
{{--* Time: 12:11 PM--}}
{{--*/--}}
@extends('layouts.temp')

@section('content')
    <style>
        body {

            padding-top: 50px;
        }
        .dropdown.dropdown-lg .dropdown-menu {
            margin-top: -1px;
            padding: 4px 15px;
        }

        .btn-group .btn {
            border-radius: 0;
            margin-left: -1px;
        }
        .form-horizontal .form-group {

            margin-left: 0;
            margin-right: 0;
        }


        @media screen and (min-width: 768px) {
            #boot-search-box {
                width: 500px;
                margin: 0 auto;
            }
            .dropdown.dropdown-lg {
                position: static !important;
            }
            .dropdown.dropdown-lg .dropdown-menu {
                min-width: 500px;
            }



        }
    </style>
    <div class="container">
        <br/><br/>
        <div class="row">
            <div class="col-md-12">

                <form class="form-horizontal" role="form" method="POST" action="{{ 'searchroute' }}">
                    <div class="input-group" id="boot-search-box">


                        <input type="text" name="input" class="form-control" placeholder="جستجو در امامزادگان" />

                        <div class="input-group-btn">
                            <div class="btn-group" role="group">

                                <div class="dropdown dropdown-lg">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret">جستجو پیشرفته</span></button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">


                                        <div class="form-group">
                                            <label for="selP">استان:</label>
                                            <select class="form-control" id="selP" name="select_province">
                                                <option ></option>
                                                @foreach($province as $pr)
                                                    <option value="{{$pr->Pid}}">{{$pr->province_Name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="selC">شهر:</label>
                                            <select class="form-control" id="selC" name="select_city">
                                                <option ></option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="ca">دسته بندی:</label>
                                            <select class="form-control" id="ca" name="category">
                                                <option ></option>
                                                <option value="1" >نام امامزاده</option>
                                                {{--<option value="2">زیارتنامه</option>--}}
                                                <option value="2">نسب</option>

                                            </select>
                                        </div>


                                        <button  id="psearch" type="submit" name="action" value="psearch" class="btn btn-primary btn-block">Search :: <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>

                                    </div>
                                </div>
                                <button id="search" type="submit" name="action" value="search" class="btn btn-success "><span class="glyphicon glyphicon-search" aria-hidden="true">جستجو</span></button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <br/><br/>
        <div class="row" id="row" style="display: {{(empty($result)|| json_encode($result) == [])? 'none' : true}}">
            <div class="col-xs-12 ">
                <nav >
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-map" role="tab" aria-controls="nav-home" aria-selected="true">نمایش نتایج بر روی نقشه</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-list" role="tab" aria-controls="nav-profile" aria-selected="false">نمایش نتایج به صورت لیست</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-list" role="tab" aria-controls="nav-profile" aria-selected="false">نمایش نتایج به صورت لیست</a>

                    </div>
                </nav>
                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-map" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="i123456789">s</div>
                    </div>
                    <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-profile-tab">

                    </div>

                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('.form-group').bind('click', function (e) { e.stopPropagation() });
        $( "#selP" )
            .change(function() {
                var str = "";
                $( "select option:selected" ).each(function() {
                    str += $(this).text() + " ";

                    if (str ){

                        $('#selC').html("<option ></option>");
                    }


                    $.ajax({
                        type: 'get',
                        url: '{{url('imamzade/creates')}}',
                        data: {'province': str},
                        success: function (data) {

                            $('#selC').html(data);

                        }
                    });

                });

            });

        $('#search,#psearch').bind("click", function(){
            var result ={!! json_encode($result) !!}

            $.ajax({
                type: 'POST',
                url: '{{url('cmap')}}',
                data: {'mapArrays': result,_token: '{{csrf_token()}}'},
                success: function (data) {

                    $('.i123456789').append(data);
                }
            });

        });
    </script>
@endsection