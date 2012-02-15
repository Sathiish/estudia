<?php echo $this->Html->css('form', null, array('inline' => false));?>
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php $result = (isset($this->params->pass[1]))? "index": "message";?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',               
                plugins: 'inlinepopups,paste,emotions,image',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,emotions, image',
                theme_advanced_buttons2 : '',
                theme_advanced_buttons3 : '',
                theme_advanced_buttons4 : '',
                theme_advanced_toolbar_location:'top',
                theme_advanced_statusbar_location : 'bottom',
                theme_advanced_resizing : true,
                width : '675',
                height : '400',
                paste_remove_styles : true,
                paste_remove_spans :  true,
                paste_stip_class_attributes : "all",
                image_explorer : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>$result, "cours", $this->request->data['Cour']['id'])); ?>',
                image_edit : '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'show')); ?>',
                relative_urls : false,
                content_css : '/css/wysiwyg.css'
        });
        
        function send_to_editor(content){
                var ed = tinyMCE.activeEditor;
                ed.execCommand('mceInsertContent',false,content); 
        }
        
        <?php if(isset($this->data['Cour']['id'])): ?>
        jQuery(function(){
            $('.tag a').live('click',function(){
                var e = $(this);
                $.get(e.attr('href'));
                e.parent().fadeOut();
                return false;
            })

            $('.TagTag a').live('click',function(){
                var e = $(this);
                var page = <?php echo $this->data['Cour']['id']; ?>;
                var url = e.attr('href')+'/'+page;
                $.get(url, function(data) {
                  $('#tags').html(data);
                  $("#TagTag").attr('value', '');
                  $("#ul_TagTag").hide();
                });

                return false;
            })
        });
        <?php endif; ?>
        

<?php $this->Html->scriptEnd(); ?>

<?php echo $this->Form->create('Cour', array('controller' => 'cours', 'action' => 'edit')); ?>

<?php $display = ""; ?>
<?php if(isset($this->data['Theme'])): ?>
<div id="breadcrumbs">
        <?php echo $this->Html->link('Mes cours', array("controller" => "cours", "action" => "manager")); ?>
        >> <?php echo $this->data['Theme']['Matiere']['name']; ?> 
        >> <?php echo $this->data['Theme']['name']; ?> - <a href="" onClick='$("#display").show(); return false;'>Modifier</a>
        <?php $display = "display:none"; ?>
</div>
        
<div id="onglets_tutos" class="onglets_tutos">
  <ul>
      <li>
      <?php echo $this->Html->link('Tutoriel hors ligne',array("controller" => "cours", "action" => "visualiser", $this->data['Cour']['id'], $this->data['Cour']['slug'])); ?></li>
      <li class="selected">
      <?php echo $this->Html->link('Edition',array("controller" => "cours", "action" => "edit", $this->data['Cour']['id'], $this->data['Cour']['slug'])); ?></li>
  </ul>
</div>
        
        <?php echo $this->Html->link('Ajouter une partie', array('controller' => 'parties', 'action'=> 'add', $this->data['Cour']['id'], $this->data['Cour']['slug']), array('class' => 'button')); ?>

<?php if($parties != array()): ?>

<table class="manager">
   <thead>
     <tr>
        <th class="first" style="width: 490px">Cours</th>
        <th>Déplacer</th>
        <th class="last" style="width:100px;">Actions</th>
     </tr>
     </thead>
     <tbody>
     <?php foreach($parties as $cours_info): $c = current($cours_info); ?>
        <tr>
             <td><?php echo $this->Html->link($c['sort_order'].') '.$c['name'], array("controller" => "parties", "action" => "visualiser", $c['id'], $c['slug']));?><br />

             <?php if($c['validation']){
                    if($c['public']){
                        echo '<span class="etat en_attente">En attente de dépublication</span>';
                    }
                    else{
                        echo '<span class="etat en_attente">En attente de publication</span>';
                    }
                }else{
                    if($c['public']){
                        echo '<span class="etat publie">Publié</span>';
                    }
                    else{
                        echo '<span class="etat non_publie">Non-publié</span>';
                    }                    
               
                }
                ?></td>
              <td style="vertical-align: middle;">
                <?php echo $this->Html->image('fleche_haut.png', array(
                    "url"=> array("controller" => "parties", "action"=>"monter", $c['id'])
                ));?> / 
                <?php echo $this->Html->image('fleche_bas.png', array(
                    "url"=> array("controller" => "parties", "action"=>"descendre", $c['id'])
                ));?>
             </td>
             <td style="vertical-align: middle;">
             <?php if(!($c['public']) AND !($c['validation'])): ?>    
             <?php echo $this->Html->link($this->Html->image('editer.png'), array("controller" => "parties", "action"=>"edit", $c['id'], $c['slug']),array("escape" => false)); ?>
             <?php echo $this->Html->link($this->Html->image('supprimer.png'), 
                     array("controller" => "parties", "action"=>"delete", $c['id']),
                     array("title" =>"Supprimer cette", 'escape' => false),
                     "Etes-vous certain de vouloir définitivement supprimer ce cours ?"
             );?>
             <?php endif; ?>
             <?php 
             
             if(!$c['validation']){
                 if($c['public']){
                    echo $this->Html->link('<span class="etat action">Dépublier</span>', 
                         array("action"=>"askforunreleased", $c['id']),
                         array("title" =>"Demander la publication de ce quizz", 'escape' => false),
                         "Une fois dépublié, ce quiz n'apparaitra plus en ligne. Vous pourrez toutefois demander sa publication à nouveau. Souhaitez-vous toujours demander sa dépublication dès maintenant ?"
                    );
                 }else{
                    echo $this->Html->link('<span class="etat action">Publier</span>', 
                         array("action"=>"askforreleased", $c['id']),
                         array("title" =>"Demander la publication de ce quizz", 'escape' => false),
                         "Une fois publié, pour modifier ce quiz, vous devrez d'abord demander sa dépublication. Souhaitez-vous toujours demander la publication dès maintenant ?"
                    );  
                 }
                 
             
             }
             ?></td>
         </tr>
     <?php endforeach; ?>
     </tbody>
 </table>

