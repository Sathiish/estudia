<?php echo $this->Html->css('form', null, array('inline' => false));?>
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',               
                plugins: 'inlinepopups,paste,emotions,image',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,image,|,link,unlink',
                theme_advanced_buttons2 : '',
                theme_advanced_buttons3 : '',
                theme_advanced_buttons4 : '',
                theme_advanced_toolbar_location:'top',
                theme_advanced_statusbar_location : 'bottom',
                theme_advanced_resizing : true,
                width : '675',
                height : '100',
                forced_root_block : false,
                force_br_newlines : true,
                force_p_newlines : false,
                paste_remove_styles : true,
                paste_remove_spans :  true,
                paste_stip_class_attributes : "all",
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'message')); ?>',
                image_edit : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'show')); ?>',
                relative_urls : false,
                content_css : '/css/wysiwyg.css'
        });
        
        function send_to_editor(content){
                var ed = tinyMCE.activeEditor;
                ed.execCommand('mceInsertContent',false,content); 
        }
<?php $this->Html->scriptEnd(); ?>

<div id="breadcrumbs">
	<?php echo $this->Html->link("Gérer mes quiz", array("controller" => "quiz", "action" => "manager"), array("title" => "Voir tous mes quiz"));?>
            >> Créer un nouveau quiz

</div>
<div class="professeurs form">
<?php echo $this->Form->create('Quiz', array('url' => '/quiz/add')); ?>

<?php echo $this->Form->input('', array('type'=>'select', 'label' => "Matière :", 'options' => $matieres, 'name'=> 'matieres', 'id'=> 'matieres', 'onChange'=> 'request(this)')); ?>
    <span id="loader" style="display: none;"><?php echo $this->Html->image("loader.gif", array( "alt"=>"loading")); ?></span>
    <select name="data[Quiz][ressource_id]" id="QuizRessourceId"></select>
    
        <script>
function getXMLHttpRequest() {
        var xhr = null;

        if (window.XMLHttpRequest || window.ActiveXObject) {
                if (window.ActiveXObject) {
                        try {
                                xhr = new ActiveXObject("Msxml2.XMLHTTP");
                        } catch(e) {
                                xhr = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                } else {
                        xhr = new XMLHttpRequest(); 
                }
        } else {
                alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
                return null;
        }

        return xhr;
}
        
function request(oSelect) {
	var value = oSelect.options[oSelect.selectedIndex].value;
	var xhr   = getXMLHttpRequest();
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                        document.getElementById("QuizRessourceId").innerHTML = xhr.responseText;
			document.getElementById("loader").style.display = "none";
		} else if (xhr.readyState < 4) {
			document.getElementById("loader").style.display = "inline";
		}
	};
	
	xhr.open("POST", "/ressources/selectbox", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("matieres=" + value);
}
        </script> 
	<?php echo $this->Form->input('name', array(
                                                'label' => "Titre du quiz:",
                                                'error' => array(
                                                        'required' => 'Vous devez entrer un nom de quiz'
                                                    )
            ));?>
	<?php echo $this->Form->input('user_id', array('type' => "hidden", "value" => $_SESSION['Auth']['User']['id'],
				'error' => array(
					'required' => "required"
                                    )));?>
	
	<?php echo $this->Form->input('description', array('label' => "Objectif du quiz :"));?>
	<?php //echo $this->Form->input('final_screen', array('label' => "Message à la fin du quiz :"));?>
 
<?php echo $this->Form->end('Créer ce quiz'); ?>
</div>