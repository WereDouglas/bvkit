<html>
    <head>
        <?php require_once(APPPATH . 'views/inner-js.php'); ?>
        <style>

            BODY {font-family : Verdana,Arial,Helvetica,sans-serif; color: #000000; font-size : 13px ; }

            #map_canvas { width:100%; height: 100%; z-index: 0; }
        </style>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false" /></script>
    <script type='text/javascript'>

        function initMap() {
            var myLatLng = {lat: -25.363, lng: 131.044};

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Hello World!'
            });
        }
    </script>

</head>
<body>
    <div id='input'>

     

         </div>
    <div id="map"></div>
</body>
</html>