<?php echo $this->Html->css('messagerie', null, array('inline' => false));?>
<!--<div class="titre"><?php echo $this->Html->image('titre/titre_messagerie.png', array('alt' => 'Titre dashboard','width'=>'143', 'height'=>'29')); ?></div>-->
<div class="messagerie menu">
    <div class="item1"></div>
    <ul>
        <li><?php echo $this->Html->link('Boîte de réception', array('controller'=>'messages', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link('Messages envoyés', array('controller'=>'messages', 'action' => 'sent'), array('class' => 'active')); ?></li>
        <li><?php echo $this->Html->link('Nouveau message', array('controller'=>'messages', 'action' => 'ecrire')); ?></li>
    </ul>
    
</div>

<!--<div class="clr"></div>-->
<table class="boite_reception">
    <?php $i = 0; foreach ($messages as $message): ?>
    <tr>
        <td class="avatar"><img src="/img/<?php echo $message['UserDestinataire']['avatar']; ?>" class="profile" alt="profile" width="38" height="38"/></td>
        <td class="expediteur"><span class="uppercase">à</span> <?php echo ucfirst($message['UserDestinataire']['username']).'<br />Le '.date('j M à H:i', strtotime($message['Message']['created'])); ?></td>
        <td class="contenu">
            <?php   
                echo $this->Html->link(ucfirst($message['Message']['sujet']), array('controller' => 'messages', 'action' => 'voir',$message['Message']['id'])).'<br />';
                echo strip_tags(substr($message['Message']['message'], 0, 70)); ?>...</td>
        <td class="actions">
            <?php
                echo $this->Html->image("/img/messagerie/message_lire.png", array(
                    "alt" => "Lire ce message",
                    "title" => "Lire ce message",
                    'url' => array('controller' => 'messages', 'action' => 'voir', $message['Message']['id'])
                ));?><br />
            <?php
                echo $this->Html->image("/img/messagerie/message_repondre.png", array(
                    "alt" => "Répondre",
                    "title" => "Répondre",
                    'url' => array('controller' => 'messages', 'action' => 'ecrire', $message['UserDestinataire']['id'], $message['Message']['conversation_id'],$message['Message']['slug'])
                ));?><br />
            <?php
                echo $this->Html->link(
                    '<img src="/img/messagerie/message_supprimer.png" alt="Supprimer" title="Supprimer" width="20" height="19" />',
                    array('controller' => 'messages', 'action' => 'delete', $message['Message']['id']),
                    array('escape'=>false),
                    ('Etes-vous certain de vouloir supprimer ce message ?')
                ); ?>
            </td>
        
    </tr>
    <?php endforeach; ?>
</table>