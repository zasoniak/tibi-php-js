<html>
<head>
	<title>Laravel</title>

	<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
	<style>
		#map {
			margin: 50px;
			width: 800px;
			height: 600px;
			border: 1px solid #d0d0d0;
		}

		* {
			font-family: adobe-clean, 'Adobe Clean', Helvetica, Arial, sans-serif;
		}

		body {
			font-family: adobe-clean, 'Adobe Clean', Helvetica, Arial, sans-serif;
			background-color: #f5f5f5;

		}

		.form-item {
			margin: 20px 0;
			font-size: 16px;
		}

		label.form-label {
			margin: 10px 0;
			display: block;
			color: #8D8D8D;
		}

		.container-form {
			margin-left: 70px;
			margin-top: 40px;
			padding: 10px;
		}

		input.styled {
			-webkit-appearance: none;
			-moz-appearance: textfield;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			border: .0625rem solid;
			-webkit-border-radius: 0;
			border-radius: 0;
			background-color: #fff;
			color: #4b4b4b;
			border: 1px solid #d0d0d0;
			padding: 5px 7px;
			width: 90%;
			font-size: 16px;
			border-radius: 3px;
			height: 40px;
		}

		.form-heading {
			font-weight: lighter;
		}

		input.form-btn {
			font-weight: normal;
			color: #fff;
			width: 90%;
			height: 40px;
			text-align: center;
			margin-top: 30px;
			font-size: 16px;
			background-color: #326ec8;
			color: #fff;
			text-shadow: 0 -.0625rem 0 #1e5fbe;
			-webkit-border-radius: .1875rem;
			border-radius: .1875rem;
			border: .0625rem solid;
			border-color: #1e5fbe;
			cursor: pointer;
		}

		input.form-btn:hover {
			background-color: #4178cd;
		}

		input.form-btn-add {
			font-weight: normal;
			color: #fff;
			width: 90%;
			height: 40px;
			text-align: center;
			margin-top: 30px;
			font-size: 16px;
			background-color: #A2A2A2;
			color: #fff;
			text-shadow: 0 -.0625rem 0 #1e5fbe;
			-webkit-border-radius: .1875rem;
			border-radius: .1875rem;
			border: .0625rem solid;
			border-color: #828282;
			cursor: pointer;
			min-width: 170px;
		}

		input.form-btn-add:hover {
			background-color: #4178cd;
		}

		a.form-btn-add {
			font-weight: normal;
			color: #fff;
			width: 90%;
			height: 40px;
			text-align: center;
			margin-top: 30px;
			font-size: 16px;
			background-color: #A2A2A2;
			color: #fff;
			text-shadow: 0 -.0625rem 0 #1e5fbe;
			-webkit-border-radius: .1875rem;
			border-radius: .1875rem;
			border: .0625rem solid;
			border-color: #828282;
			cursor: pointer;
			min-width: 170px;
		}

		a.form-btn-add:hover {
			background-color: #4178cd;
		}

		select#camera-type, select#contact {
			width: 90%;
			height: 40px;
			font-size: 16px;
			border-radius: 0;
			border: 1px solid #d0d0d0;
			line-height: 40px;
			background-color: white;
			-webkit-appearance: menulist-button;
			-webkit-border-radius: 0;
		}

		.map-overlay {
			width: 260px;
			background: #fff;
			padding: 20px;
		}

		a p.overlay-text {
			color: #326ec8;
		}

		p.overlay-text {
			margin: 5px 0;
		}

		.map-overlay-photo {
			background: #eee;
			height: 120px;
			margin-bottom: 20px;
			overflow: hidden;
		}

		.map-overlay-photo img {
			width: 100%
		}


	</style>

	<style>
		body {
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
			color: #B0BEC5;
			display: table;
			font-weight: 100;
			font-family: 'Lato';
		}

		.container {
			text-align: center;
			display: table-cell;
			vertical-align: middle;
		}

		.content {
			text-align: center;
			display: inline-block;
		}

		.title {
			font-size: 96px;
			margin-bottom: 40px;
		}

		.quote {
			font-size: 24px;
		}
	</style>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<script src="https://maps.googleapis.com/maps/api/js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script>

		var markersToPut = JSON.parse('{!! json_encode($markers) !!}');
		console.log(markersToPut);

		var map;
		var markers = [];
		var bounds = new google.maps.LatLngBounds();

		function addMarker(latLng) {
			console.log('bedziemy dodowac w miejscu: ' + latLng);
			var desc = prompt("Podaj opis", "Nieznane miejsce");
			if (desc != null) {
				var url  = '/newmarker/'+latLng.lat()+'/'+latLng.lng()+'/'+encodeURIComponent(desc);
				$.get(url, function (data) {
					reloadMarkers(data);
					console.log(data);
				});
			}

		}
		function removeMarker(id) {
			$.get('/removemarker/' + id, function () {
				$.get("/getmarkers", function (data) {
					console.log(data);
					reloadMarkers(data.markers);
				});
			});
		}

		function initialize() {
			var mapCanvas = document.getElementById("map");
			var mapOptions = {
				center: new google.maps.LatLng(52.229676, 21.012229),
				zoom: 12,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(mapCanvas, mapOptions);
			placeMarkers(markersToPut);
			map.fitBounds(bounds);
			google.maps.event.addListener(map, 'click', function (e) {
				addMarker(e.latLng);
			});
		}


		function placeMarkers(newMarkers) {
			for (var i = 0; i < newMarkers.length; i++) {

				var latLng = new google.maps.LatLng(newMarkers[i].latitude, newMarkers[i].longitude);
				var marker = new google.maps.Marker({
					position: latLng,
					map: map,
					title: newMarkers[i].description
				});


				var contentString = '<div id="content">' +
						'<div class="map-overlay">' +
						'<p class="overlay-text">' + newMarkers[i].description + '</p>' +
						'<a href="#" onclick="removeMarker(' + newMarkers[i].id + ');" ><p class="overlay-text"><strong>Remove Marker</strong></p></a>' +
						'</div>' +
						'</div>';
				marker.info = new google.maps.InfoWindow({
					content: contentString
				});

				google.maps.event.addListener(marker, 'click', function () {
					this.info.open(map, this);
				});

				markers.push(marker);
				bounds.extend(marker.position);
			}

		}
		function clearMap() {
			for (var i = 0; i < markers.length; i++) {
				markers[i].setMap(null);
			}
			markers = [];
			bounds = new google.maps.LatLngBounds();
		}

		function reloadMarkers(newMarkers) {
			clearMap();
			placeMarkers(newMarkers);
			map.fitBounds(bounds);
		}


		google.maps.event.addDomListener(window, 'load', initialize);

	</script>
</head>
<body>
<div class="container">
	<div class="content">
		<div class="title">Mapka</div>
		<div class="quote">Wyświetla obiekty zapisane w bazie danych</div>
	</div>
</div>
<div id="map">

</div>
</body>
</html>
