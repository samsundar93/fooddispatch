<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/26/2017
 * Time: 10:01 AM
 */
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class DriversController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('default');
        $this->loadModel('Orders');
        $this->loadModel('Drivers');
        $this->loadModel('DriverLocations');
        $this->loadModel('Users');
    }

    public function index() {

        $driverDetails = $this->Drivers->find('all', [
            'conditions' => [
                'id IS NOT NULL'
            ]
        ])->hydrate(false)->toArray();

        $this->set(compact('driverDetails'));
    }

    public function add() {
        if($this->request->is('post')) {

            $driverCount = $this->Drivers->find('all', [
                'conditions' => [
                    'phone_number' =>  $this->request->getData('phone_number')
                ]
            ])->count();

            if($driverCount == 0) {
                $driverEntity = $this->Drivers->newEntity();
                $driverPatch = $this->Drivers->patchEntity($driverEntity,$this->request->getData());
                $saveDriver = $this->Drivers->save($driverPatch);
                if($saveDriver) {

                    $user = $this->Users->newEntity();
                    $userDetails['username'] = $this->request->getData('phone_number');
                    $userDetails['password'] = $this->request->getData('password');
                    $userDetails['user_id'] = $saveDriver->id;
                    $userDetails['role_id'] = '2';
                    $usersPatch = $this->Users->patchEntity($user, $userDetails);
                    $saveuser = $this->Users->save($usersPatch);


                    $driverLocation['driver_id'] = $saveDriver->id;


                    $prepAddr = str_replace(' ','+',$this->request->getData('address'));

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

                    $driverLocation['latitude'] = $response_a->results[0]->geometry->location->lat;
                    $driverLocation['longitude'] = $response_a->results[0]->geometry->location->lng;

                    $driverEntity = $this->DriverLocations->newEntity();
                    $driverPatch = $this->DriverLocations->patchEntity($driverEntity,$driverLocation);
                    $saveDriver = $this->DriverLocations->save($driverPatch);

                    $this->Flash->success('Driver added successful');
                    return $this->redirect(DISPATCH_URL.'drivers');
                }
            }else {
                $this->Flash->error('Phone number already exists');
            }

        }
    }

    public function edit($id = null) {

        if($this->request->is('post')) {

            $driverEntity = $this->Drivers->newEntity();
            $driverPatch = $this->Drivers->patchEntity($driverEntity,$this->request->getData());
            $saveDriver = $this->Drivers->save($driverPatch);
            if($saveDriver) {
                $driverLocation['driver_id'] = $this->request->getData('id');


                $prepAddr = str_replace(' ','+',$this->request->getData('address'));

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

                $driverLocation['latitude'] = $response_a->results[0]->geometry->location->lat;
                $driverLocation['longitude'] = $response_a->results[0]->geometry->location->lng;

                $driverEntity = $this->DriverLocations->newEntity();
                $driverPatch = $this->DriverLocations->patchEntity($driverEntity,$driverLocation);
                $saveDriver = $this->DriverLocations->save($driverPatch);

                $this->Flash->success('Driver update successful');
                return $this->redirect(DISPATCH_URL.'drivers');
            }
        }

        $driverDetails = $this->Drivers->find('all', [
            'conditions' => [
                'id' => $id
            ]
        ])->hydrate(false)->first();

        $this->set(compact('driverDetails','id'));

    }

    public function ajaxaction() {
        if($this->request->getData('action') == 'driverstatuschange') {

            $usersEnty         = $this->Drivers->newEntity();
            $usersEnty         = $this->Drivers->patchEntity($usersEnty,$this->request->getData());
            $usersEnty->id     = $this->request->getData('id');
            $usersEnty->status = $this->request->getData('changestaus');
            $this->Drivers->save($usersEnty);

            $this->set('id', $this->request->getData('id'));
            $this->set('action', 'driverstatuschange');
            $this->set('field', $this->request->getData('field'));
            $this->set('status', (($this->request->getData('changestaus') == 0) ? 'deactive' : 'active'));

        }
    }

    public function checkDriver() {
        if($this->request->getData('id') != '') {
            $conditions = [
                'id !=' => $this->request->getData('id'),
                'phone_number' =>  $this->request->getData('phone_number')
            ];

        }else {
            $conditions = [
                'phone_number' =>  $this->request->getData('phone_number')
            ];
        }

        $driverCount = $this->Drivers->find('all', [
            'conditions' => $conditions
        ])->count();
        if($driverCount != 0) {
            echo 'false';exit();
        }
        die();
    }

}