<?php else: ?>
    <p>Vous n'avez ajouté aucunes parties à ce cours pour le moment. Cliquez ci-dessus pour créer des parties.</p>
<?php endif; ?>
        
<?php endif; ?>
        
<div id="display" style="<?php echo $display; ?>">

    <?php echo $this->Form->input('', array('label' => "Matière :", 'type' => 'select','options' => $matieres, 
        'name'=> "data[Cour][matiere_id]", 'id'=> 'matieres', 'onChange'=> 'request(this)')); ?>
        
    <div id="ajout-matiere" style="display:none">
        <?php echo $this->Form->input('newmatiere', array("type"=> "text",'name' => "data[Matiere][name]",
            'label' => 'Si vous ne trouvez pas votre matière dans la liste ci-dessus, vous pouvez soumettre un nom de matière ici: '));?>
    </div>
    <span id="loader" style="display: none;"><?php echo $this->Html->image("loader.gif", array( "alt"=>"loading")); ?></span>

    <div id="choix-theme" style="display:none">
	<select name="data[Cour][theme_id]" id="CourThemeId" onChange="newtheme(this)"></select>
    </div>
    
    <div id="ajout-theme" style="display:none">
        <?php echo $this->Form->input('newtheme', array( "type"=> "text", 'name' => "data[Theme][name]",
            'label' => 'Si vous ne trouvez pas votre thème dans la liste ci-dessus, vous pouvez soumettre un nom de thème ici: '));?>
    </div>
    
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

            if(value != 0){
                $("#choix-theme").show();
                $("#choix-theme").attr('name', 'data[Cour][Theme][name]');
                $("#ajout-matiere").attr('name', '').hide();

                xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                                document.getElementById("CourThemeId").innerHTML = xhr.responseText;
                                document.getElementById("loader").style.display = "none";
                        } else if (xhr.readyState < 4) {
                                document.getElementById("loader").style.display = "inline";
                        }
                };

                xhr.open("POST", "/cours/selectbox", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("matieres=" + value);
            }else{
                $("#ajout-matiere").attr('name', 'data[Matiere][name]').show();
                $("#ajout-theme") .attr('name', 'data[Theme][name]').show();
                //$("#choix-theme").attr('value', '').hide();
                //$("#CourNewtheme").value="";
            }
    }

    function newtheme(oSelect) {
            var value = oSelect.options[oSelect.selectedIndex].value;

            if(value == ""){
                $("#ajout-theme").show();
            }else{
                $("#ajout-theme").hide();

            }
    }
    
        </script>   
</div> 
        <hr />

<?php echo $this->Form->input('name', array('label' => "Titre du cours:"));?>
<?php echo $this->Form->input('contenu', array('label' => "Vous pouvez saisir l'introduction de ce cours ici :"));?>

        <?php if(isset($this->data['Cour']['id'])): ?>
        <hr />
    <div id="tags">
        <?php foreach($relatedTags as $tag): ?>
                <span class="etat tag">
                    <?php echo $tag['Tag']['name']; ?> 
                    <?php echo $this->Html->link("x", array("controller" => "courtags", "action" => "delete", $tag['CourTag']['id'])); ?> 
                </span>
        <?php endforeach; ?>
    </div>
<?php echo $this->Form->input('tags', array('label' => "Saisissez les différents niveaux concernés et cliquer dessus dès qu'ils apparaissent:", 'id' => 'TagTag'));?> 
<?php echo $this->Autocomplete->autocomplete('TagTag','Tag/name',array('TagId'=>'id')); ?>
        <?php endif; ?>
        
        <hr />
        
<?php echo $this->Form->end('Enregistrer'); ?>