@extends('layouts.temp')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="panel panel-default" style="direction:rtl;text-align:right;">
                    <div class="panel-heading"><h2>اصلاح امامزاده</h2></div>

                    <div class="panel-body" >
                        <form class="form-horizontal " method="POST" action="{{ route('imamzade.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('imamzade_Name') ? ' has-error' : '' }}">
                                <label for="imamzade_Name" class="col-md-4 control-label">نام امامزاده</label>

                                <div class="col-md-6">
                                    <input id="imamzade_Name" type="text" class="form-control" name="imamzade_Name" value="{{$imamzade->imamzade_Name }}" required autofocus>

                                    @if ($errors->has('imamzade_Name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('imamzade_Name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('Ancestor') ? ' has-error' : '' }}">
                                <label for="Ancestor" class="col-md-4 control-label">نسب</label>

                                <div class="col-md-6">
                                    <input id="Ancestor" type="text" class="form-control" name="Ancestor" value="{{ $imamzade->Ancestor }}" required autofocus>

                                    @if ($errors->has('Ancestor'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('Ancestor') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('Address') ? ' has-error' : '' }}">
                                <label for="Address" class="col-md-4 control-label">آدرس</label>

                                <div class="col-md-6">
                                    <input id="Address" type="text" class="form-control" name="Address" value="{{ $imamzade->Address }}" required autofocus>

                                    @if ($errors->has('Address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('Address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                                <label for="latitude" class="col-md-4 control-label">عرض جغرافیایی</label>

                                <div class="col-md-6">
                                    <input id="latitude" type="number" step="0.000001" class="form-control" name="latitude" value="{{$imamzade->latitude }}" required>

                                    @if ($errors->has('latitude'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                                <label for="longitude" class="col-md-4 control-label">طول جغرافیایی</label>

                                <div class="col-md-6">
                                    <input id="longitude" type="number" step="0.000001" class="form-control" name="longitude" value="{{ $imamzade->longitude }}" required>

                                    @if ($errors->has('longitude'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="selP">استان:</label>
                                <select class="form-control" id="selP" name="select_province">
                                    <option>{{$province[0]->province_Name}} </option>
                                    @foreach($result as $pr)
                                        <option value="{{$pr->province_Name}}">{{$pr->province_Name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="selC">شهر:</label>
                                <select class="form-control" id="selC" name="select_city" >
                                    <option >{{$city[0]->city_Name}}</option>
                                    {{--@if ($result[1]!=null)--}}
                                    {{--@foreach($result[1] as $ct)--}}
                                    {{--<option value="{{$ct->Name}}">{{$ct->Name}}</option>--}}
                                    {{--@endforeach--}}
                                    {{--@endif--}}

                                </select>
                            </div>

                            <input type='file' onchange="readURL(this);" name="input_img" id="input_img" />
                            <img id="blah" src="images/{{$image[0]->image}}" alt="عکس شما" />
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        ایجاد امامزاده
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $( "#selP" )
            .change(function() {
                var str = "";
                $( "select option:selected" ).each(function() {
                    str += $(this).text() + " ";



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
        function readURL(input) {
            for (i in input.files) {
                if (input.files && input.files[i]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah')
                            .attr('src', e.target.result)
                            .width(150)
                            .height(200);
                    };

                    reader.readAsDataURL(input.files[i]);
                }
            }
        }




        {{--$('#selP').change(function () {--}}
        {{--$value=$(this).text();--}}
        {{--$.ajax({--}}
        {{--type : 'post',--}}
        {{--url :'{{\Illuminate\Support\Facades\URL::to('imamzade/create')}}',--}}
        {{--data : {'province':$value},--}}
        {{--success:function (data) {--}}
        {{--console.log(data);--}}
        {{--}--}}
        {{--})--}}
        {{--})--}}

    </script>
@endsection
