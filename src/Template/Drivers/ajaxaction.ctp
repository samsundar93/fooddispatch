<?php if($action == 'driverstatuschange' && $field == 'status') { ?>
    <?php if($status == 'active'){?>

        <i class="fa fa-toggle-on fa-2x toggleactive" id="on" onclick="changeStatus('<?= $id ?>', '0', '<?= $field ?>', 'drivers/ajaxaction', 'driverstatuschange')"></i>

    <?php }else {?>
        <i class="fa fa-toggle-on fa-2x fa-rotate-180 inactive" id="on" onclick="changeStatus('<?= $id ?>', '1', '<?= $field ?>', 'drivers/ajaxaction', 'driverstatuschange')"></i>
    <?php }?>
<?php exit();} ?>