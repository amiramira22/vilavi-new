<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\WebserviceRepository;
use Illuminate\Http\Request;

class WebserviceController extends Controller {

    protected $webserviceRepository;

    public function __construct(WebserviceRepository $webserviceRepository) {
        $this->webserviceRepository = $webserviceRepository;
    }

    function test() {
        $test = $this->webserviceRepository->getProductByName('Product-19');
        $outlet = $this->webserviceRepository->getOutletByID(23);
        $responsible_mail = $this->webserviceRepository->getUserByID(1)->email;
        dd($responsible_mail);
    }

    function saveOutlet() {

        if (isset($_POST['outlet'])) {
            $outlet_object = json_decode($_POST['outlet']);
            $save_outlet = array();
            //Save Files  into server 
            if (isset($_FILES['image'])) {
                //$file_path = "./uploads/outlet/";
                $file_path = public_path('outlet');
                $nameFile = date('Y') . '-' . time() . ".jpg";
                $file_path = $file_path . '/' . $nameFile;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
                    $save_outlet['photos'] = $nameFile;
                }
            }
            // fill the array and save it into the database
            $visit_days = array($outlet_object->visit_day);
            $save_outlet['id'] = false;
            $save_outlet['name'] = $outlet_object->name;
            $save_outlet['contact'] = $outlet_object->contact;
            $save_outlet['admin_id'] = $outlet_object->admin_id;
            $save_outlet['zone'] = $outlet_object->zone;
            $save_outlet['state'] = $outlet_object->state;
            $save_outlet['channel'] = $outlet_object->channel;
            $save_outlet['sub_channel'] = $outlet_object->sub_channel;
            $save_outlet['adress'] = $outlet_object->adress;
            $save_outlet['caisse_number'] = $outlet_object->caisse_number;
            $save_outlet['visit_day'] = json_encode($visit_days);
            $save_outlet['delivery_day'] = $outlet_object->delivery_day;
            $save_outlet['contact_pdv'] = $outlet_object->contact_pdv;
            $save_outlet['longitude'] = $outlet_object->longitude;
            $save_outlet['latitude'] = $outlet_object->latitude;

            $save_outlet['zone_id'] = $this->webserviceRepository->getZoneByName($save_outlet['zone']);
            $save_outlet['channel_id'] = $this->webserviceRepository->getChannelByName($save_outlet['channel']);
            $save_outlet['sub_channel_id'] = $this->webserviceRepository->getSubChannelByName($save_outlet['sub_channel']);
            $save_outlet['state_id'] = $this->webserviceRepository->getSateByName($save_outlet['state']);


            $result = $this->webserviceRepository->saveOutlet($save_outlet);
            if ($result) {
                // successfully inserted into database
                $response["success"] = 1;
                $response["message"] = "Outlet successfully uploaded.";
                // echoing JSON response
                echo json_encode($response);
            } else {
                // failed to insert row
                $response["success"] = 0;
                $response["message"] = "Database Error";

                // echoing JSON response
                echo json_encode($response);
            }
        } else {
            // required field is missing
            $response["success"] = 0;
            $response["message"] = "Outlet is empty";
            // echoing JSON response
            echo json_encode($response);
        }
    }

    function get_current_time() {

        // required field is missing
        $result["success"] = 1;
        $result["message"] = date('H:i:s');

        // echoing JSON response
        echo json_encode($result);
    }

    function saveVisitWithMail() {
        if (isset($_POST['visit'])) {
            $visit = json_decode($_POST['visit']);

            //edited by amira
            if ($visit->exit_time != null) {
                $outlet_id = $visit->outlet_id;

                //Was there
                $outlet = $this->webserviceRepository->getOutletByID($outlet_id);
                $was_there = was_there($outlet->latitude, $outlet->longitude, $visit->latitude, $visit->longitude);

                $visit_date = $visit->date;
                $admin_id = $visit->admin_id;
                //edited by amira
                $visitUniqueId = $outlet_id . $admin_id . str_replace("-", "", $visit_date) . $visit->entry_time;
                if ($this->webserviceRepository->is_visit_uploaded($visitUniqueId)) {
                    $this->webserviceRepository->delete_model_unique_id($visitUniqueId);
                    $this->webserviceRepository->delete_visit_unique_id($visitUniqueId);
                }

                // Real exit time (from server)
                $entry_time = $visit->entry_time;
                $worked_time = $visit->worked_time;
                $exit_time = millisecondes_to_time(time_to_millisecondes($entry_time) + $worked_time);

                $save_visit['admin_id'] = $admin_id;
                $save_visit['uniqueId'] = $visitUniqueId;
                $save_visit['outlet_id'] = $outlet_id;
                $save_visit['entry_time'] = $visit->entry_time;
                $save_visit['mobile_exit_time'] = $visit->exit_time;
                $save_visit['exit_time'] = $exit_time;
                $save_visit['worked_time'] = $visit->worked_time;
                $oos_perc = $visit->oos_perc;
                if (isset($visit->remark)) {
                    $save_visit['remark'] = $visit->remark;
                }
                if (isset($visit->mobile_entry_time)) {
                    $save_visit['mobile_entry_time'] = $visit->mobile_entry_time;
                }

                if (isset($visit->exit_longitude)) {
                    $save_visit['exit_longitude'] = $visit->exit_longitude;
                }
                if (isset($visit->exit_latitude)) {
                    $save_visit['exit_latitude'] = $visit->exit_latitude;
                }
                $save_visit['oos_perc'] = $oos_perc;
                $save_visit['date'] = $visit_date;
                $save_visit['w_date'] = firstDayOf('week', new DateTime($visit_date));
                $save_visit['m_date'] = firstDayOf('month', new DateTime($visit_date));
                $save_visit['q_date'] = firstDayOf('quarter', new DateTime($visit_date));
                $save_visit['longitude'] = $visit->longitude;
                $save_visit['latitude'] = $visit->latitude;
                $save_visit['monthly_visit'] = $visit->monthly_visit;
                $save_visit['was_there'] = $was_there;
                $save_visit['branding_pictures'] = '';
                $save_visit['one_pictures'] = '';
//                $visit_id = $this->webserviceRepository->save_visit($save_visit);
                $visit_id = $this->webserviceRepository->updateOrSaveVisit($save_visit);


                if ($visit_id) {
                    $i = 0;
                    $oos_array = array();
                    $nb_oos = 0;
                    $nb_models = 0;
                    $nb_shelf_henkel = 0;
                    $nb_all_shelf = 0;
                    while (isset($visit->models[$i])) {
                        $model = $visit->models[$i];
                        $product_id = $model->product_id;
                        $brand_id = $model->brand_id;
                        $av = $model->av;
                        $save_model['visit_id'] = $visit_id;
                        $save_model['visit_uniqueId'] = $model->visit_uniqueId;
                        $save_model['product_id'] = $product_id;
                        $save_model['brand_id'] = $brand_id;
                        $save_model['category_id'] = $model->category_id;
                        $save_model['cluster_id'] = $model->cluster_id;
                        $save_model['product_group_id'] = $model->product_group_id;
                        $save_model['target'] = $model->target;
                        $save_model['av'] = $av;
                        $save_model['av_sku'] = $model->av_sku;

                        if ($brand_id == 1) {
                            $save_model['av_sku'] = $av;
                        }

                        $save_model['nb_sku'] = $model->nb_sku;
                        $save_model['sku_display'] = $model->sku_display;
                        $save_model['shelf'] = $model->shelf;
                        $save_model['promo_price'] = $model->promo_price;
                        $save_model['price'] = $model->standard_price;
                        $result = $this->webserviceRepository->save_model($save_model);
                        if ($brand_id == 1) {
                            $nb_models = $nb_models + 1;
                            $nb_shelf_henkel = $nb_shelf_henkel + $model->shelf;
                        }
                        $nb_all_shelf = $nb_all_shelf + $model->shelf;

                        if (($brand_id == 1) && ($av == 0)) {
                            $oos_array[] = $product_id;
                            $nb_oos = $nb_oos + 1;
                        }

                        $i++;
                    }

                    $j = 0;
                    $branding_pictures = array();
                    $one_pictures = array();

                    while (isset($_FILES['before' . $j])) {

//                        $file_path = "./uploads/branding/";
                        $file_path = public_path('branding');

                        $before_img = date('Y') . 'before-' . time() . $j . ".jpg";
                        $after_img = date('Y') . 'after-' . time() . $j . ".jpg";
                        $file_path1 = $file_path . '/' . $before_img;
                        $file_path2 = $file_path . '/' . $after_img;
                        if ((move_uploaded_file($_FILES['before' . $j]['tmp_name'], $file_path1)) && (move_uploaded_file($_FILES['after' . $j]['tmp_name'], $file_path2))) {
                            $branding[] = $before_img;
                            $branding[] = $after_img;
                            if (in_array($branding, $branding_pictures) == false)
                                array_push($branding_pictures, $branding);
                            $branding = array();
                        }
                        $j++;
                    }

                    $y = 0;
                    while (isset($_FILES['picture' . $y])) {

//                        $file_path4 = "./uploads/branding/";
                        $file_path4 = public_path('branding');


                        $one_img = date('Y') . 'one-' . time() . $y . ".jpg";
                        $file_path4 = $file_path4 . '/' . $one_img;
                        if ((move_uploaded_file($_FILES['picture' . $y]['tmp_name'], $file_path4))) {
                            if (in_array($one_img, $one_pictures) == false)
                                $one_pictures[] = $one_img;
                        }
                        $y++;
                    }


                    $config['protocol'] = 'smtp';
                    $config['smtp_host'] = 'smtp.capesolution.tn';
                    $config['smtp_port'] = 587;
                    $config['smtp_user'] = 'hcs@capesolution.tn';
                    $config['smtp_pass'] = 'henkel2016';
                    $config['mailtype'] = 'html';
                    $this->load->library('email', $config);
                    $responsible_id = $this->webserviceRepository->getOutletByID($outlet_id)->responsible_id;
                    $outlet_name = $this->webserviceRepository->getOutletByID($outlet_id)->name;


                    if (($responsible_id > 0) && ($oos_perc > 0)) {

                        //$responsible_mail = $this->webserviceRepository->get_responsible_mail($responsible_id);
                        $responsible_mail = $this->webserviceRepository->getUserByID($responsible_id)->email;

                        $this->email->set_newline("\r\n");
                        $this->email->from('hcs@capesolution.tn', 'Henkel BCS');
                        $this->email->to($responsible_mail);
                        $this->email->subject('OOS Reports ' . $outlet_name . ' ' . $visit_date);


                        $message = '';
                        $message = $message . '<p> Bonjour; <br><br> Veuillez trouver ci-dessous la liste de nos produits en rupture: <br>';
                        $i = 0;
                        foreach ($oos_array as $row) {
                            $i++;
                            $product = $this->webserviceRepository->getProductByID($row);
                            $message = $message . '<p>' . $i . ' ' . $product->name . '<br>';
                        }
                        $message = $message . '<br> Cordialement,';
                        $this->email->message($message);
                        $this->email->send();

                        //save email in database

                        $save_email['responsible_email'] = $responsible_mail;
                        $save_email['message'] = $message;
                        $save_email['date'] = date('Y-m-d H:i:s');
                        $save_email['outlet_name'] = $outlet_name;
                        $save_email['outlet_id'] = $outlet_id;
                        $save_email['responsible_id'] = $responsible_id;
                        $this->webserviceRepository->save_email($save_email);
                    }

                    //table visit_picture

                    $save_pictures['id'] = $visit_id;
                    $save_pictures['branding_pictures'] = json_encode($branding_pictures);
                    $save_pictures['one_pictures'] = json_encode($one_pictures);



//                    $save_pictures1['visit_id'] = $visit_id;
//                    $save_pictures1['branding_pictures'] = json_encode($branding_pictures);
//                    $save_pictures1['one_pictures'] = json_encode($one_pictures);
//                    $this->webserviceRepository->save_visit_picture($save_pictures1);

                    $save_pictures['oos_perc'] = $nb_oos / $nb_models;
                    if ($nb_all_shelf > 0) {
                        $save_pictures['shelf_perc'] = $nb_shelf_henkel / $nb_all_shelf;
                    }
//                    $this->webserviceRepository->update_visit_picture($save_pictures);
                    $this->webserviceRepository->updateOrSaveVisit($save_pictures);

                    //$response["success"] = 1;
                    //$response["message"] = "ddd";
                    //echo json_encode($response);
                    //die();
                    $response["success"] = 1;
                    $response["message"] = "Visit successfully uploaded.";

                    echo json_encode($response);
                } else {

                    $response["success"] = 0;
                    $response["message"] = "Oops! An error occurred.";

                    echo json_encode($response);
                }
            } else {
                //edited by amira
                $response["success"] = 0;
                $response["message"] = "Exit time cannot be null";
            }
        } else {

            $response["success"] = 0;
            $response["message"] = "Oops! Temporary server error.";

            echo json_encode($response);
        }// end if isset($_POST['visit'])
    }

    function registerId() {

        if (isset($_POST['id']) && isset($_POST['register_id'])) {
            $id = $_POST['id'];
            $register_id = $_POST['register_id'];


            $result = $this->webserviceRepository->update_admin($id, $register_id);

            if ($result) {
                $response["success"] = 1;
                $response["message"] = "success initialize.";

                // echoing JSON response
                echo json_encode($response);
            } else {

                $response["success"] = 0;
                $response["message"] = "Oops! An error occurred.";

                // echoing JSON response
                echo json_encode($response);
            }
        } else {
            // required field is missing
            $response["success"] = 0;
            $response["message"] = "Required field(s) is missing";

            // echoing JSON response
            echo json_encode($response);
        }
    }

    function getMessagesByReceiverId() {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];


            $result = $this->webserviceRepository->get_messages_by_receiver_id($id);

            echo json_encode($result);
        } else {
            // required field is missing
            $response["success"] = 0;
            $response["message"] = "Required field(s) is missing";

            // echoing JSON response
            echo json_encode($response);
        }
    }

    function initialize() {
        $users = $this->webserviceRepository->getUsers();
        //print(json_encode($users));
        print(json_encode(array('users' => $users)));
    }

    //get users
    function users() {
        $users = $this->webserviceRepository->getUsers();
        print(json_encode($users));
    }

    //get outlets
    function outlets() {
        $outlets = $this->webserviceRepository->getOutlets();
        print(json_encode($outlets));
    }

    //get products
    function products() {
        $products = $this->webserviceRepository->getProducts();
        print(json_encode($products));
    }

    function categories() {
        $categories = $this->webserviceRepository->getCategories();
        print(json_encode($categories));
    }

    function subCategories() {
        $subCategories = $this->webserviceRepository->getSubCategories();
        print(json_encode($subCategories));
    }

    function productGroups() {
        $productGroups = $this->webserviceRepository->getProductGroups();
        print(json_encode($productGroups));
    }

    function clusters() {
        $clusters = $this->webserviceRepository->getClusters();
        print(json_encode($clusters));
    }

    function brands() {
        $brands = $this->webserviceRepository->getBrands();
        print(json_encode($brands));
    }

    function zones() {
        $zones = $this->webserviceRepository->getZones();
        print(json_encode($zones));
    }

    function states() {
        $states = $this->webserviceRepository->getStates();
        print(json_encode($states));
    }

    //tl visits
    function av_visits() {
        $visits = $this->webserviceRepository->get_ws_av_visits();
        print(json_encode($visits));
    }

    function av_models() {

        if (isset($_POST['visit_id'])) {
            $visit_id = $_POST['visit_id'];


            $result = $this->webserviceRepository->get_av_models($visit_id);

            echo json_encode($result);
        } else {
            // required field is missing
            $response["success"] = 0;
            $response["message"] = "Required field(s) is missing";

            // echoing JSON response
            echo json_encode($response);
        }
    }

}
