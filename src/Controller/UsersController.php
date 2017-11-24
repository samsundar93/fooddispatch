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
    }

    public function beforeFilter(Event $event)
    {
       /* $this->Auth->allow([
           'login'
        ]);*/

    }

    public function login() {

    }

    public function dashboard() {

    }

    public function settings() {

    }
}