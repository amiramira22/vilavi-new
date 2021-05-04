<?php

//HCM

namespace App\Repositories;

use App\Entities\User;
use App\Entities\Product;
use App\Entities\ProductGroup;
use App\Entities\Category;
use App\Entities\HaProduct;
use App\Entities\Outlet;
use App\Entities\Zone;
use App\Entities\State;
use App\Entities\Channel;
use App\Entities\SubChannel;
use App\Entities\MyModel;
use App\Entities\Email;
use App\Entities\Message;
use DB;

class WebserviceRepository extends ResourceRepository {

    public function __construct(User $user) {
        $this->user = $user;
    }

    // List of products
    function getProducts() {

        $products = Product::select('products.id'
                        , 'products.name'
                        , 'products.nb_sku'
                        , 'products.image'
                        , 'products.active'
                        , 'products.code'
                        , 'products.code_gemo'
                        , 'products.code_mg'
                        , 'products.code_uhd'
                        , 'product_groups.id as product_group_id'
                        , 'clusters.id as cluster_id'
                        , 'sub_categories.id as sub_category_id'
                        , 'categories.id as category_id'
                        , 'brands.id as brand_id')
                ->leftjoin('product_groups', 'product_groups.id', '=', 'products.product_group_id')
                ->leftjoin('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
                ->leftjoin('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
                ->leftjoin('categories', 'categories.id', '=', 'sub_categories.category_id')
                ->leftjoin('brands', 'brands.id', '=', 'products.brand_id')
                ->where('products.active', '=', 1)
                ->orderBy('products.name', 'ASC');

        $results = $products->get();
        return $results;
    }

    public function getProductByID($product_id) {
        return Product::find($product_id)->first();
    }

    public function getProductByName($name) {
        return Product::where('name', $name)->first()->id;
    }

    // List of product_groups
    function getProductGroups() {
        return ProductGroup::where('active', '=', 1)->get();
    }

    public function getProductGroupByID($id) {
        return ProductGroup::find($id)->first();
    }

    public function getProductGroupByName($name) {
        return ProductGroup::where('name', $name)->first()->id;
    }

    // List of clisters

    function getClusters() {
        return Cluster::where('active', '=', 1)->get();
    }

    public function getClusterByID($id) {
        return Cluster::find($id)->first();
    }

    public function getClusterByName($name) {
        return Cluster::where('name', $name)->first()->id;
    }

    // List of sub_categories
    function getSubCategories() {
        return SubCategory::where('active', '=', 1)->get();
    }

    public function getSubCategoryByID($id) {
        return SubCategory::find($id)->first();
    }

    public function getSubCategoryByName($name) {
        return SubCategory::where('name', $name)->first()->id;
    }

    // List of categories
    function getCategories() {
        return Category::where('active', '=', 1)->get();
    }

    public function getCategoryByID($id) {
        return Category::find($id)->first();
    }

    public function getCategoryByName($name) {
        return Category::where('name', $name)->first()->id;
    }

    // List of brands
    function getBrands() {
        return Brand::where('active', '=', 1)->get();
    }

    public function getBrandByID($id) {
        return Brand::find($id)->first();
    }

    public function getBrandByName($name) {
        return Brand::where('name', $name)->first()->id;
    }

    // List of users
    function getUsers() {
        return User::where('active', '=', 1)->get();
    }

    public function getUserByID($id) {
        return User::find($id)->first();
    }

    public function getUserByName($name) {
        return User::where('name', $name)->first()->id;
    }

    // List of outlets
    function getOutlets() {
        return Outlet::where('active', '=', 1)->get();
    }

    public function getOutletByID($id) {
        return Outlet::find($id)->first();
    }

    public function getOutletByName($name) {
        return Outlet::where('name', $name)->first()->id;
    }

    // List of zones
    function getZones() {
        return Zone::where('active', '=', 1)->get();
    }

    public function getZoneByID($id) {
        return Zone::find($id)->first();
    }

    public function getZoneByName($name) {
        return Zone::where('name', $name)->first()->id;
    }

    // List of states
    function getStates() {
        return State::where('active', '=', 1)->get();
    }

    public function getStatesByID($id) {
        return State::find($id)->first();
    }

    public function getStatesByName($name) {
        return State::where('name', $name)->first()->id;
    }

    // List of channels
    function getChannels() {
        return Channel::where('active', '=', 1)->get();
    }

    public function getChannelByID($id) {
        return Channel::find($id)->first();
    }

    public function getChannelByName($name) {
        return Channel::where('name', $name)->first()->id;
    }

    // List of sub_channels
    function getSubChannels() {
        return SubChannel::where('active', '=', 1)->get();
    }

    public function getSubChannelByID($id) {
        return SubChannel::find($id)->first();
    }

    public function getSubChannelByName($name) {
        return SubChannel::where('name', $name)->first()->id;
    }

    function saveOutlet($outlet) {
        return Outlet::insert($outlet);
    }

    //return yes if visit is already uploaded
    function is_visit_uploaded($visit_uniqueId) {
        return Visit::where('uniqueId', $visit_uniqueId)->first();
    }

    //delete visit
    function delete_visit_unique_id($visit_uniqueId) {
        return Visit::where('visit_uniqueId', $visit_uniqueId)->delete();
    }

    //delete model
    function delete_model_unique_id($visit_uniqueId) {
        return MyModel::leftjoin('visits', 'visits.id', '=', 'models.visit_id')
                        ->where('visit_uniqueId', $visit_uniqueId)
                        ->delete();
    }

    //save model
    function save_model($model) {
        return MyModel::insert($model);
    }

    //save email
    function save_email($email) {
        return Email::insert($email);
    }

    function updateOrSaveVisit($visit) {
        return Visit::updateOrCreate($visit);
    }

    function update_admin($id, $register_id) {
        return User::where('id', $id)
                        ->update(['register_id' => $register_id]);
    }

    function get_messages_by_receiver_id($id) {
        return Message::select('messages.id as message_id'
                                , 'admin.name as sender_name'
                                , 'messages.message as message'
                                , 'messages.created as created')
                        ->leftjoin('admin', 'admin.id', '=', 'messages.sender_id')
                        ->where('receiver_id', '=', $id)
                        ->orderBy('created')
                        ->get();
    }

    // Tl Webservices
    // List of av visits -- edited by boulbaba 12-03-2018
    function get_ws_av_visits() {
        $current_date = date('Y-m-d');
        return Visit::select('visits.*'
                                , 'outlets.name as outlet_name'
                                , 'outlets.photos as outlet_photo'
                                , 'outlets.longitude as outlet_longitude'
                                , 'outlets.latitude as outlet_latitude'
                                , 'outlets.contact_pdv as contact_pdv'
                                , 'outlets.contact as contact_tel'
                                , 'admin.name as merch_name')
                        ->leftjoin('outlets', 'outlets.id', '=', 'visits.outlet_id')
                        ->leftjoin('admin', 'admin.id', '=', 'visits.admin_id')
                        ->where('visits.date', '=', $current_date)
                        ->get();
//                ->toArray();
    }

//    function update_visit_picture($visit) {
//        if ($visit['id']) {
//            return Visit::where('id', $visit['id'])
//                            ->update($visit);
//        }
//    }
//
//    function save_visit($visit) {
//        return Visit::insert($visit);
//    }
//    
//    function save_visit_picture($picture) {
//        return VisitPicture::insert($picture);
//    }
//    
//
    ////////////////////////////////////////////////////////////////////////////////////////////////
    // List of av models -- edited by boulbaba 28-03-2018
    function get_av_models($visit_id) {
        return MyModel::select('products.name as product_name'
                                , 'categories.name as category_name'
                                , 'categories.id as category_id')
                        ->join('visits', 'visits.id', '=', 'models.visit_id')
                        ->join('categories', 'categories.id', '=', 'models.category_id')
                        ->join('products', 'products.id', '=', 'models.product_id')
                        ->where('models.av_sku', 0)
                        ->where('models.brand_id', 1)
                        ->where('visits.id', $visit_id)
                        ->orderBy("categories.id", "asc")
                        ->get();
    }

}
