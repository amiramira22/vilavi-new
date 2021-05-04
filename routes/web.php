<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
//Route::get('/download/{path}', 'UploadController@download');
Route::get('/download/{path}', ['as' => 'download', 'uses' => 'UploadController@download']);


//Cron Route 
Route::get('cron/update_stock_issue/{date?}', ['as' => 'cron.update_stock_issue', 'uses' => 'CronJobController@update_stock_issue']);
Route::get('cron/performance/{date?}', ['as' => 'cron.performance', 'uses' => 'CronJobController@performance']);


Route::get('/',['as' => 'login', 'uses' => 'LoginController@getLogin']);
Route::post('/',['as' => 'login', 'uses' => 'LoginController@getLogin']);
Route::post('/login',['as' => 'postlogin', 'uses' => 'LoginController@postLogin']);
Route::get('/login',['as' => 'postlogin', 'uses' => 'LoginController@postLogin']);

Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return "Cleared!";
});
Route::get('/noPermission', function () {
    return view('noPermission');
});
Route::group(['middleware' => ['authenticate']], function () {
    Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@getLogout']);
});


//Route::group(['middleware' => 'web'], function () {


    // your routes here
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

    Route::post('/dashboard/load_oos_peer_channel', ['as' => 'dashboard.load_oos_peer_channel', 'uses' => 'DashboardController@load_oos_peer_channel']);
    Route::post('/dashboard/load_chart_oos_per_channel', ['as' => 'dashboard.load_chart_oos_per_channel', 'uses' => 'DashboardController@load_chart_oos_per_channel']);

    Route::post('/dashboard/load_oos_peer_category', ['as' => 'dashboard.load_oos_peer_category', 'uses' => 'DashboardController@load_oos_peer_category']);
    Route::post('/dashboard/load_chart_oos_per_category', ['as' => 'dashboard.load_chart_oos_per_category', 'uses' => 'DashboardController@load_chart_oos_per_category']);


    Route::post('/dashboard/load_numeric_distribution', ['as' => 'dashboard.load_numeric_distribution', 'uses' => 'DashboardController@load_numeric_distribution']);
    Route::post('/dashboard/load_chart_numeric_distribution', ['as' => 'dashboard.load_chart_numeric_distribution', 'uses' => 'DashboardController@load_chart_numeric_distribution']);


    Route::post('/dashboard/load_top_5_oos', ['as' => 'dashboard.load_top_5_oos', 'uses' => 'DashboardController@load_top_5_oos']);
    Route::post('/dashboard/load_top_oos_products', ['as' => 'dashboard.load_top_oos_products', 'uses' => 'DashboardController@load_top_oos_products']);
    Route::post('/dashboard/top_oos_all_products/{date}', ['as' => 'dashboard.top_oos_all_products', 'uses' => 'DashboardController@top_oos_all_products']);
    Route::get('/dashboard/top_oos_all_products/{date}', ['as' => 'dashboard.top_oos_all_products', 'uses' => 'DashboardController@top_oos_all_products']);

    Route::post('/dashboard/load_oos_trend', ['as' => 'dashboard.load_oos_trend', 'uses' => 'DashboardController@load_oos_trend']);
    Route::post('/dashboard/load_chart_oos_trend', ['as' => 'dashboard.load_chart_oos_trend', 'uses' => 'DashboardController@load_chart_oos_trend']);

    Route::get('/dashboard/outlets_details', ['as' => 'dashboard.outlets_details', 'uses' => 'DashboardController@outlets_details']);
    Route::get('dashboard/daily_details', ['as' => 'dashboard.daily_details', 'uses' => 'DashboardController@daily_details']);
    Route::post('dashboard/daily_details', ['as' => 'dashboard.daily_details', 'uses' => 'DashboardController@daily_details']);

    Route::get('/dashboard/monthly_details', ['as' => 'dashboard.monthly_details', 'uses' => 'DashboardController@monthly_details']);
    Route::post('/dashboard/monthly_details', ['as' => 'dashboard.monthly_details', 'uses' => 'DashboardController@monthly_details']);


