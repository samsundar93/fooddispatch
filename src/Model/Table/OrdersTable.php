<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/26/2017
 * Time: 1:04 AM
 */
namespace App\Model\Table;

use Cake\ORM\Table;



class OrdersTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');

    }
}
?>