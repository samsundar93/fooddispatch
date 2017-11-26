<div class="login-page">
    <div class="form">

        <?= $this->Form->create('LoginForm',[
            'id' => 'LoginForm',
            'name' => 'LoginForm',
            'class'  =>'login-form'
        ])?>
            <input class="form-control" type="text" name="username" placeholder="username" id="username" required/>

            <input class="form-control" type="password" name="password" placeholder="password" id="password" required/>

            <button>login</button>
        <?=  $this->Form->end(); ?>
    </div>
</div>