//Visit Routes
    Route::resource('visit', 'VisitController', ['only' => ['index', 'create', 'store']]);
    Route::post('visit', ['as' => 'visit.index', 'uses' => 'VisitController@index']);
    Route::post('visit/getVisits/', ['as' => 'visit.getVisits', 'uses' => 'VisitController@getVisits']);
    Route::get('visit/delete/{id}', ['as' => 'visit.delete', 'uses' => 'VisitController@delete']);
    Route::get('visit/edit/{id}', ['as' => 'visit.edit', 'uses' => 'VisitController@edit']);
    Route::post('visit/postVisit', ['as' => 'visit.postVisit', 'uses' => 'VisitController@postVisit']);
    Route::get('visit/models/{id}', ['as' => 'visit.models', 'uses' => 'VisitController@models']);
    Route::get('visit/outlet/{id}', ['as' => 'visit.outlet', 'uses' => 'VisitController@outlet']);
    Route::get('visit/copy/{id}', ['as' => 'visit.copy', 'uses' => 'VisitController@copy']);
    Route::post('visit/postDataModel', ['as' => 'visit.postDataModel', 'uses' => 'VisitController@postDataModel']);
    Route::post('visit/extrait_journalier', ['as' => 'visit.extrait_journalier', 'uses' => 'VisitController@extrait_journalier']);
    Route::get('visit/extrait_journalier', ['as' => 'visit.extrait_journalier', 'uses' => 'VisitController@extrait_journalier']);
    Route::post('visit/historique_pdv', ['as' => 'visit.historique_pdv', 'uses' => 'VisitController@historique_pdv']);
    Route::get('visit/historique_pdv', ['as' => 'visit.historique_pdv', 'uses' => 'VisitController@historique_pdv']);
    Route::post('visit/getOutletByZoneChannel', ['as' => 'visit.getOutletByZoneChannel', 'uses' => 'VisitController@getOutletByZoneChannel']);

    Route::get('visit/report/{visit_id}', ['as' => 'visit.report', 'uses' => 'VisitController@report']);
    Route::post('visit/report/{visit_id}', ['as' => 'visit.report', 'uses' => 'VisitController@report']);


    Route::get('visit/position/{visit_id}/{type?}', ['as' => 'visit.position', 'uses' => 'VisitController@position']);

    Route::get('visit/branding', ['as' => 'visit.branding', 'uses' => 'VisitController@branding']);
    Route::post('visit/branding', ['as' => 'visit.branding', 'uses' => 'VisitController@branding']);


    Route::get('visit/order_report/{visit_id}', ['as' => 'visit.order_report', 'uses' => 'VisitController@order_report']);
    Route::post('visit/order_report/{visit_id}', ['as' => 'visit.order_report', 'uses' => 'VisitController@order_report']);

    Route::post('visit/getOutletByZoneFo', ['as' => 'visit.getOutletByZoneFo', 'uses' => 'VisitController@getOutletByZoneFo']);

    Route::get('visit/trackingVisitsReport', ['as' => 'visit.trackingVisitsReport', 'uses' => 'VisitController@trackingVisitsReport']);
    Route::post('visit/trackingVisitsReport', ['as' => 'visit.trackingVisitsReport', 'uses' => 'VisitController@trackingVisitsReport']);


    Route::get('visit/orderReport', ['as' => 'visit.orderReport', 'uses' => 'VisitController@orderReport']);
    Route::post('visit/orderReport', ['as' => 'visit.orderReport', 'uses' => 'VisitController@orderReport']);
    Route::post('visit/getOrderVisits/', ['as' => 'visit.getOrderVisits', 'uses' => 'VisitController@getOrderVisits']);
    Route::post('visit/postOrderFile/', ['as' => 'upload.postOrderFile', 'uses' => 'VisitController@postOrderFile']);



