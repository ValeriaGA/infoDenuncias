<?php

/*
|--------------------------------------------------------------------------
| Main Site
|--------------------------------------------------------------------------
|
|
*/

Route::get('/', 'HomeController@index');
Route::get('/index', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/recientes', 'HomeController@showRecent');
// Route::get('/home/populares', 'HomeController@showPopular');
Route::post('/home', 'HomeController@show');

Route::get('/logout', 'SessionsController@destroy');

Route::get('/informacion', function () {
    return view('information');
});

Route::get('/terminos-y-condiciones', function () {
    return view('terms');
});

// Comments
Route::post('/add-comment', 'CommentController@store');
Route::post('/update-comment', 'CommentController@update');
Route::post('/remove-comment', 'CommentController@destroy');

// Generos
Route::any('/generos', 'GenderController@show');

// Provinces, cantones y distritos
Route::any('/provincias', 'ProvinceController@index');
Route::any('/cantones', 'CantonController@show');
Route::any('/distritos', 'DistrictController@show');

Route::any('/comunidad', 'CommunitiesController@show');
Route::any('/grupos', 'GroupController@show');


// Profile
Route::get('/user', 'UserController@index');
Route::get('/user/{user}', 'UserController@edit');
Route::patch('/user/{user}', 'UserController@update');

Route::patch('/active-community', 'ActiveCommunityController@update');

// Report
Route::get('/reporte/{report}', 'ReportController@show');
Route::get('/reporte/editar/{report}', 'ReportController@edit');

Route::get('/seguridad', function () {
    return abort(404);
});
Route::get('/seguridad/agregar', 'SecurityReportController@create');
Route::post('/seguridad', 'SecurityReportController@store');
Route::patch('/seguridad/{report}', 'SecurityReportController@update');

Route::get('/servicio', function () {
    return abort(404);
});
Route::get('/servicio/agregar', 'ServiceReportController@create');
Route::post('/servicio', 'ServiceReportController@store');
Route::patch('/servicio/{report}', 'ServiceReportController@update');

Route::get('/noticia', function () {
    return abort(404);
});
Route::get('/noticia/agregar', 'NewsController@create');
Route::post('/noticia', 'NewsController@store');
Route::patch('/noticia/{report}', 'NewsController@update');

// Report (ReportAlert)
Route::get('/reportar/{report}', 'ReportAlertController@create');
Route::post('/reportar/{report}', 'ReportAlertController@store');

// Like
Route::any('/like', 'LikeController@store');
Route::any('/unlike', 'LikeController@destroy');

// Statistics

Route::get('/statistics', 'StatisticsController@index');

Route::get('/statistics/securityBar', 'StatisticsController@securityBar');
Route::post('/statistics/securityBar', 'StatisticsController@securityByDate');

Route::get('/statistics/serviceBar', 'StatisticsController@serviceBar');
Route::post('/statistics/serviceBar', 'StatisticsController@serviceByDate');

Route::get('/statistics/genero', 'StatisticsController@statisticsBySex');
Route::post('/statistics/genero', 'StatisticsController@statisticsBySexIncident');

Route::get('/statistics/cr_map', 'StatisticsController@reports_per_province');

Route::get('/statistics/tiempo', 'StatisticsController@chartByTime');
Route::post('/statistics/tiempo', 'StatisticsController@chartByTimeFilters');

// Search
Route::get('/busqueda', 'SearchController@index');
Route::post('/busqueda', 'SearchController@show');


// Communities
Route::get('/comunidades', 'CommunitiesController@index');
Route::post('/grupo-comunidades', 'GroupController@communities');
Route::post('/seguir-grupo', 'GroupController@follow');
Route::post('/dejar-grupo', 'GroupController@unfollow');
Route::get('/mis-grupos', 'GroupController@userCommunitiesIndex');
Route::get('/obtener-grupos', 'GroupController@userCommunitiesShow');

Route::get('/comunidades/solicitar-comunidad', 'CommunitiesController@create');
Route::post('/comunidades/solicitar-comunidad', 'CommunitiesController@store');
Route::get('/comunidades/solicitar-grupo', 'GroupController@create');
Route::post('/comunidades/solicitar-grupo', 'GroupController@store');
Route::post('/comunidades/solicitar-grupo/filtrar', 'GroupController@fetchCommunitiesByDistrict');

// Favorites
Route::get('/favoritas', 'FavoriteController@index');
Route::post('/favoritas/comunidades', 'FavoriteController@show');

/*
|--------------------------------------------------------------------------
| Administration
|--------------------------------------------------------------------------
|
| 
|
*/

Route::get('/administracion', 'AdministrationHomeController@index')->name('admin_home');
Route::get('/administracion/home', 'AdministrationHomeController@index');

Route::get('/administracion/login', 'AdministrationSessionsController@create')->name('admin_login');
Route::post('/administracion/login', 'AdministrationSessionsController@store');
Route::get('/administracion/logout', 'AdministrationSessionsController@destroy');

// Administrators
Route::get('/administracion/administradores', 'AdministrationUsersController@index');
Route::get('/administracion/administradores/agregar', 'AdministrationUsersController@create');
Route::post('/administracion/administradores', 'AdministrationUsersController@store');

// Roles
Route::get('/administracion/roles', 'AdministrationRoleController@index');
Route::post('/administracion/roles', 'AdministrationRoleController@store');
Route::post('/administracion/roles/filtrar', 'AdministrationRoleController@show');
Route::get('/administracion/roles/agregar', 'AdministrationRoleController@create');
Route::get('/administracion/roles/{role}', 'AdministrationRoleController@edit');
Route::patch('/administracion/roles/{role}', 'AdministrationRoleController@update');
Route::get('/administracion/roles/usuarios/{user}', 'AdministrationRoleController@editUser');
Route::post('/administracion/roles/usuarios/{user}', 'AdministrationRoleController@updateUser');


// Reports (Report Alerts)
Route::get('/administracion/reportes', 'AdministrationReportController@index');
Route::get('/administracion/reportes/{report}', 'AdministrationReportController@show');
Route::patch('/administracion/reportes/activo/{report}', 'AdministrationPublicationController@toggle');
Route::get('/administracion/reportes/ignorar/{report}', 'AdministrationPublicationController@ignore');
Route::delete('/administracion/reportes/alertas/{reportAlert}', 'AdministrationReportController@destroy');

// Requests
Route::get('/administracion/solicitudes', 'AdministrationRequestController@index');
Route::post('/administracion/solicitudes/comunidad/agregar/{communityRequest}', 'AdministrationCommunityRequestController@store');
Route::delete('/administracion/solicitudes/comunidad/{communityRequest}', 'AdministrationCommunityRequestController@destroy');

Route::post('/administracion/solicitudes/grupo/agregar/{communityGroupRequest}', 'AdministrationGroupRequestController@store');
Route::delete('/administracion/solicitudes/grupo/{communityGroupRequest}', 'AdministrationGroupRequestController@destroy');


// Publications (Reports)
Route::get('/administracion/publicaciones', 'AdministrationPublicationController@index');
Route::get('/administracion/publicaciones/{report}', 'AdministrationPublicationController@show');
Route::get('/administracion/publicaciones/editar/{report}', 'AdministrationPublicationController@edit');
Route::patch('/administracion/publicaciones/activo/{report}', 'AdministrationPublicationController@toggle');
Route::patch('/administracion/publicaciones/{report}', 'AdministrationPublicationController@update');
Route::delete('/administracion/publicaciones/{report}', 'AdministrationPublicationController@destroy');


// Security Category
Route::get('/administracion/seguridad', 'AdministrationSecurityController@index');
Route::get('/administracion/seguridad/categorias/agregar', 'AdministrationSecurityController@create');
Route::post('/administracion/seguridad/categorias', 'AdministrationSecurityController@store');
Route::get('/administracion/seguridad/{subCatReport}', 'AdministrationSecurityController@edit');
Route::patch('/administracion/seguridad/categorias/{subCatReport}', 'AdministrationSecurityController@update');
Route::patch('/administracion/seguridad/categorias/activo/{subCatReport}', 'AdministrationSecurityController@toggle');

	// Weapon Category
Route::get('/administracion/seguridad/armas/agregar', 'AdministrationWeaponController@create');
Route::post('/administracion/seguridad/armas', 'AdministrationWeaponController@store');
Route::get('/administracion/seguridad/armas/{catWeapon}', 'AdministrationWeaponController@edit');
Route::patch('/administracion/seguridad/armas/{catWeapon}', 'AdministrationWeaponController@update');
Route::patch('/administracion/seguridad/armas/activo/{catWeapon}', 'AdministrationWeaponController@toggle');

	// Transportation Category
Route::get('/administracion/seguridad/transportes/agregar', 'AdministrationTransportationController@create');
Route::post('/administracion/seguridad/transportes', 'AdministrationTransportationController@store');
Route::get('/administracion/seguridad/transportes/{catTransportation}', 'AdministrationTransportationController@edit');
Route::patch('/administracion/seguridad/transportes/{catTransportation}', 'AdministrationTransportationController@update');
Route::patch('/administracion/seguridad/transportes/activo/{catTransportation}', 'AdministrationTransportationController@toggle');


// Service Category
Route::get('/administracion/servicio', 'AdministrationServiceController@index');
Route::get('/administracion/servicio/agregar', 'AdministrationServiceController@create');
Route::post('/administracion/servicio', 'AdministrationServiceController@store');
Route::get('/administracion/servicio/{subCatReport}', 'AdministrationServiceController@edit');
Route::patch('/administracion/servicio/{subCatReport}', 'AdministrationServiceController@update');
Route::patch('/administracion/servicio/activo/{subCatReport}', 'AdministrationServiceController@toggle');

// State
Route::get('/administracion/estados', 'AdministrationStateController@index');
Route::get('/administracion/estados/agregar', 'AdministrationStateController@create');
Route::post('/administracion/estados', 'AdministrationStateController@store');
Route::get('/administracion/estados/{state}', 'AdministrationStateController@edit');
Route::patch('/administracion/estados/{state}', 'AdministrationStateController@update');
Route::patch('/administracion/estados/activo/{state}', 'AdministrationStateController@toggle');

// Gender
Route::get('/administracion/generos', 'AdministrationGenderController@index');
Route::get('/administracion/generos/agregar', 'AdministrationGenderController@create');
Route::post('/administracion/generos', 'AdministrationGenderController@store');
Route::get('/administracion/generos/{gender}', 'AdministrationGenderController@edit');
Route::patch('/administracion/generos/{gender}', 'AdministrationGenderController@update');

// Evidence
Route::get('/administracion/evidencias', 'AdministrationEvidenceController@index');
Route::get('/administracion/evidencias/agregar', 'AdministrationEvidenceController@create');
Route::post('/administracion/evidencias', 'AdministrationEvidenceController@store');

Route::get('/administracion/evidencias/{evidence}', 'AdministrationEvidenceController@edit');
Route::patch('/administracion/evidencias/{evidence}', 'AdministrationEvidenceController@update');
Route::patch('/administracion/evidencias/activo/{evidence}', 'AdministrationEvidenceController@toggle');

// Communities
Route::get('/administracion/comunidades/comunidad', 'AdministrationCommunityController@index');
Route::get('/administracion/comunidades/comunidad/agregar', 'AdministrationCommunityController@create');
Route::post('/administracion/comunidades/comunidad', 'AdministrationCommunityController@store');
Route::get('/administracion/comunidades/comunidad/{community}', 'AdministrationCommunityController@edit');
Route::patch('/administracion/comunidades/comunidad/{community}', 'AdministrationCommunityController@update');
Route::post('/administracion/comunidades/comunidad/filtrar', 'AdministrationCommunityController@show');

Route::get('/administracion/comunidades/grupos', 'AdministrationCommunityGroupController@index');
Route::get('/administracion/comunidades/grupos/agregar', 'AdministrationCommunityGroupController@create');
Route::post('/administracion/comunidades/grupos', 'AdministrationCommunityGroupController@store');
Route::get('/administracion/comunidades/grupos/{community_group}', 'AdministrationCommunityGroupController@edit');
Route::patch('/administracion/comunidades/grupos/{community_group}', 'AdministrationCommunityGroupController@update');
Route::post('/administracion/comunidades/grupos/filtrar', 'AdministrationCommunityGroupController@show');