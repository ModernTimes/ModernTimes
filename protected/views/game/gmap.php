<?php /* Compatibility issue between bootstrap for Yii and Google Maps API v3. Should be resolved in current bootstrap versions. */ ?>
<style type="text/css">
    #mapWrapper {
        /* width: 524px;
        height: 455px; */
        padding: 4px 4px 4px 4px;
        border: 1px dashed black;
        width: 100%;
    }
    #map {
        width: 100%;
        /* ToDo: depends on screen size. Hard to adjust automatically */
        height: 400px;
    }
    #mapInfoPane {
        width: 100%;
        padding-left: 15px;
        text-align: center;
    }
    #mapInfoPane h1 {  
        font-size: 14pt;
        margin-bottom: 15px;
    }  
    #mapInfoPane p {  
        margin-top: 0;  
        margin-top: 15px;
        font-size: 10pt;
        text-align: left;
    }      
    #streetViewWrapper {
        width: 90%;
        height: 204px;
        padding: 4px 4px 0px 4px;
        border: 1px dashed black;
    }
    #streetView {
        width: 100%;
        height: 200px;
    }
    #map label { width: auto; display:inline; }
    #map img { max-width: none; }
    #markerSelection img.off {
        /* border:none; */
        -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
        filter:alpha(Opacity=50);
        -moz-opacity: 0.5;
        opacity: 0.5;
    }
    .btn:hover {
        text-decoration: none;
    }
</style>
<?php
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile("http://maps.googleapis.com/maps/api/js?key=AIzaSyDwLDX0PJnr3uZuZkc3AdYwPhuc2neYgz0&sensor=false&libraries=geometry");
  $cs->registerScriptFile(Yii::app()->baseUrl.'/js/gmap3.min.js');
  // $cs->registerScriptFile(Yii::app()->baseUrl.'/js/markerclusterer.js'); // markermanager_packed.js

  $cs->registerScriptFile(Yii::app()->baseUrl.'/js/prettyprint.js'); // for development purposes only
  /* Usage:
  $('#debug').append(prettyPrint(VAR));
  */

?>
  
