<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/26/2017
 * Time: 9:27 AM
 */
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class OrdersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('default');
        $this->loadModel('Orders');
    }

    public function index() {

        $orderDetails = $this->Orders->find('all', [
            'conditions' => [
                'id IS NOT NULL'
            ]
        ])->hydrate(false)->toArray();

        $this->set(compact('orderDetails'));
    }
}