//Report Route
//numeric_distribution
    Route::get('report/numeric_distribution', ['as' => 'report.numeric_distribution', 'uses' => 'ReportController@numeric_distribution']);
    Route::post('report/numeric_distribution', ['as' => 'report.numeric_distribution', 'uses' => 'ReportController@numeric_distribution']);

    Route::post('report/load_av_cluster', ['as' => 'report.load_av_cluster', 'uses' => 'ReportController@load_av_cluster']);
    Route::get('report/load_av_cluster', ['as' => 'report.load_av_cluster', 'uses' => 'ReportController@load_av_cluster']);

    Route::post('report/load_av_cluster_zones', ['as' => 'report.load_av_cluster_zones', 'uses' => 'ReportController@load_av_cluster_zones']);
    Route::get('report/load_av_cluster_zones', ['as' => 'report.load_av_cluster_zones', 'uses' => 'ReportController@load_av_cluster_zones']);

    Route::post('report/load_av_cluster_channels', ['as' => 'report.load_av_cluster_channels', 'uses' => 'ReportController@load_av_cluster_channels']);
    Route::get('report/load_av_cluster_channels', ['as' => 'report.load_av_cluster_channels', 'uses' => 'ReportController@load_av_cluster_channels']);

    Route::post('report/load_av_zone', ['as' => 'report.load_av_zone', 'uses' => 'ReportController@load_av_zone']);
    Route::get('report/load_av_zone', ['as' => 'report.load_av_zone', 'uses' => 'ReportController@load_av_zone']);

    Route::post('report/load_av_channel', ['as' => 'report.load_av_channel', 'uses' => 'ReportController@load_av_channel']);
    Route::get('report/load_av_channel', ['as' => 'report.load_av_channel', 'uses' => 'ReportController@load_av_channel']);

    Route::post('report/extarait_pdv_dn_report', ['as' => 'report.extarait_pdv_dn_report', 'uses' => 'ReportController@extarait_pdv_dn_report']);
    Route::get('report/extarait_pdv_dn_report', ['as' => 'report.extarait_pdv_dn_report', 'uses' => 'ReportController@extarait_pdv_dn_report']);

    Route::post('report/load_extarait_pdv_dn_per_category', ['as' => 'report.load_extarait_pdv_dn_per_category', 'uses' => 'ReportController@load_extarait_pdv_dn_per_category']);
    Route::get('report/load_extarait_pdv_dn_per_category', ['as' => 'report.load_extarait_pdv_dn_per_category', 'uses' => 'ReportController@load_extarait_pdv_dn_per_category']);


    Route::get('report/dn_map', ['as' => 'report.dn_map', 'uses' => 'ReportController@dn_map']);
    Route::post('report/dn_map', ['as' => 'report.dn_map', 'uses' => 'ReportController@dn_map']);
    Route::get('report/get_data_for_dn_maps_report', ['as' => 'report.get_data_for_dn_maps_report', 'uses' => 'ReportController@get_data_for_dn_maps_report']);
    Route::post('report/get_data_for_dn_maps_report', ['as' => 'report.get_data_for_dn_maps_report', 'uses' => 'ReportController@get_data_for_dn_maps_report']);

    Route::get('report/export_map/{start_date}/{end_date}/{channel_id?}/{category_id?}/{sub_category_id?}/{product_group_id?}/{product_id?}', ['as' => 'report.export_map', 'uses' => 'ReportController@export_map']);

    /**/
//shelf_share
    Route::get('report/shelf_share', ['as' => 'report.shelf_share', 'uses' => 'ReportController@shelf_share']);
    Route::post('report/shelf_share', ['as' => 'report.shelf_share', 'uses' => 'ReportController@shelf_share']);
    Route::post('report/load_shelf_cluster', ['as' => 'report.load_shelf_cluster', 'uses' => 'ReportController@load_shelf_cluster']);
    Route::post('report/load_shelf_zone', ['as' => 'report.load_shelf_zone', 'uses' => 'ReportController@load_shelf_zone']);
    Route::post('report/load_shelf_channel', ['as' => 'report.load_shelf_channel', 'uses' => 'ReportController@load_shelf_channel']);

    Route::post('report/load_shelf_zone_pie_chart', ['as' => 'report.load_shelf_zone_pie_chart', 'uses' => 'ReportController@load_shelf_zone_pie_chart']);
    Route::post('report/load_shelf_cluster_zones', ['as' => 'report.load_shelf_cluster_zones', 'uses' => 'ReportController@load_shelf_cluster_zones']);
    Route::post('report/load_shelf_channel_pie_chart', ['as' => 'report.load_shelf_channel_pie_chart', 'uses' => 'ReportController@load_shelf_channel_pie_chart']);
    Route::post('report/load_shelf_cluster_channels', ['as' => 'report.load_shelf_cluster_channels', 'uses' => 'ReportController@load_shelf_cluster_channels']);


    Route::post('report/extarait_pdv_shelf_share_report', ['as' => 'report.extarait_pdv_shelf_share_report', 'uses' => 'ReportController@extarait_pdv_shelf_share_report']);
    Route::get('report/extarait_pdv_shelf_share_report', ['as' => 'report.extarait_pdv_shelf_share_report', 'uses' => 'ReportController@extarait_pdv_shelf_share_report']);

    Route::post('report/load_extarait_pdv_shelf_share_per_category', ['as' => 'report.load_extarait_pdv_shelf_share_per_category', 'uses' => 'ReportController@load_extarait_pdv_shelf_share_per_category']);
    Route::get('report/load_extarait_pdv_shelf_share_per_category', ['as' => 'report.load_extarait_pdv_shelf_share_per_category', 'uses' => 'ReportController@load_extarait_pdv_shelf_share_per_category']);
