      <div id="menu_nav<?php if(isset($index)) echo '_index'; ?>"> 
          <ul id="nav">
        <?php if(!isset($_SESSION['Auth']['User']['id'])): ?>
          <li><?php echo $this->Html->link($this->Html->image('/img/maison.png', array('style' => 'width:10px; height:10px')), '/', array('escape' => false, 'title' => 'Retourner à l\'accueil')); ?></li>
        <?php else: ?>
          <li><?php echo $this->Html->link($this->Html->image('/img/maison.png', array('style' => 'width:10px; height:10px')), '/', array('escape' => false, 'title' => 'Mon tableau de bord')); ?></li>
        <?php endif; ?>
          <li><?php echo $this->Html->link('Cours', array('controller'=>'matieres', 'action' => 'index', 'cours','admin' => false)); ?></li>
          <li><?php echo $this->Html->link('Quiz', array('controller'=>'matieres', 'action' => 'index', 'quiz','admin' => false)); ?></li>
<!--          <li><?php //echo $this->Html->link('Forum', array('controller'=>'categories', 'action' => 'index', 'admin' => false)); ?></li>-->
<!--          <li><a href="http://zeschool.com/blog" target="_blank">Actualité</a></li>-->
       
        
          <?php if(isset($_SESSION['Auth']['User']['id'])): ?> 
          <li><?php echo $this->Html->link('Déconnexion', array('controller'=>'users', 'action' => 'logout', 'admin' => false), array('title' => 'Se déconnecter')); ?></li>
          <?php else: ?>
            <li><?php echo $this->Html->link('Connexion', '#', array('id' => 'loginFormLink')); ?></li>
                <div id="loginForm" style="display:none;">
                  <?php  
                    echo $this->Form->create('User', array("controller"=>"users", 'action' => 'login'));
                    echo $this->Form->input('username', array('label' => 'Pseudo'));
                    echo $this->Form->input('password',  array('label' => 'Mot de passe'));
                    echo $this->Form->input('remember_me',  array('type' => 'checkbox', 'style'=> 'float:left','label' => 'Rester connecté'));
                    echo $this->Form->end('Me connecter');  ?>
                </div>
           <?php endif; ?>    
          </ul>
      </div>
      <div class="clr"></div>
      
<?php echo $this->Html->script('menu.js',array('inline'=>true)); ?>
<script type="text/javascript">
  $(function() {
    $('#nav').droppy();
    
    $('#nav #loginFormLink').live('click', function (){
       var e = $('#menu_nav #nav #loginFormLink');
       
       $('#loginForm').toggle('slide');
    });
    
    $('#nav #loginFormLink #loginForm #UserLoginForm').live('submit', function (){
        page = ($(this).attr("action")); 
        var post=$("#UserLoginForm").serialize();
        $.post("/users/login/",post,function(){});                                   
    });                                   
  });
</script>
