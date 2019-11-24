@extends('layouts.temp')

@section('content')
        <!DOCTYPE html>





<html>

<body>

<!-- Main  -->
<div id="main" style="opacity: 1;">

    <!-- wrapper -->
    <div id="wrapper no-padding">
        <div class="content">
            <!-- Map -->
            <div class="map-container column-map right-pos-map" style="height: 700px;">
                <div id="mapdiv" style="height: 600px; width: 100%; "></div>
                <script src="http://www.openlayers.org/api/OpenLayers.js"></script>
            </div>
            <!-- Map end -->
            <!--col-list-wrap -->
            <div class="col-list-wrap left-list">

                <!-- list-main-wrap-->
                <div class="list-main-wrap fl-wrap card-listing">

                    <div class="container">
                        <!-- listing-item -->
                        @foreach($result as $r)
                            <div class="listing-item">
                                <article class="geodir-category-listing fl-wrap">
                                    <div class="geodir-category-img">
                                        @foreach($image as $i)
                                            @if($i->TIID == $r->id)

                                                <img src="images/{{$i->image}}" alt=image/{{$i->image}}">
                                            @endif
                                        @endforeach

                                    </div>
                                    <div class="geodir-category-content fl-wrap">


                                        <h3><a href="tdetail/{{$r->id}}">{{$r->imamzade_Name}}</a></h3>

                                        <div class="geodir-category-options fl-wrap">

                                            <div class="geodir-category-location"><a href="tmap{{$r->id}}" class="map-item" ><i class="fa fa-map-marker" aria-hidden="true"></i>{{$r->Address}}</a></div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                    @endforeach
                    <!-- listing-item end-->

                    </div>

                </div>
                <!-- list-main-wrap end-->
            </div>
            <!--col-list-wrap -->
            <div class="limit-box fl-wrap"></div>

        </div>
        <!--content end -->
    </div>
    <!-- wrapper end -->


</div>
<!-- Main end -->
<!--=============== scripts  ===============-->




<script>
    var imamzade = {!! json_encode($result) !!};
    var image = {!! json_encode($image) !!};
    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());

    for (i = 0; i < imamzade.length; i++) {
        var lonLat = new OpenLayers.LonLat(imamzade[i].longitude, imamzade[i].latitude)
            .transform(
                new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                map.getProjectionObject() // to Spherical Mercator Projection
            );


        var markers = new OpenLayers.Layer.Markers( "Markers" );
        map.addLayer(markers);

        markers.addMarker(new OpenLayers.Marker(lonLat));
        var zoom = 10;
        map.setCenter(lonLat, zoom);

        for(j = 0; j<image.length;j++) {

            if((image[j].TIID === imamzade[i].id)) {

                var popup_html = "<div class=\"modal__wrapper modal__wrapper--example-theme is-hidden js-example-modal-2\">\n" +
                    "        <div class=\"modal__double js-modal__double\">\n" +
                    "            <div class=\"modal__content\">\n" +
                    "                <a href=\"#\" class=\"modal__close js-modal__close\"></a>\n" +
                    "                <a href=\"tdetail/" + String(imamzade[i].id) + "\"><h4>" + imamzade[i].imamzade_Name + "</h4>\n<a/>" +
                    "                <img style='float:left;\n" +
                    "\twidth:100%;\n" +
                    "\theight:auto;\n" +
                    "\tz-index:1;' src=\"images/" + String(image[j].image) + "\">\n" +

                    "            </div>\n" +
                    "        </div>\n" +
                    "    </div>"
                break;
            }
            else{

                var popup_html = "<div class=\"modal__wrapper modal__wrapper--example-theme is-hidden js-example-modal-2\">\n" +
                    "        <div class=\"modal__double js-modal__double\">\n" +
                    "            <div class=\"modal__content\">\n" +
                    "                <a href=\"#\" class=\"modal__close js-modal__close\"></a>\n" +
                    "                <a href=\"tdetail/"+String(imamzade[i].id)+"\"><h4>" + imamzade[i].imamzade_Name + "</h4>\n<a/>" +


                    "            </div>\n" +
                    "        </div>\n" +
                    "    </div>"
            }

        }
        markers.popup = new OpenLayers.Popup(String(imamzade[i].id),
            lonLat,
            null,
            popup_html,
            true);

        map.addPopup(markers.popup);
        markers.popup.hide();

        markers.events.register("click", markers, function(e) {

            this.popup.show();
        });


    }

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
                alert(data);
                $('.i123456789').append(data);
            }
        });

    });
</script>
</body></html>
@endsection