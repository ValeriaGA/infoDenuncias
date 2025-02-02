@extends('layouts.master')

@section('js')

    <!-- PROVINCES -->
    <script src="{{ asset('js/comboBoxControl.js') }}"></script>
@endsection

@section('content')
<style>
            #legend {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 0px;
            margin: 0px;
          }
        </style>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: new google.maps.LatLng(9.8896299, -84.2203189),
          mapTypeId: 'roadmap'
        });
        
        var categories = {!! json_encode($categories->toArray()) !!};
        // alert(types.toSource());


        var iconBase = '/plugins/images/icons/';

        var icons = {};

        categories.forEach(function(category) {
          var dict = {};

          dict['name'] = category['name'];
          if (category['multimedia_path'] != null)
          {
            dict['url'] = iconBase + category['multimedia_path'];
          }else
          {
            dict['url'] = iconBase + '404_small.png';
          }
          dict['size'] = new google.maps.Size(30, 38);
          dict['origin'] = new google.maps.Point(0, 0);
          dict['anchor'] = new google.maps.Point(15, 38);

          icons[category['id']] = dict;
        });

        var reports = {!! json_encode($reports->toArray()) !!};

        var contentStrings = [];

        var features = [];
        var i = 0;
        reports.forEach(function(report) {
          var dict = {};

          dict['position'] = new google.maps.LatLng(report['latitud'], report['longitud']);
          dict['category'] = report['sub_cat_report_id'];
          dict['id'] = i++;
          features.push(dict);

          var content = '<div id="content">'+
              '<div id="siteNotice">'+
              '</div>'+
              '<h1 id="firstHeading" class="firstHeading">'+ icons[report['sub_cat_report_id']]['name'] +'</h1>'+
              '<div id="bodyContent">'+
              '<p><b>Fecha y Hora:</b> '+ report['date'] + ' ' + 
              report['time'] + ' </p>' +
              '<p><b>Descripcion:</b> '+ report['description'] +'</p>'+
              '</div>'+
              '</div>';
          contentStrings.push(content);
        });

        var infowindows = [];

        contentStrings.forEach(function(cz) {
          var infowindow = new google.maps.InfoWindow({
            content: cz
          });
          infowindows.push(infowindow);
        });

        // Create markers.
        features.forEach(function(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.category],
            map: map
          });

          marker.addListener('click', function() {
            infowindows[ feature.id ].open(map, marker);
          });

        });

        var legend = document.getElementById('legend');
        for (var key in icons) {
          var category = icons[key];
          var name = category.name;
          var icon = category.url;
          var div = document.createElement('div');
          div.innerHTML = '<img src="' + icon + '"> ' + name;
          legend.appendChild(div);
        }

        // map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEPYKB-N0arXC7NY0HKivs9_hdOHnDXiA&callback=initMap">
    </script>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Búsqueda</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="/">Inicio</a></li>
                            <li class="active">Búsqueda</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                @auth
                <!-- row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            @include ('layouts.add_report')
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                @endauth
                <div class="row">
                  <div class="col-sm-2">
                      <div class="white-box">
                        <p class="box-title"><a class="btn btn-info" data-toggle="collapse" href="#collapseLegend" role="button" aria-expanded="false" aria-controls="collapseLegend">Leyenda</a></p>
                        <div class="collapse in" id="collapseLegend">
                          <div class="card card-body" id="legend">
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-sm-10">
                      <div class="white-box">
                          <!-- <h3 class="box-title">Map</h3> -->
                          <!-- <div id="gmaps-simple" class="gmaps"></div> -->
                          <div id="map" style="width: 100%; height: 480px"></div>
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="white-box">
                        <h3 class="box-title">Numero de Reportes</h3> 
                        <h4 class="counter text-success" title="incidentes">{{ count($reports) }}</h4>
                      </div>
                  </div>
                  <form action="/busqueda" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-sm-2">
                        <div class="white-box">
                          <h3 class="box-title">Filtrar Por Tipo</h3>
                                @foreach ($categories as $category)
                                  <div class="checkbox checkbox-success checkbox-circle">
                                      <input id="checkbox-{{$category->id}}" type="checkbox" name="category_{{$category->id}}" value="{{$category->name}}" {{in_array($category->id, $categories_id) ? 'checked' : ''}}>
                                      <label for="checkbox-{{$category->id}}"> {{$category->name}} </label>
                                  </div>
                                @endforeach
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="white-box">
                          <h3 class="box-title">Filtrar Por Fecha</h3>
                                <input id="date" type="date" placeholder="" class="form-control form-control-line" name="date" value="{{$date}}">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="white-box">
                          <h3 class="box-title">Filtrar Por Comunidad</h3>

                          <label class="col-md-12">Provincia</label>
                          <select name="province" id="provinces" class="form-control">
                          </select>

                          <label class="col-md-12">Canton</label>
                          <select name="canton" id="cantons" class="form-control">
                          </select>

                          <label class="col-md-12">Distrito</label>
                          <select name="district" id="districts" class="form-control">
                          </select>

                          <label class="col-md-12">Comunidad</label>
                          <select name="community" id="communities" class="form-control">
                          </select>

                          <a href="/comunidades/solicitar-grupo"> ¿No ve su grupo de comunidades? Haga click aquí para solicitarla.</a>
                          
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="white-box">
                                <button class="btn btn-primary" style="width: 100%;">Filtrar</button>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2017 &copy; Ample Admin brought to you by wrappixel.com </footer>
        </div>

@endsection