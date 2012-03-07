<?php echo $this->Html->css('dashboard', null, array('inline'=>false)); ?>
  
     <div class="titre"><?php echo $this->Html->image('titre/titre_dashboard.png', array('alt' => 'Titre dashboard','width'=>'155', 'height'=>'22')); ?></div>
     <div class="sous-titre"><img src="/img/fleche.png" /> le suivi de mon activité</div>
    <div class="partie">
        <div class="vignette">
            <div class="vignette messages"><a href="#"></a></div>
            <a href="#"><img class="add" src="/img/dashboard/plus2.png" /></a>
            <img class="bottom" src="/img/cours/bottom_matiere.png" />
        </div>
            <ul>
                <li><?php echo $this->Html->link('Boite de réception', array('controller' => 'messages', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link('Messages envoyés', array('controller' => 'messages', 'action' => 'sent')); ?></li>
                <li><?php echo $this->Html->link('Ecrire un nouveau message', array('controller' => 'messages', 'action' => 'ecrire')); ?></li>
            </ul>
    </div>
    
    <div class="partie">
        <div class="vignette">
            <div class="vignette profil"><a href="#"></a></div>
            <a href="#"><img class="add" src="/img/dashboard/plus2.png" /></a>
            <img class="bottom" src="/img/cours/bottom_matiere.png" />
        </div>
            <ul>
                <li><?php echo $this->Html->link('Voir mon profil', array('controller' => 'users', 'action' => 'index', $_SESSION['Auth']['User']['username'])); ?></li>
                <li><?php echo $this->Html->link('Mettre à jour mon profil', array('controller' => 'users', 'action' => 'edit')); ?></li>
            </ul>
    </div>


    <div class="clr"></div>
    
    <div class="partie">
        <div class="vignette">
            <div class="vignette cours"><a href="#"></a></div>
            <a href="#"><img class="add" src="/img/dashboard/plus2.png" /></a>
            <img class="bottom" src="/img/cours/bottom_matiere.png" />
        </div>
            <ul>
                <li><?php echo $this->Html->link('Voir tous mes cours', array('controller' => 'cours', 'action' => 'manager')); ?></li>
                <li><?php echo $this->Html->link('Créer un cours', array('controller' => 'cours', 'action' => 'edit')); ?></li>
                <li><?php echo $this->Html->link('Voir mes exercices', array('controller' => 'quiz', 'action' => 'manager')); ?></li>
                <li><?php echo $this->Html->link('Créer un exercice', array('controller' => 'quiz', 'action' => 'add')); ?></li>
            </ul>
    </div>
    <div class="partie">
        <div class="vignette">
            <div class="vignette forum"><a href="#"></a></div>
            <a href="#"><img class="add" src="/img/dashboard/plus2.png" /></a>
            <img class="bottom" src="/img/cours/bottom_matiere.png" />
        </div>
            <ul>
                <li><a href="#">Voir tous mes posts</a></li>
                <li><a href="#">Voir mes derniers posts</a></li>
                <li><a href="#">Créer un nouveau post</a></li>
            </ul>
    </div>