<?php echo $this->Html->css('form', null, array('inline' => false));?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all" />
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>


<?php

if(!empty($path)):
    foreach ($path as $link):
        switch($link['Ressource']['type']){
                case "theme":
                    $linkTarget = 'view';
                    break;
                case "matiere":
                    $linkTarget = 'view';
                    break;
                case "cours":
                    $linkTarget = 'sommaire';
                    break;
                default:
                    $linkTarget = "partie";
            }
        echo ' >> '.$this->Html->link($link['Ressource']['titre'], array("controller" => "ressources", "action" => $linkTarget,$link['Ressource']['id'],$link['Ressource']['slug']));
    endforeach;
endif; 

if(!empty($this->data['User']['id']) AND $_SESSION['Auth']['User']['id'] == $this->data['User']['id']):    
    
    if($rang == "cours"){
        $targetLink = "sommaire";
    }else{
        $targetLink = "partie";
    }

?>
    <div id="onglets_tutos" class="onglets_tutos">
      <ul>
          <li>
          <?php echo $this->Html->link('Tutoriel hors ligne',array("controller" => "ressources", "action" => "$targetLink", $this->data['Ressource']['id'], $this->data['Ressource']['slug'])); ?>
          </li>
          <li class="selected">
          <?php echo $this->Html->link('Edition',array("controller" => "ressources", "action" => "edit", $this->data['Ressource']['id'], $this->data['Ressource']['slug'])); ?>
          </li>
      </ul>
    </div>
<?php endif; ?>

<?php if($rang == "cours" OR $rang == "partie"): ?>

    <?php ($rang == "cours")? $titreLien = "": $titreLien = "sous-"; ?>
    <?php echo $this->Html->link("+ Ajouter une nouvelle ".$titreLien."partie", array('action'=> 'add', $this->data['Ressource']['id'], $this->data['Ressource']['slug']),array("class"=>"modifier")); ?>

    <br /><br />

    <table id="parties">
        <thead>
             <tr>
                <th style="text-align: center">Titre de la partie</th>
                <th style="text-align: center">Monter/Descendre</th>
                <th style="text-align: center">Actions</th>
             </tr>
         </thead>
         <tbody>
           <?php $i=1; foreach($allChildren as $child): $child = current($child); ?>
            <tr>

            <?php if($child['type'] == "partie"){
                echo '<td>'.$i.') '.$child['titre'].'</td>';
                $i++;
            }else{

                echo '<td>...'.$child['titre'].'</td>';
            } ?>      

                 <td style="text-align: center">
                    <?php echo $this->Html->image('fleche_haut.png', array(
                        "url"=> array("action"=>"monter", $child['id'],$child['slug'])
                    ));?> / 
                    <?php echo $this->Html->image('fleche_bas.png', array(
                        "url"=> array("action"=>"descendre", $child['id'], $child['slug'])
                    ));?>
                 </td>
                 <td style="text-align: center">  
                    <?php echo $this->Html->link($this->Html->image('editer.png')." Modifier", 
                            array("action"=>"edit", $child['id'], $child['slug']),
                            array("escape"=>false)); ?>
                    <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                         array("action"=>"delete", $child['id']),
                         array("title" =>"Supprimer cette partie", 'escape' => false),
                         "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
                    );?>
                 </td>
            </tr>
           <?php  endforeach; ?>
         </tbody>
     </table>


            <script>
                $(document).ready(function(){
                  $(".modifier").click(function () {                
                    page = ($(this).attr("href"));
                    $.ajax({
                      url: page,
                      cache: false,
                      success: function(html) {
                        afficher(html);
                     },
                        error:function(XMLHttpRequest, textStatus, errorThrows){
                        }
                    });
                    return false;
                  });
                });

             function afficher(data) {
                  $(".modalbox").empty();
                  $(".modalbox").append(data);
                }

            $(function() {		                        
                    $( ".modalbox" ).dialog({
                            autoOpen: false,
                            height: 500,
                            width: 600,
                            modal: true			
                    });

                    $( ".modifier" )
                            .button()
                            .click(function() {
                                    $( ".modalbox" ).dialog( "open" );
                            });
            });
            </script>

    <div class="modalbox"></div>

<?php endif; ?>


<?php echo $this->Form->create('Ressource', array('action' => 'edit')); ?>
<?php echo $this->Form->input('id'); ?>

    <?php if($rang == "partie"): ?>
        <?php echo $this->Form->input('type', array('type' => "hidden", 'value' => "partie")); ?>
    <?php endif; ?>

<?php if(empty($rang) || $rang == "cours"): ?>

<fieldset>

    <?php echo $this->Form->input('user_id', array('type' => "hidden", 'value' => $_SESSION['Auth']['User']['id'])); ?>
    <?php echo $this->Form->input('type', array('type' => "hidden", 'value' => "cours")); ?>

    <?php if($rang != "cours"): ?>
        <?php echo $this->Form->input('', array('label' => "Matière :", 'options' => $matieres, 'name'=> 'matieres', 'id'=> 'matieres', 'onChange'=> 'request(this)')); ?>
    
    
    <span id="loader" style="display: none;"><?php echo $this->Html->image("loader.gif", array( "alt"=>"loading")); ?></span>

		<select name="data[Ressource][parent_id]" id="RessourceParentId"></select>
    
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
                        document.getElementById("RessourceParentId").innerHTML = xhr.responseText;
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
 <?php echo $this->Form->input('licence', array('label' => "Licence :", "options"=> array(
            "Creative Commons" => "Creative Commons",
            "Autres" => "Autres")));?>
 
    <?php echo $this->Form->input('difficultlevel', array('label' => "Niveau de difficulté :", "options"=> array(
            "Facile" => "Facile",
            "Intermédiaire" => "Intermédiaire",
            "Difficile" => "Difficile")));?>
	<?php echo $this->Form->input('studytime', array('label' => "Temps d'apprentissage (en heures):"));?>
    <?php endif; ?>
</fieldset>

<?php endif; ?>	
	<?php echo $this->Form->input('titre', array('label' => "Titre du cours:"));?>
	
	<?php echo $this->Form->input('contenu', array('label' => "Introduction :"));?>
	
<?php echo $this->Form->end('Enregistrer'); ?>



<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
        
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',
                height : '520',
                theme_advanced_resizing_min_height : 520,
                theme_advanced_resizing_min_width : 910,
                plugins: 'inlinepopups,paste,emotions',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,emotions',
                theme_advanced_buttons2 : '',
                theme_advanced_buttons3 : '',
                theme_advanced_buttons4 : '',
                theme_advanced_toolbar_location:'top',
                theme_advanced_statusbar_location : 'bottom',
                theme_advanced_resizing : true,
                paste_remove_styles : true,
                paste_remove_spans :  true,
                paste_stip_class_attributes : "all",
                relative_urls : false,
                content_css : '<?php echo $this->Html->url('/css/wysiwyg.css'); ?>'
        });

<?php $this->Html->scriptEnd(); ?>