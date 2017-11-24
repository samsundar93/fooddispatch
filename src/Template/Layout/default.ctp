<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <!--<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Dispatch</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <?=
    $this->Html->meta('icon')
    ?>

    <!--Include CSS files-->
    <?=
    $this->element('css')
    ?>

</head>
<body  data-spy="scroll" data-target="#myScrollspy" data-offset="50">
<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="<?php echo DISPATCH_URL ?>img/sidebar-1.jpg">
        <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

    Tip 2: you can also add an image using data-image tag
-->
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text">
                Creative Tim
            </a>
        </div>

        <?php
        echo $this->element('leftside');
        ?>

    </div>

    <!--BODY CONTENT START-->
    <?php
    echo $this->Flash->render();
    ?>

    <?=
    $this->fetch('content')
    ?>
</div>

<?= $this->element('js') ?>
<script>
    var baseUrl = "<?php echo DISPATCH_URL; ?>";
</script>

</body>
</html>