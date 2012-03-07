<?php echo $this->Html->css('messagerie', null, array('inline' => false));?>
<?php echo $this->Html->css('form', null, array('inline' => false)); ?>

<div class="messagerie">
<!--    <div class="titre"><?php echo $this->Html->image('titre/titre_messagerie.png', array('alt' => 'Titre dashboard','width'=>'143', 'height'=>'29')); ?></div>-->
    <div class="messagerie menu">
    <div class="item1"></div>
    <ul>
        <li><?php echo $this->Html->link('Boîte de réception', array('controller'=>'messages', 'action' => 'index')); ?> | </li>
        <li><?php echo $this->Html->link('Messages envoyés', array('controller'=>'messages', 'action' => 'sent')); ?> | </li>
        <li><?php echo $this->Html->link('Nouveau message', array('controller'=>'messages', 'action' => 'ecrire'), array('class' => 'active')); ?></li>
    </ul>
    
</div>
    
    <div class="messagerie formulaire">    
<?php echo $this->Form->create('Message');?>
	<fieldset>

	<?php 
        
        if(!empty($this->params['pass'][0])){ $user_id = $this->params['pass'][0]; }
        (!empty($this->params['pass'][1]))? $conversation_id = $this->params['pass'][1]: $conversation_id = 0;
        (!empty($this->params['pass'][2]))? $sujet = $this->params['pass'][2]: $sujet = "";
   
        if(empty($user_id)){                      
           echo $this->Form->input('destinataireUsername', array('label' => "Destinataire", 'type' => 'text','id' => 'username'));
           echo $this->Form->input('destinataire',array("type"=>"hidden", 'id' => 'destinataire'));
           echo $this->Autocomplete->autocomplete('username','UserDestinataire/username',array('destinataire'=>'id')); 
        }else{
            echo 'Destinataire: '.$users[$user_id].'<br />';
            echo $this->Form->input('Message.destinataire', array(
                                    'type' => 'hidden',
                                    'value' => "$user_id",
                                    ));
        }
       
        //Si il y a déjà un sujet, on cache le champs, sinon on l'affiche
	if($sujet == ""){
            echo $this->Form->input('sujet', array(
                            'label' => __('Sujet :'),
                            'error' => array()
                            ));
        }else{
            echo 'Sujet: '.$sujet;
            echo $this->Form->input('Message.sujet', array(
                                    'type' => 'hidden',
                                    'value' => "$sujet",
                                    ));
        }
                                                
			echo $this->Form->input('message', array(
						'label' => __('Votre message'),
						));
                        echo $this->Form->input('conversation_id', array(
						'type' => 'hidden',
                                                'value' => "$conversation_id",
						));

			echo $this->Form->end(__('Envoyer'));
	?>
        
	</fieldset>
    </div>
</div>

<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
        
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',               
                plugins: 'inlinepopups,paste,emotions',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,emotions',
                theme_advanced_buttons2 : '',
                theme_advanced_buttons3 : '',
                theme_advanced_buttons4 : '',
                theme_advanced_toolbar_location:'top',
                theme_advanced_statusbar_location : 'bottom',
                theme_advanced_resizing : true,
                width: '675',
                height: '400',
                paste_remove_styles : true,
                paste_remove_spans :  true,
                paste_stip_class_attributes : "all",
                relative_urls : false,
                content_css : '<?php echo $this->Html->url('/css/wysiwyg.css'); ?>'
        });

<?php $this->Html->scriptEnd(); ?>