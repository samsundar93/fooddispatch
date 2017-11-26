<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 24-11-2017
 * Time: 23:11
 */
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('default');
        $this->loadModel('Orders');
        $this->loadModel('Drivers');
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow([
            'login',
            'orderupdate'
        ]);

    }

    public function orderupdate() {

        $prepAddr = str_replace(' ','+',$this->request->getData('delivery_address'));

        $url = "https://maps.google.com/maps/api/geocode/json?address=$prepAddr&key=AIzaSyA_PDTRdxnfHvK3V6-pApjZQgY8F8E5zOM&sensor=false&region=India";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);

        $sourcelatitude = $response_a->results[0]->geometry->location->lat;
        $sourcelongitude = $response_a->results[0]->geometry->location->lng;


        $orderEntity = $this->Orders->newEntity();
        $orderPatch = $this->Orders->patchEntity($orderEntity,$this->request->getData());
        $orderPatch->latitude = $sourcelatitude;
        $orderPatch->longitude = $sourcelongitude;
        $orderSave = $this->Orders->save($orderPatch);
        if($orderSave) {
            $response['success'] = 1;
        }
        die(json_encode($response,true));
    }

    public function login() {

        if(!empty($this->Auth->user())){
            if($this->Auth->redirectUrl() == '/') {
                return $this->redirect(DISPATCH_URL);
            }else {
                return $this->redirect($this->Auth->redirectUrl());
            }

        }else if($this->request->is('post')){
            if($this->request->getData('username') != '' && $this->request->getData('password') != '') {

                $user = $this->Auth->identify();
                if(!empty($user) && ($user['role_id'] == 1)){

                    $this->Auth->setUser($user);
                    return $this->redirect(DISPATCH_URL);
                }else{
                    $this->Flash->error('Invalid username or password, try again');
                }

            }else {
                $this->Flash->error('Required Fields missing');
                return $this->redirect(DISPATCH_URL);
            }

        }

        if($this->request->is('post')) {

        }
    }

    public function dashboard() {


        $driversCount = $this->Drivers->find('all', [
            'conditions' => [
                'id IS NOT NULL',
                'delete_status' => 'No'
            ]

        ])->count();

        $ordersCount = $this->Orders->find('all', [
            'conditions' => [
                'id IS NOT NULL'
            ]

        ])->count();

        $completedOrdersCount = $this->Orders->find('all', [
            'conditions' => [
                'id IS NOT NULL',
                'status' => 'delivered'
            ]

        ])->count();

        $processingOrdersCount = $this->Orders->find('all', [
            'conditions' => [
                'id IS NOT NULL',
                'status' => 'on the way'
            ]

        ])->count();

        $this->set(compact('driversCount','ordersCount','completedOrdersCount','processingOrdersCount'));
    }

    public function settings() {

        $this->loadModel('Settings');
        if($this->request->is('post')) {
            $settingEntity = $this->Settings->newEntity();
            $settingPatch = $this->Settings->patchEntity($settingEntity,$this->request->getData());
            $settingPatch->id = '1';
            $settingDriver = $this->Settings->save($settingPatch);
            $this->Flash->success('Sitesetting update successful');
            return $this->redirect(DISPATCH_URL.'users/settings');
        }

        $siteSettings = $this->Settings->find('all', [
            'id' => '1'
        ])->hydrate(false)->first();

        $this->set(compact('siteSettings'));
    }

    public function getLocation() {

        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        $result  = array('country'=>'', 'city'=>'');
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }

        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
        if($ip_data && $ip_data->geoplugin_countryName != null){
            $result['country'] = $ip_data->geoplugin_countryCode;
            $result['city'] = $ip_data->geoplugin_city;
        }
        if(!empty($result)) {
            echo $result['country'];die();
        }else {
            die();
        }

    }
}