//
    Route::get('report/shelf_map', ['as' => 'report.shelf_map', 'uses' => 'ReportController@shelf_map']);
    Route::post('report/shelf_map', ['as' => 'report.shelf_map', 'uses' => 'ReportController@shelf_map']);
    Route::get('report/get_data_for_shelf_maps_report', ['as' => 'report.get_data_for_shelf_maps_report', 'uses' => 'ReportController@get_data_for_shelf_maps_report']);
    Route::post('report/get_data_for_shelf_maps_report', ['as' => 'report.get_data_for_shelf_maps_report', 'uses' => 'ReportController@get_data_for_shelf_maps_report']);

//price report
    Route::get('report/price_monotoring', ['as' => 'report.price_monotoring', 'uses' => 'ReportController@price_monotoring']);
    Route::post('report/price_monotoring', ['as' => 'report.price_monotoring', 'uses' => 'ReportController@price_monotoring']);

    Route::get('report/load_price_monotoring_per_cluster', ['as' => 'report.load_price_monotoring_per_cluster', 'uses' => 'ReportController@load_price_monotoring_per_cluster']);
    Route::post('report/load_price_monotoring_per_cluster', ['as' => 'report.load_price_monotoring_per_cluster', 'uses' => 'ReportController@load_price_monotoring_per_cluster']);


//stock issue
    Route::get('report/stock_issue', ['as' => 'report.stock_issue', 'uses' => 'ReportController@stock_issue']);

//Fo Report Route
    Route::get('fo_report/foProfile/', ['as' => 'fo_report.foProfile', 'uses' => 'FoReportController@foProfile']);
    Route::post('fo_report/foProfile/', ['as' => 'fo_report.foProfile', 'uses' => 'FoReportController@foProfile']);


    Route::get('report/store_album', ['as' => 'report.store_album', 'uses' => 'ReportController@store_album']);
    Route::post('report/store_album', ['as' => 'report.store_album', 'uses' => 'ReportController@store_album']);

//Outlet Routes
    Route::resource('outlet', 'OutletController', ['only' => ['index', 'create', 'postOutlet']]);

    Route::post('outlet/index', ['as' => 'outlet.index', 'uses' => 'OutletController@index']);
    Route::get('outlet/index', ['as' => 'outlet.index', 'uses' => 'OutletController@index']);

    Route::post('outlet/postOutlet', ['as' => 'outlet.postOutlet', 'uses' => 'OutletController@postOutlet']);
    Route::get('outlet/edit/{id}', ['as' => 'outlet.edit', 'uses' => 'OutletController@edit']);
    Route::get('outlet/delete/{id}', ['as' => 'outlet.delete', 'uses' => 'OutletController@delete']);
    Route::get('outlet/getOutlets/', ['as' => 'outlet.getOutlets', 'uses' => 'OutletController@getOutlets']);
    Route::post('outlet/getOutlets/', ['as' => 'outlet.getOutlets', 'uses' => 'OutletController@getOutlets']);
    Route::get('outlet/activate/{id}', ['as' => 'outlet.activate', 'uses' => 'OutletController@activate']);
    Route::get('outlet/desactivate/{id}', ['as' => 'outlet.desactivate', 'uses' => 'OutletController@desactivate']);
    Route::get('outlet/view/{id}', ['as' => 'outlet.view', 'uses' => 'OutletController@view']);

    Route::get('outlet/ha_outlets', ['as' => 'outlet.ha_outlets', 'uses' => 'OutletController@ha_outlets']);
    Route::post('outlet/ha_outlets', ['as' => 'outlet.ha_outlets', 'uses' => 'OutletController@ha_outlets']);

    Route::get('outlet/getOutletsForHaProducts/', ['as' => 'outlet.getOutletsForHaProducts', 'uses' => 'OutletController@getOutletsForHaProducts']);
    Route::post('outlet/getOutletsForHaProducts/', ['as' => 'outlet.getOutletsForHaProducts', 'uses' => 'OutletController@getOutletsForHaProducts']);

    Route::get('outlet/geolocalisation', ['as' => 'outlet.geolocalisation', 'uses' => 'OutletController@geolocalisation']);
    Route::post('outlet/geolocalisation', ['as' => 'outlet.geolocalisation', 'uses' => 'OutletController@geolocalisation']);

