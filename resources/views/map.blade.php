@extends('layouts.temp')
@section('content')
<html>
<body>
<br/>

<div id="mapdiv" style="height: 600px; width: 100%; "></div>
<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script>
    var imamzade = {!! json_encode($mapArrays) !!};
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
        var zoom = 10;
        markers.addMarker(new OpenLayers.Marker(lonLat));
        map.setCenter(lonLat, zoom);

        for(j = 0; j<image.length;j++) {
            if(image[j].IID === imamzade[i].id) {
                var popup_html = "<div class=\"modal__wrapper modal__wrapper--example-theme is-hidden js-example-modal-2\">\n" +
                    "        <div class=\"modal__double js-modal__double\">\n" +
                    "            <div class=\"modal__content\">\n" +
                    "                <a href=\"#\" class=\"modal__close js-modal__close\"></a>\n" +
                    "                <a href=\"detail/" + String(imamzade[i].id) + "\"><h4>" + imamzade[i].imamzade_Name + "</h4>\n<a/>" +
                    "                <img style='float:left;\n" +
                    "\twidth:100%;\n" +
                    "\theight:auto;\n" +
                    "\tz-index:1;' src=\"public/images/" + String(image[j].image) + "\">\n" +

                    "            </div>\n" +
                    "        </div>\n" +
                    "    </div>"
                break;
            }
            else{
                    //alert('rrrr');
                    var popup_html = "<div class=\"modal__wrapper modal__wrapper--example-theme is-hidden js-example-modal-2\">\n" +
                        "        <div class=\"modal__double js-modal__double\">\n" +
                        "            <div class=\"modal__content\">\n" +
                        "                <a href=\"#\" class=\"modal__close js-modal__close\"></a>\n" +
                        "                <a href=\"detail/"+String(imamzade[i].id)+"\"><h4>" + imamzade[i].imamzade_Name + "</h4>\n<a/>" +


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


</script>
</body></html>
@endsection