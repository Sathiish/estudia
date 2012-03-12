<h1>Panneau d'administration</h1>

<p>Je verrais bien ici un panneau du type joomla</p>

<h2><?php echo $this->Html->link('Cours', array('controller' => 'cours', 'action' => 'manager', 'admin' => true)); ?></h2>
<h2><?php echo $this->Html->link('Membres', array('controller' => 'users', 'action' => 'index', 'admin' => true)); ?></h2>
<h2><?php echo $this->Html->link('Matieres', array('controller' => 'matieres', 'action' => 'index', 'admin' => true)); ?></h2>
<h2><?php echo $this->Html->link('Classes', array('controller' => 'classes', 'action' => 'index', 'admin' => true)); ?></h2>
<h2><?php echo $this->Html->link('Thèmes', array('controller' => 'themes', 'action' => 'index', 'admin' => true)); ?></h2>
