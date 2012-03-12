<ul id="menu-admin">    
    <li><?php echo $this->Html->link('Administration', array('controller' => 'admin', 'action' => 'index', 'admin' => false)); ?></li>
    <li><?php echo $this->Html->link('Cours', array('controller' => 'cours', 'action' => 'manager', 'admin' => true)); ?></li>
    <li><?php echo $this->Html->link('Membres', array('controller' => 'users', 'action' => 'index', 'admin' => true)); ?></li>
    <li><?php echo $this->Html->link('Matieres', array('controller' => 'matieres', 'action' => 'index', 'admin' => true)); ?></li>
    <li><?php echo $this->Html->link('Classes', array('controller' => 'classes', 'action' => 'index', 'admin' => true)); ?></li>
    <li><?php echo $this->Html->link('Thèmes', array('controller' => 'themes', 'action' => 'index', 'admin' => true)); ?></li>
</ul>