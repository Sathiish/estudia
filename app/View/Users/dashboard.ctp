<?php $this->Html->script('dashboard',array('inline'=>false)); ?>
<?php echo $this->Html->css('messagerie', null, array('inline' => false));?>

<div class="titre"><?php echo $this->Html->image('titre/titre_dashboard.png', array('alt' => 'Titre dashboard','width'=>'155', 'height'=>'22')); ?></div>

<div class="bloc profil">
    <div class="title">
        Mon Profil
    </div>
    <div id="profil">

        <h3>Mes infos</h3>
        
        <?php echo $this->Html->image($_SESSION['Auth']['User']['avatar']);?>
        <span id="name"><?php echo $_SESSION['Auth']['User']['lastname'].' '.$_SESSION['Auth']['User']['name']; ?></span>
        <?php if(!empty($_SESSION['Auth']['User']['classe'])): ?>
            <p>Actuellement en <?php echo $_SESSION['Auth']['User']['classe']; ?></p>
        <?php endif; ?>

        <?php echo $this->Html->link('Voir mon profil', array('controller' => 'users', 'action' => 'index', $_SESSION['Auth']['User']['username']), array('class' => 'button')); ?>
        <?php echo $this->Html->link('Modifier mes infos', array('controller' => 'users', 'action' => 'edit'), array('class' => 'button')); ?>
        <?php echo $this->Html->link("Mon mot de passe", array("controller"=>"users", "action" => "change_password"), array("class" => "button")); ?>
    </div>
</div>

<div class="bloc">
    <div class="title">
        <div class="tabs" id="tabs1">
            <?php echo $this->Html->link('Mes cours', array('controller' => 'users', 'action' => 'dashboard'), array('class' => 'not-ajax'));?>
<!--            <a href="#contenu2">Mes quiz</a>-->
            <?php echo $this->Html->link('Mes messages', array('controller' => 'messages', 'action' => 'index'));?>
<!--            <a href="#contenu3">Forum</a>-->
            <?php echo $this->Html->link('Espace rédacteur', array('controller' => 'cours', 'action' => 'manager'));?>
        </div>
    </div>
    <div id="conteneur">

        <h3>Mes cours favoris</h3>
        <ul class="sommaire">
            <?php foreach($favoris as $f): ?>
            <li>
                <?php echo $this->Html->link($f['Cour']['name'], array('controller' => 'cours', 'action' => 'show', $f['Cour']['id'], $f['Cour']['slug']), array('class' => 'not-ajax')); ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

