<?php
if($action != 'login') {
    echo $this->Html->css([
        FOOD_CSS.'bootstrap.min.css',
        FOOD_CSS.'material-dashboard.css',
        FOOD_CSS.'demo.css',
        FOOD_CSS.'jquery.dataTables.min.css',
    ]);
}else {
    echo $this->Html->css([
        FOOD_CSS.'login.css'
    ]);
}

?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

<link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

<?php
echo $this->Html->script([
    FOOD_JS.'jquery-3.2.1.min.js',
    FOOD_JS.'bootstrap.min.js'
]);
echo  $this->Html->script( 'https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyAzYAo0kwVA0qTj7iPEedXbAoBx03UI9Lg&sensor=false&libraries=places,geometry'
);
?>
