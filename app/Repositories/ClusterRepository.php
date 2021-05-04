<?php

//pharmacie

namespace App\Repositories;

use App\Entities\Cluster;
use DB;

class ClusterRepository extends ResourceRepository {

    public function __construct(Cluster $cluster) {
        $this->model = $cluster;
    }

    public function countClusters($search = '-1') {
        if ($search == '-1') {
            return Cluster::count();
        } else {
            return Cluster::leftjoin('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
                            ->where('clusters.code', 'like', "%{$search}%")
                            ->orWhere('clusters.name', 'like', "%{$search}%")
                            ->orWhere('sub_categories.name', 'like', "%{$search}%")
                            ->count();
        }
        return Cluster::count();
    }

    public function getAjaxClusters($start = 0, $limit = 0, $order = 'clusters.id', $dir = '', $draw = 0, $search = '-1') {

        // get sales filtred rows
        $clusters = Cluster::select('clusters.*', 'sub_categories.name as sub_category_name')
                ->leftjoin('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id');

        if ($search != '-1') {
            $clusters->where('clusters.code', 'like', "%{$search}%");
            $clusters->orWhere('clusters.name', 'like', "%{$search}%");
            $clusters->orWhere('sub_categories.name', 'like', "%{$search}%");
        }

        $clusters->offset($start);
        $clusters->limit($limit);
        $clusters->orderBy($order, $dir);
        $clusters = $clusters->get();

        // Total sales rows
        $totalData = $this->countClusters($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($clusters) {
            foreach ($clusters as $c) {
                $nestedData['code'] = $c->code;
                $nestedData['cluster'] = $c->name;
                $nestedData['subCategory'] = $c->sub_category_name;
                $nestedData['status'] = $c->active;

                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="cluster/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="cluster/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this cluster ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="cluster/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="cluster/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="cluster/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this cluster ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="cluster/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
                                <i class="fa fa-thumbs-up"></i>				
                            </a>
                          
                        </span>';
                }




                $data[] = $nestedData;
            }
        }

        return array(
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
    }

    public function listClusters() {

        $clusters = Cluster::select('clusters.*')
                ->orderBy('code')
                ->get();
        return $clusters;
    }

    public function getClusters($search) {

        $clusters = Cluster::select('clusters.*')
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('code')
                ->paginate(20);
        //set the value of the search
        $clusters->appends(['search' => $search]);
        //  dd($products);
        return $clusters;
    }

    public function addCluster($save, $id = '') {

        if ($id == '') {
            $id = DB::table('clusters')->insertGetId(
                    $save
            );
        } else {
            DB::table('clusters')
                    ->where('clusters.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteCluster($id) {

        DB::table('clusters')->where('clusters.id', $id)->delete();
    }

    public function getClusterById($id) {

        $cluster = Cluster::select('clusters.*')
                ->where('clusters.id', $id)
                ->first();
        //dd($cluster);
        return $cluster;
    }

    function get_clusters_by_category($category_id) {

        $clusters = Cluster::select('clusters.*')
                ->leftjoin('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
                ->leftjoin('categories', 'sub_categories.category_id', '=', 'categories.id')
                ->where('categories.id', $category_id)
                ->get();
        return $clusters;
    }

}
