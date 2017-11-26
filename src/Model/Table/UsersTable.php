<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/26/2017
 * Time: 9:37 PM
 */
namespace App\Model\Table;

use Cake\ORM\Table;



class UsersTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');

    }
}
?>