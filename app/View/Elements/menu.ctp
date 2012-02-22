      <div class="menu_nav">
          <ul id="nav">
        <?php if(!isset($_SESSION['Auth']['User']['id'])): ?>
          <li><?php echo $this->Html->link('Accueil', '/', array()); ?></li>
        <?php endif; ?>
          <li><?php echo $this->Html->link('Matières', array('controller'=>'matieres', 'action' => 'index', 'admin' => false)); ?></li>
          <li><?php echo $this->Html->link('Forum', array('controller'=>'categories', 'action' => 'index', 'admin' => false)); ?></li>
          <li><a href="http://zeschool.com/blog" target="_blank">Actualité</a></li>
        
          <?php if(isset($_SESSION['Auth']['User']['id'])): ?>
          <li><?php echo $this->Html->link('Mon tableau de bord', '/dashboard', array()); ?>
            <ul style="display:none">
               <li><a href="/cours/manager" >Mes cours</a></li><br />
               <li><a href="/messages" >Ma messagerie</a></li><br />
               <li><?php echo $this->Html->link('Déconnexion', array('controller'=>'users', 'action' => 'logout', 'admin' => false), array('title' => 'Se déconnecter')); ?></li>
            </ul>
          </li>         
          <?php else: ?>
            <li><?php echo $this->Html->link('Pourquoi s\'inscrire', array('controller'=>'users', 'action' => 'inscription', 'admin' => false)); ?></li>
        <?php endif; ?>   
          </ul>
      </div>
      <div class="clr"></div>
      
<?php echo $this->Html->script('menu.js',array('inline'=>true)); ?>
<script type="text/javascript">
  $(function() {
    $('#nav').droppy();
  });
</script>
