<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/26/2017
 * Time: 10:12 AM
 */
namespace App\Model\Table;

use Cake\ORM\Table;



class DriverLocationsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');

        $this->belongsTo('Drivers',[
            'className' => 'Drivers',
            'foreignKey' => 'driver_id'
        ]);

    }
}
?>