<script type="text/javascript">

    <?php /*
    function loadScript() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyDwLDX0PJnr3uZuZkc3AdYwPhuc2neYgz0&sensor=false&callback=initialize";
        document.body.appendChild(script);
    }
    */ ?>
    var baseUrl = '<?php echo Yii::app()->getBaseUrl(); ?>/';
    
    var gmap,
        streetview,
        currentPlace = null;

    var areas = [
        {name:"Undisclosed insurance company",
         markerType:"mischief",
         lat:51.513622, lng:-0.081483,
         pov: { heading: 227,
                pitch: 28,
                zoom: 1 },
         desc: "The usual MBBCG client: over 100,000 employees, 1.5 trillion dollars of assets and a 250-year-old history. Time to tell those losers how to do their job.",
         action: { id: "mischief",
                   name: "Do mischief here",
                   turn: true,
                   params: {
                       areaID: 1,
                   } },
        },
        {name:"Home, sweet home",
         markerType:"home",
         lat:51.488839, lng: -0.177439,
         pov: { heading: 50.4,
                pitch: 0.57,
                zoom: 1 },
         desc: "Your apartment. Well, either here or next door. You spend too many nights in hotel rooms to be sure. Besides, these houses all look the same!",
         action: { id: "rest",
                   name: "Rest",
                   turn: true,
                   params: {} },
         active: true
        },
        {name:"Pablo jr.",
         markerType:"shop",
         lat:51.501655, lng: -0.13192900000001373,
         pov: { heading: -134.68,
                pitch: -6.76,
                zoom: 3 },
         desc: "You see Pablo jr. sitting on his usual bench at St James's park. You wonder what he might have in his little suitcase today.",
         action: { id: "pablo",
                   name: "Talk to him",
                   turn: false,
                   params: {} },
         params: {areaID: 1}
        },
        {name:"McBooz&Bain Consulting Group",
         markerType:"quest",
         lat:51.518912, lng: -0.156052,
         pov: { heading:  -140,
                pitch: 15.5,
                zoom: 1 },
         desc: "The shiny golden plate next to the entrance door reads: \"Making up numbers since 1967.\"",
         action: { id: "visit",
                   name: "Go in",
                   turn: false,
                   params: {} },
         params: {areaID: 1}
        },
    ];
    
    $(function() {
        $('#map').gmap3({
            action: 'init',
            options:{
                center:[51.505751, -0.127029],
                zoom: 12,
                minZoom: 11,
                maxZoom: 17,
                mapTypeId: google.maps.MapTypeId.SATELLITE,

                panControl: false,
                zoomControl: false,
                scaleControl: false,
                overviewMapControl: false,
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_TOP
                },
                mapTypeControl: false
            },
            events: {
                dragend: function() {
                    // Bounds for London
                    // SW, NE
                    var allowedBounds = new google.maps.LatLngBounds(
                        new google.maps.LatLng(51.433036, -0.258865), 
                        new google.maps.LatLng(51.570241, -0.024033));

                    if (allowedBounds.contains($(this).gmap3('get').getCenter())) return;

                    // Out of bounds - Move the map back within the bounds
                    var c = $(this).gmap3('get').getCenter(),
                        x = c.lng(),
                        y = c.lat(),
                        maxX = allowedBounds.getNorthEast().lng(),
                        maxY = allowedBounds.getNorthEast().lat(),
                        minX = allowedBounds.getSouthWest().lng(),
                        minY = allowedBounds.getSouthWest().lat();

                    if (x < minX) x = minX;
                    if (x > maxX) x = maxX;
                    if (y < minY) y = minY;
                    if (y > maxY) y = maxY;

                    $(this).gmap3('get').setCenter(new google.maps.LatLng(y, x));
                }
            }
        });
        gmap = $('#map').gmap3('get');

        streetView = new google.maps.StreetViewPanorama(document.getElementById('streetView'), {
            navigationControl: false,
            navigationControlOptions: {style: google.maps.NavigationControlStyle.ANDROID},
            enableCloseButton: false,
            addressControl: false,
            linksControl: false,
            visible: true,
            position: $('#map').gmap3('get').getCenter()
        });

        // Create markers from area data
        $.each(areas, function(i, area){
            var imgSrc = baseUrl + 'images/map/marker' + area.markerType + '.png';
            var marker = $('#map').gmap3({ 
                action: 'addMarker',
                lat: area.lat,
                lng: area.lng,
                marker:{
                    tag: area.markerType,
                    events:{
                        mouseover: function(marker, event, data){
                            // if(currentPlace != area) {
                                setCurrentPlace(area);
                            // }
                        },
                        mouseout: function(){
                            /* var infowindow = $(this).gmap3({action:'get', name:'infowindow'});
                            if (infowindow){
                                infowindow.close();
                            } */
                        }
                    },
                    options:{
                        draggable: false,
                        icon: new google.maps.MarkerImage(imgSrc,
                                new google.maps.Size(32, 37), // size of image
                                new google.maps.Point(0,0), // The origin for this image is 0,0.
                                new google.maps.Point(16, 37)), // The anchor for this image, relative to origin
                    }
                }
            });
            if(area.active) {
                setCurrentPlace(area);
            }
        });    


        // Development helpers
        google.maps.event.addListener(streetView, 'position_changed', function() {
            $('#devStreetView').css("display", "block");
            $('#devPosition').html(streetView.getPosition().toString())
        });
        google.maps.event.addListener(streetView, 'pov_changed', function() {
            $('#devStreetView').css("display", "block");
            $('#devHeading').html(streetView.getPov().heading)
            $('#devPitch').html(streetView.getPov().pitch)
        });
        google.maps.event.addListener($('#map').gmap3('get'), 'dragend', function() {
            $('#devMap').html($('#map').gmap3('get').getCenter().toUrlValue());  
        });
        google.maps.event.addListener(gmap, 'click', function(event) {
            $('#devMap').html(event.latLng.toUrlValue());
        });
    });
    
    function setCurrentPlace(area) {
        currentPlace = area;

        $('h1', $('#mapInfoPane')).text(area.name);  
        $('p', $('#mapInfoPane')).text(area.desc);  
        $('p', $('#mapInfoPane')).append(getActionButton(area.action));
        // $('#areaDetails').animate({right: '0'});  

        streetView.setPosition(new google.maps.LatLng(area.lat, area.lng));
        streetView.setPov(area.pov);

        /* var map = $(this).gmap3('get'),
            infowindow = $(this).gmap3({action:'get', name:'infowindow'});
        if (infowindow){
            infowindow.open(map, marker);
            infowindow.setContent(area['name']);
        } else {
            $(this).gmap3({action:'addinfowindow', anchor:marker, options:{content: area['name']}});
        } */
    }

    function getLinkUrl(action) {
        var url = baseUrl + 'game/' + action.id + '?';
        for (var param in action.params) {
            if(action.params.hasOwnProperty(param)) {
                url = url + param + '=' + action.params[param] + '&';
            }
        }
        return url;
    }
    function getActionButton(action) {
        var ret = "<BR />&nbsp;<BR />";
        if(action.turn) { ret = ret + "<div class='btn-group'>"; }
        ret = ret + "<div class='btn-group'><a href='" + getLinkUrl(action) + "'>";
        if(action.turn) { ret = ret + "<span class='btn'><i class='icon-time'></i>&nbsp;</span>"; } 
        ret = ret + "<span class='btn btn-warning'>" + action.name + "</span></a>";
        if(action.turn) { ret = ret + "</div>";} 
        return ret;
    }

    // Marker selection
    function toggleMarkers(markerType, img) {
        $(img).toggleClass('off');
        
        markers = $('#map').gmap3({
            action: 'get',
            name: 'marker',
            all: true,
            tag: markerType
        });

        $.each(markers, function(i, marker){
            marker.setMap( !$(img).hasClass('off') ? gmap : null);
        });
    }
        
    function focusWestEnd(event) {
        areaWestEnd.setOptions({fillOpacity: 0, strokeWeight: 3});
        gmap.setZoom(15);
        gmap.setCenter(new google.maps.LatLng(51.51323,-0.143851));
    }
    function showInfowindow(event, contentString) {
        contentString = google.maps.geometry.encoding.encodePath([
            // new google.maps.LatLng(),
            new google.maps.LatLng(51.5134222205612,-0.158407454239835), new google.maps.LatLng(51.5137275085991,-0.155991050828947), new google.maps.LatLng(51.5142307801025,-0.150743465319638), new google.maps.LatLng(51.51593920184,-0.145311822506835), new google.maps.LatLng(51.5197888480417,-0.144787847452093), new google.maps.LatLng(51.5208021991907,-0.139163329420697), new google.maps.LatLng(51.5163905766374,-0.130407608455561), new google.maps.LatLng(51.5133723226958,-0.129105569376926), new google.maps.LatLng(51.5129755474092,-0.129605231562351), new google.maps.LatLng(51.5088505901555,-0.137677489324293), new google.maps.LatLng(51.5061772131222,-0.144129497600128), new google.maps.LatLng(51.5018707358894,-0.151636439566585), new google.maps.LatLng(51.505397906812,-0.150966960414228), new google.maps.LatLng(51.5084716721264,-0.154312774655686), new google.maps.LatLng(51.5134222205612,-0.158407454239835),
        ]).replace(/\\/g,'\\\\');

        // 

        // Replace our Info Window's content and position
        infowindow.setContent(contentString);
        infowindow.setPosition(event.latLng);

        infowindow.open(gmap);
    }
    function printVar(variable) {
        $('#debug').append(prettyPrint(variable));        
    }

</script>


<div id="debug"></div>
    
<?php /*
<div id="markerSelection">
        Show/hide locations: 
            <?php echo CHtml::image(Yii::app()->getBaseUrl() . "/images/map/markerMischief.png", "", array("class" => "", "onClick" => "toggleMarkers('mischief', this)")); ?>
            <?php echo CHtml::image(Yii::app()->getBaseUrl() . "/images/map/markerShop.png", "", array("class" => "", "onClick" => "toggleMarkers('shop', this)")); ?>
</div>
*/ ?>

<div class="row-fluid">
    <div class="span8">
        <div id="mapWrapper"><div id="map"></div></div>
        <span id="devMap" style="font-size: 7pt"></span>
        <div style="font-size: 7pt; display:none;" id="devStreetView">
            Streetview: 
            Position: <span id="devPosition"></span>,
            Heading: <span id="devHeading"></span>,
            Pitch: <span id="devPitch"></span>
        </div>
    </div>
    <div class="span4">
        <div id="mapInfoPane">
            <h1>Area information</h1>
            <div id="streetViewWrapper"><div id="streetView"></div></div>
            <p></p>
        </div>
    </div>
</div>