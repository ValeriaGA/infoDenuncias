@extends('administration.layouts.master')

@section('css')

@endsection

@section('js')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/matrix.tables.js') }}"></script>
    <script src="{{ asset('js/comboBoxControl.js') }}"></script>
@endsection

@section('content')

<!--main-container-part-->
<div id="content">
  <!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> 
      <a href="/administracion" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="/administracion/comunidades/grupos">Comunidades</a></a> <a href="/administracion/comunidades/grupos" class="current">Grupos</a>
    </div>
  </div>
  <!--End-breadcrumbs-->
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">

        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Seleccionar</h5>
          </div>
          <div class="widget-content nopadding">
            <form method="post" class="form-horizontal" action="/administracion/comunidades/grupos/filtrar">
              @csrf
              <div class="control-group">
                <label class="control-label">Provincia</label>
                <div class="controls">
                  <select name="province" id="provinces" class="form-control">
                  </select>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Cantón</label>
                <div class="controls">
                  <select name="canton" id="cantons" class="form-control">
                  </select>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Distrito</label>
                <div class="controls">
                  <select name="district" id="districts" class="form-control">
                  </select>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Comunidades</label>
                <div class="controls">
                  <select name="community" id="communities" class="form-control">
                  </select>
                  <hr />
                  @if ($errors->has('community'))
                    <div class="alert alert-error">
                      <button class="close" data-dismiss="alert">×</button>
                      <strong>Error!</strong> {{ $errors->first('community') }}
                    </div>
                  @endif
                </div>
              </div>

              <input type="submit" value="Filtrar" class="btn btn-info">
            </form>
          </div>
        </div>

        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Grupos de comunidades</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Comunidades</th>
                  <th>Editar</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($community_groups as $community_group) 
                <tr class="gradeX">
                  <td>{{$community_group->name}}</td>
                  <td>
                    @foreach ($community_group->community as $communities)
                      <ul class="activity-list">
                        <li><strong>{{ $communities->name }}</strong></li>
                      </ul>
                    @endforeach
                  </td>
                  <td>
                      <button name="{{$community_group->name}}_edit" class="btn btn-warning" onclick="location.href = '/administracion/comunidades/grupos/{{ $community_group->id }}';">Editar</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <form action="/administracion/comunidades/grupos/agregar"><button class="btn btn-success">Agregar</button></form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--end-main-container-part-->
@endsection