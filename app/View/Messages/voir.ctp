<?php echo $this->Html->css('messagerie', null, array('inline' => false));?>

<div class="messagerie">
    
<div class="messagerie menu">
    <div class="item1"></div>
    <ul>
        <li><?php echo $this->Html->link('Ma messagerie', array('controller'=>'messages', 'action' => 'index'), array('class' => 'active')); ?></li>
        <li><?php echo $this->Html->link('Messages envoyés', array('controller'=>'messages', 'action' => 'sent')); ?></li>
        <li><?php echo $this->Html->link('Nouveau message', array('controller'=>'messages', 'action' => 'ecrire')); ?></li>
    </ul>
    
</div>
    
    <div class="messagerie voir">
        <?php $m = $message['Message']; ?>
        <?php $expediteur = $message['UserExpediteur']; ?>
        <div class="messagerie avatar"><img src="/img/<?php echo $message['UserExpediteur']['avatar']; ?>" class="profile" alt="profile" width="38" height="38"/></div>
        <div class="messagerie expediteur">De <a href="/profil/<?php echo $expediteur['username'];?>"><span class="capitalize"><?php echo $expediteur['username'];?></span></a></div>
        <div class="messagerie date">Envoyé le <?php echo date('j M à H:i', strtotime($m['created']));?></div>   
        <div class="clr"></div>
        <div class="messagerie sujet"><span>Sujet:</span> <?php echo ucfirst($m['sujet']);?></div>
       
        

        <div class="messagerie contenu"><?php echo $m['message'];?></div>
    </div>
    
    <div class="messagerie boutons">
    <?php
               echo $this->Html->image("/img/messagerie/message_repondre.png", array(
                    "alt" => "Répondre",
                    "title" => "Répondre",
                    'url' => array('controller' => 'messages', 'action' => 'ecrire',$message['UserExpediteur']['id'], $message['Message']['conversation_id'],$message['Message']['slug'])
                ));?>
            <?php
                echo $this->Html->link(
                    '<img src="/img/messagerie/message_supprimer.png" alt="Supprimer" title="Supprimer" width="20" height="19" />',
                    array('controller' => 'messages', 'action' => 'delete', $message['Message']['id']),
                    array('escape'=>false),
                    ('Etes-vous certain de vouloir supprimer ce message ?')
                );?>
    </div>
    <div class="clr"></div>
    
    <?php if(!empty($conversations)){ ?>
        
        <?php $i = 0; foreach ($conversations as $conversation): ?>
       <div class="messagerie voir">
            <div class="messagerie avatar"><img src="/img/<?php echo $conversation['UserExpediteur']['avatar']; ?>" class="profile" alt="profile" width="38" height="38"/></div>
            <div class="messagerie expediteur">De <?php echo ucfirst($conversation['UserExpediteur']['username']);?></div>
            <div class="messagerie date">Le <?php echo date('j M à H:i', strtotime($conversation['Message']['created'])); ?></div>
            <div class="clr"></div>
        <div class="messagerie sujet"><span>Sujet:</span> <?php echo $this->Html->link($m['sujet'], array('controller' => 'messages', 'action' => 'voir',$conversation['Message']['id'],$conversation['Message']['slug']));?></div>

            <div class="messagerie contenu"><?php echo $conversation['Message']['message']; ?></div>
       </div>    
            <div class="messagerie boutons">
                <?php
                    echo $this->Html->image("/img/messagerie/message_repondre.png", array(
                        "alt" => "Répondre",
                        "title" => "Répondre",
                        'url' => array('controller' => 'messages', 'action' => 'ecrire', $conversation['UserExpediteur']['id'], $conversation['Message']['conversation_id'],$conversation['Message']['slug'])
                    ));?>
                <?php
                echo $this->Html->link(
                    '<img src="/img/messagerie/message_supprimer.png" alt="Supprimer" title="Supprimer" width="16" height="16" />',
                    array('controller' => 'messages', 'action' => 'delete', $conversation['Message']['id']),
                    array('escape'=>false),
                    ('Etes-vous certain de vouloir supprimer ce message ?')
                ); ?><br />

            </div> 
            <div class="clr"></div>
        </div>
        <?php endforeach; ?>

   <?php } ?>
</div>