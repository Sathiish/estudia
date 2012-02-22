	<div class="login" style="float:left; padding-left:20px; width:360px;">
            <h1 style="margin-bottom:20px; padding-bottom:10px; border-bottom:1px grey solid;width:340px">Se connecter</h1>

            <div class="login">
          <?php  
            echo $this->Form->create('User', array("controller"=>"users", 'action' => 'login'));
            echo $this->Form->input('username', array('label' => 'Pseudo'));
            echo $this->Form->input('password',  array('label' => 'Mot de passe'));
            echo $this->Form->input('remember_me',  array('type' => 'checkbox', 'style'=> 'float:left','label' => 'Rester connecté'));
            echo $this->Form->end('Me connecter');  ?>
            </div>
            
            <div class="clr"></div>
            
            <div style="font-size:18px; color:black; font-weight:bold; margin:10px 40px">
                    <div style="float:left; border-bottom:1px solid grey; width:100px; padding-bottom:10px"></div>
                    <div style="float:left; padding:0 14px">OU</div>
                    <div style="float:left; border-bottom:1px solid grey; width:100px; padding-bottom:10px"></div>
                    <div style="clear:both"></div>
            </div>

            <?php echo $this->Html->link("J'ai oublié mon mot de passe", array("controller" => "users", "action" => "recover_password"), array('class' => "button"));  ?>
		
	</div>