//});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    Route::post('fo_report/load_fo_routing/', ['as' => 'fo_report.load_fo_routing', 'uses' => 'FoReportController@load_fo_routing']);

    Route::get('fo_report/performance', ['as' => 'fo_report.performance', 'uses' => 'FoReportController@performance']);
    Route::post('fo_report/performance', ['as' => 'fo_report.performance', 'uses' => 'FoReportController@performance']);

    Route::get('fo_report/routing_trend', ['as' => 'fo_report.routing_trend', 'uses' => 'FoReportController@routing_trend']);
    Route::post('fo_report/routing_trend', ['as' => 'fo_report.routing_trend', 'uses' => 'FoReportController@routing_trend']);

    Route::get('fo_report/routing_survey', ['as' => 'fo_report.routing_survey', 'uses' => 'FoReportController@routing_survey']);
    Route::post('fo_report/routing_survey', ['as' => 'fo_report.routing_survey', 'uses' => 'FoReportController@routing_survey']);

    Route::get('fo_report/gps_monitoring', ['as' => 'fo_report.gps_monitoring', 'uses' => 'FoReportController@gps_monitoring']);
    Route::post('fo_report/gps_monitoring', ['as' => 'fo_report.gps_monitoring', 'uses' => 'FoReportController@gps_monitoring']);

    Route::get('fo_report/fo_information_input', ['as' => 'fo_report.fo_information_input', 'uses' => 'FoReportController@fo_information_input']);
    Route::post('fo_report/save_fo_information', ['as' => 'fo_report.save_fo_information', 'uses' => 'FoReportController@save_fo_information']);
    Route::get('fo_report/fo_information_output/{date?}', ['as' => 'fo_report.fo_information_output', 'uses' => 'FoReportController@fo_information_output']);

    Route::post('fo_report/save_fo_information', ['as' => 'fo_report.save_fo_information', 'uses' => 'FoReportController@save_fo_information']);

    Route::get('fo_report/get_events', ['as' => 'fo_report.get_events', 'uses' => 'FoReportController@get_events']);
    Route::post('fo_report/get_events', ['as' => 'fo_report.get_events', 'uses' => 'FoReportController@get_events']);

    Route::get('fo_report/load_tab', ['as' => 'fo_report.load_tab', 'uses' => 'FoReportController@load_tab']);
    Route::post('fo_report/load_tab', ['as' => 'fo_report.load_tab', 'uses' => 'FoReportController@load_tab']);
    Route::post('fo_report/update_fo_information_type', ['as' => 'fo_report.update_fo_information_type', 'uses' => 'FoReportController@update_fo_information_type']);
    Route::post('fo_report/update_fo_information_fo_id', ['as' => 'fo_report.update_fo_information_fo_id', 'uses' => 'FoReportController@update_fo_information_fo_id']);
    Route::get('fo_report/delete_fo_information/{id}/{date}', ['as' => 'fo_report.delete_fo_information', 'uses' => 'FoReportController@delete_fo_information']);
    Route::post('fo_report/update_comment_fo_information', ['as' => 'fo_report.update_comment_fo_information', 'uses' => 'FoReportController@update_comment_fo_information']);


    //user Routes
    Route::resource('user', 'UserController', ['only' => ['index', 'create']]);

    Route::get('user/index', ['as' => 'user.index', 'uses' => 'UserController@index']);
    Route::get('user', ['as' => 'user.create', 'uses' => 'UserController@create']);

    Route::get('user/edit/{id}', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
    Route::put('user/update/{id}', ['as' => 'user.update', 'uses' => 'UserController@update']);
    Route::post('user/store/', ['as' => 'user.store', 'uses' => 'UserController@store']);

    Route::get('user/destroy/{id}', ['as' => 'user.destroy', 'uses' => 'UserController@destroy']);
    Route::get('user/enable/{id}', ['as' => 'user.enable', 'uses' => 'UserController@enable']);
    Route::get('user/disable/{id}', ['as' => 'user.disable', 'uses' => 'UserController@disable']);
    Route::get('user/getUsers/', ['as' => 'user.getUsers', 'uses' => 'UserController@getUsers']);
    Route::post('user/getUsers/', ['as' => 'user.getUsers', 'uses' => 'UserController@getUsers']);

    Route::get('user/messages/', ['as' => 'user.messages', 'uses' => 'UserController@messages']);
    Route::post('user/postMessage/', ['as' => 'user.postMessage', 'uses' => 'UserController@postMessage']);
    Route::get('user/delete_message/{id}', ['as' => 'user.delete_message', 'uses' => 'UserController@delete_message']);


    //Product Routes
    Route::resource('product', 'ProductController', ['only' => ['index', 'create', 'postProduct']]);



    Route::post('product/postProduct', ['as' => 'product.postProduct', 'uses' => 'ProductController@postProduct']);
    Route::get('product/edit/{id}', ['as' => 'product.edit', 'uses' => 'ProductController@edit']);
    Route::get('product/delete/{id}', ['as' => 'product.delete', 'uses' => 'ProductController@delete']);
    Route::get('product/getProducts/', ['as' => 'product.getProducts', 'uses' => 'ProductController@getProducts']);
    Route::post('product/getProducts/', ['as' => 'product.getProducts', 'uses' => 'ProductController@getProducts']);
    Route::get('product/activate/{id}', ['as' => 'product.activate', 'uses' => 'ProductController@activate']);
    Route::get('product/desactivate/{id}', ['as' => 'product.desactivate', 'uses' => 'ProductController@desactivate']);

    Route::get('product/ha_products/{id}', ['as' => 'product.ha_products', 'uses' => 'ProductController@ha_products']);
    Route::post('product/ha_products/{id}', ['as' => 'product.ha_products', 'uses' => 'ProductController@ha_products']);

    Route::get('product/disable', ['as' => 'product.disable', 'uses' => 'ProductController@disable']);
    Route::post('product/disable', ['as' => 'product.disable', 'uses' => 'ProductController@disable']);

    Route::get('product/enable', ['as' => 'product.enable', 'uses' => 'ProductController@enable']);
    Route::post('product/enable', ['as' => 'product.enable', 'uses' => 'ProductController@enable']);


    //ProductGroup Routes
    Route::resource('product_group', 'ProductGroupController', ['only' => ['index', 'create', 'postProductGroup']]);
    Route::post('product_group/postProductGroup', ['as' => 'product_group.postProductGroup', 'uses' => 'ProductGroupController@postProductGroup']);
    Route::get('product_group/edit/{id}', ['as' => 'product_group.edit', 'uses' => 'ProductGroupController@edit']);
    Route::get('product_group/delete/{id}', ['as' => 'product_group.delete', 'uses' => 'ProductGroupController@delete']);
    Route::get('product_group/getProductGroups/', ['as' => 'product_group.getProductGroups', 'uses' => 'ProductGroupController@getProductGroups']);
    Route::post('product_group/getProductGroups/', ['as' => 'product_group.getProductGroups', 'uses' => 'ProductGroupController@getProductGroups']);
    Route::get('product_group/activate/{id}', ['as' => 'product_group.activate', 'uses' => 'ProductGroupController@activate']);
    Route::get('product_group/desactivate/{id}', ['as' => 'product_group.desactivate', 'uses' => 'ProductGroupController@desactivate']);


    //Cluster Routes
    Route::resource('cluster', 'ClusterController', ['only' => ['index', 'create', 'postCluster']]);
    Route::post('cluster/postCluster', ['as' => 'cluster.postCluster', 'uses' => 'ClusterController@postCluster']);
    Route::get('cluster/edit/{id}', ['as' => 'cluster.edit', 'uses' => 'ClusterController@edit']);
    Route::get('cluster/delete/{id}', ['as' => 'cluster.delete', 'uses' => 'ClusterController@delete']);
    Route::get('cluster/getClusters/', ['as' => 'cluster.getClusters', 'uses' => 'ClusterController@getClusters']);
    Route::post('cluster/getClusters/', ['as' => 'cluster.getClusters', 'uses' => 'ClusterController@getClusters']);
    Route::get('cluster/activate/{id}', ['as' => 'cluster.activate', 'uses' => 'ClusterController@activate']);
    Route::get('cluster/desactivate/{id}', ['as' => 'cluster.desactivate', 'uses' => 'ClusterController@desactivate']);

    //SubCategory Routes
    Route::resource('sub_category', 'SubCategoryController', ['only' => ['index', 'create', 'postSubCategory']]);
    Route::post('sub_category/postSubCategory', ['as' => 'sub_category.postSubCategory', 'uses' => 'SubCategoryController@postSubCategory']);
    Route::get('sub_category/edit/{id}', ['as' => 'sub_category.edit', 'uses' => 'SubCategoryController@edit']);
    Route::get('sub_category/delete/{id}', ['as' => 'sub_category.delete', 'uses' => 'SubCategoryController@delete']);
    Route::get('sub_category/getSubCategories/', ['as' => 'sub_category.getSubCategories', 'uses' => 'SubCategoryController@getSubCategories']);
    Route::post('sub_category/getSubCategories/', ['as' => 'sub_category.getSubCategories', 'uses' => 'SubCategoryController@getSubCategories']);
    Route::get('sub_category/activate/{id}', ['as' => 'sub_category.activate', 'uses' => 'SubCategoryController@activate']);
    Route::get('sub_category/desactivate/{id}', ['as' => 'sub_category.desactivate', 'uses' => 'SubCategoryController@desactivate']);

    //Category Routes
    Route::resource('category', 'CategoryController', ['only' => ['index', 'create', 'postCategory']]);
    Route::post('category/postCategory', ['as' => 'category.postCategory', 'uses' => 'CategoryController@postCategory']);
    Route::get('category/edit/{id}', ['as' => 'category.edit', 'uses' => 'CategoryController@edit']);
    Route::get('category/delete/{id}', ['as' => 'category.delete', 'uses' => 'CategoryController@delete']);
    Route::get('category/getCategories/', ['as' => 'category.getCategories', 'uses' => 'CategoryController@getCategories']);
    Route::post('category/getCategories/', ['as' => 'category.getCategories', 'uses' => 'CategoryController@getCategories']);
    Route::get('category/activate/{id}', ['as' => 'category.activate', 'uses' => 'CategoryController@activate']);
    Route::get('category/desactivate/{id}', ['as' => 'category.desactivate', 'uses' => 'CategoryController@desactivate']);

    //Outlet Routes
    Route::resource('outlet', 'OutletController', ['only' => ['index', 'create', 'postOutlet']]);
    Route::post('outlet/postOutlet', ['as' => 'outlet.postOutlet', 'uses' => 'OutletController@postOutlet']);
    Route::get('outlet/edit/{id}', ['as' => 'outlet.edit', 'uses' => 'OutletController@edit']);
    Route::get('outlet/delete/{id}', ['as' => 'outlet.delete', 'uses' => 'OutletController@delete']);
    Route::get('outlet/getOutlets/', ['as' => 'outlet.getOutlets', 'uses' => 'OutletController@getOutlets']);
    Route::post('outlet/getOutlets/', ['as' => 'outlet.getOutlets', 'uses' => 'OutletController@getOutlets']);
    Route::get('outlet/activate/{id}', ['as' => 'outlet.activate', 'uses' => 'OutletController@activate']);
    Route::get('outlet/desactivate/{id}', ['as' => 'outlet.desactivate', 'uses' => 'OutletController@desactivate']);
    Route::get('outlet/view/{id}', ['as' => 'outlet.view', 'uses' => 'OutletController@view']);

    Route::get('outlet/ha_outlets', ['as' => 'outlet.ha_outlets', 'uses' => 'OutletController@ha_outlets']);
    Route::post('outlet/ha_outlets', ['as' => 'outlet.ha_outlets', 'uses' => 'OutletController@ha_outlets']);

    Route::get('outlet/getOutletsForHaProducts/', ['as' => 'outlet.getOutletsForHaProducts', 'uses' => 'OutletController@getOutletsForHaProducts']);
    Route::post('outlet/getOutletsForHaProducts/', ['as' => 'outlet.getOutletsForHaProducts', 'uses' => 'OutletController@getOutletsForHaProducts']);

    Route::get('outlet/geolocalisation', ['as' => 'outlet.geolocalisation', 'uses' => 'OutletController@geolocalisation']);
    Route::post('outlet/geolocalisation', ['as' => 'outlet.geolocalisation', 'uses' => 'OutletController@geolocalisation']);

    //Brand Routes
    Route::resource('brand', 'BrandController', ['only' => ['index', 'create', 'postBrand']]);
    Route::post('brand/postBrand', ['as' => 'brand.postBrand', 'uses' => 'BrandController@postBrand']);
    Route::get('brand/edit/{id}', ['as' => 'brand.edit', 'uses' => 'BrandController@edit']);
    Route::get('brand/delete/{id}', ['as' => 'brand.delete', 'uses' => 'BrandController@delete']);
    Route::get('brand/getBrands/', ['as' => 'brand.getBrands', 'uses' => 'BrandController@getBrands']);
    Route::post('brand/getBrands/', ['as' => 'brand.getBrands', 'uses' => 'BrandController@getBrands']);
    Route::get('brand/activate/{id}', ['as' => 'brand.activate', 'uses' => 'BrandController@activate']);
    Route::get('brand/desactivate/{id}', ['as' => 'brand.desactivate', 'uses' => 'BrandController@desactivate']);

    //Channel Routes
    Route::resource('channel', 'ChannelController', ['only' => ['index', 'create', 'postChannel']]);
    Route::post('channel/postChannel', ['as' => 'channel.postChannel', 'uses' => 'ChannelController@postChannel']);
    Route::get('channel/edit/{id}', ['as' => 'channel.edit', 'uses' => 'ChannelController@edit']);
    Route::get('channel/delete/{id}', ['as' => 'channel.delete', 'uses' => 'ChannelController@delete']);
    Route::get('channel/getChannels/', ['as' => 'channel.getChannels', 'uses' => 'ChannelController@getChannels']);
    Route::post('channel/getChannels/', ['as' => 'channel.getChannels', 'uses' => 'ChannelController@getChannels']);
    Route::get('channel/activate/{id}', ['as' => 'channel.activate', 'uses' => 'ChannelController@activate']);
    Route::get('channel/desactivate/{id}', ['as' => 'channel.desactivate', 'uses' => 'ChannelController@desactivate']);

    //SubChannel Routes
    Route::resource('sub_channel', 'SubChannelController', ['only' => ['index', 'create', 'postSubChannel']]);
    Route::post('sub_channel/postSubChannel', ['as' => 'sub_channel.postSubChannel', 'uses' => 'SubChannelController@postSubChannel']);
    Route::get('sub_channel/edit/{id}', ['as' => 'sub_channel.edit', 'uses' => 'SubChannelController@edit']);
    Route::get('sub_channel/delete/{id}', ['as' => 'sub_channel.delete', 'uses' => 'SubChannelController@delete']);
    Route::get('sub_channel/getSubChannels/', ['as' => 'sub_channel.getSubChannels', 'uses' => 'SubChannelController@getSubChannels']);
    Route::post('sub_channel/getSubChannels/', ['as' => 'sub_channel.getSubChannels', 'uses' => 'SubChannelController@getSubChannels']);
    Route::get('sub_channel/activate/{id}', ['as' => 'sub_channel.activate', 'uses' => 'SubChannelController@activate']);
    Route::get('sub_channel/desactivate/{id}', ['as' => 'sub_channel.desactivate', 'uses' => 'SubChannelController@desactivate']);

    //Zone Routes
    Route::resource('zone', 'ZoneController', ['only' => ['index', 'create', 'postZone']]);
    Route::post('zone/postZone', ['as' => 'zone.postZone', 'uses' => 'ZoneController@postZone']);
    Route::get('zone/edit/{id}', ['as' => 'zone.edit', 'uses' => 'ZoneController@edit']);
    Route::get('zone/delete/{id}', ['as' => 'zone.delete', 'uses' => 'ZoneController@delete']);
    Route::get('zone/getZones/', ['as' => 'zone.getZones', 'uses' => 'ZoneController@getZones']);
    Route::post('zone/getZones/', ['as' => 'zone.getZones', 'uses' => 'ZoneController@getZones']);
    Route::get('zone/activate/{id}', ['as' => 'zone.activate', 'uses' => 'ZoneController@activate']);
    Route::get('zone/desactivate/{id}', ['as' => 'zone.desactivate', 'uses' => 'ZoneController@desactivate']);

    //State Routes
    Route::resource('state', 'StateController', ['only' => ['index', 'create', 'postState']]);
    Route::post('state/postState', ['as' => 'state.postState', 'uses' => 'StateController@postState']);
    Route::get('state/edit/{id}', ['as' => 'state.edit', 'uses' => 'StateController@edit']);
    Route::get('state/delete/{id}', ['as' => 'state.delete', 'uses' => 'StateController@delete']);
    Route::get('state/getStates/', ['as' => 'state.getStates', 'uses' => 'StateController@getStates']);
    Route::post('state/getStates/', ['as' => 'state.getStates', 'uses' => 'StateController@getStates']);
    Route::get('state/activate/{id}', ['as' => 'state.activate', 'uses' => 'StateController@activate']);
    Route::get('state/desactivate/{id}', ['as' => 'state.desactivate', 'uses' => 'StateController@desactivate']);

    //Cron  Route 
    Route::get('cron/update_stock_issue/{date?}', ['as' => 'cron.update_stock_issue', 'uses' => 'CronJobController@update_stock_issue']);

    Route::get('cron/performance/{date?}', ['as' => 'cron.performance', 'uses' => 'CronJobController@performance']);


    Route::get('cron/update_ha_avialibility/{date?}', ['as' => 'cron.update_ha_avialibility', 'uses' => 'CronJobController@update_ha_avialibility']);

    //File  Route 
    Route::get('upload/index/', ['as' => 'upload.index', 'uses' => 'UploadController@index']);
    Route::post('upload/postFile/', ['as' => 'upload.postFile', 'uses' => 'UploadController@postFile']);
    Route::get('upload/deleteFile/{id}', ['as' => 'upload.deleteFile', 'uses' => 'UploadController@deleteFile']);


});


Route::post('changeLang', ['as' => 'changeLang', 'uses' => 'LanguageController@changeLang']);
Route::post('test', ['as' => 'test', 'uses' => 'Api\WebserviceController@test']);
Route::get('test', ['as' => 'test', 'uses' => 'Api\WebserviceController@test']);







