<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/26/2017
 * Time: 1:50 PM
 */
namespace App\Model\Table;

use Cake\ORM\Table;



class SettingsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');

    }
}
?>