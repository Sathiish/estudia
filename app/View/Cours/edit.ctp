<?php echo $this->Html->css('form', null, array('inline' => false));?>
<?php //echo $this->Html->css('tour', null, array('inline' => false));?>
<?php //$this->Html->script('tour',array('inline'=>false)); ?>
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php $result = (isset($this->params->pass[1]))? "index": "message";?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',
                editor_deselector : "mceNoEditor",
                plugins: 'inlinepopups,paste,emotions,image, fullscreen',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,emotions, image,|, fullscreen',
                theme_advanced_buttons2 : '',
                theme_advanced_buttons3 : '',
                theme_advanced_buttons4 : '',
                theme_advanced_toolbar_location:'top',
                theme_advanced_statusbar_location : 'bottom',
                theme_advanced_resizing : true,
                width : '655',
                height : '350',
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
        
        $('#classement select#matieres').live('click', function(data){
                var value = $('select#matieres option:selected').val();
                var url = "/themes/selectbox/"+value;

                $("#classement-annuler").show();
                
                if(value != 0){
                    $("#AjoutMatiere").fadeOut();
                    $("#NewMatiere").val('');
                    $("#NewTheme").val('');
                    $("#AjoutTheme").fadeOut();  

                    $.get(url, function(data) {
                      $('#loader').show();
                      $('#ListeTheme').show();
                      $('#CourThemeId').html(data);
                      $('#loader').fadeOut();
                    });
                    
                    $('#classement select#CourThemeId').live('click', function(data){
                        var value2 = $('select#CourThemeId option:selected').val();
                        
                        if(value2 != 0){
                            $("#AjoutTheme").fadeOut();
                            $("#NewTheme").val('');
                        }else{
                            $("#AjoutTheme").fadeIn();
                        }
                    });
                    
                 }else{
                    $('#ListeTheme').fadeOut();
                    $("#AjoutMatiere").fadeIn();
                    $("#AjoutTheme").fadeIn();                  
                 }
        });
            
        <?php if(isset($this->data['Cour']['id'])): ?>
        jQuery(function(){
            $('.tag a').live('click',function(){
                var e = $(this);
                $.get(e.attr('href'));
                e.parent().fadeOut();
                return false;
            });

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
            });
                        
            $('#classement a#classement-button').live('click',function(){
                $("#matieres").show();
                $("#classement-button").hide();
                $("#classement-submit").show();
                $("#classement-annuler").show();
                                
                return false;
            });
            
            $('#classement a#classement-annuler').live('click',function(){
                $("#matieres").hide();
                $("#classement-annuler").hide();
                $("#classement-button").show();
                $("#classement-submit").hide();
                $("#ListeTheme").hide();
                $("#AjoutMatiere").fadeOut();
                $("#NewMatiere").val('');
                $("#NewTheme").val('');
                $("#AjoutTheme").fadeOut(); 
                
                return false;
            });
            
            $('a.ajax').live('click',function(){
                var e = $(this);
                var url = e.attr('href');
                $.get(url, function(data) {
                  e.parent().append(data);
                });
                
                return false;
            });
            
            $('a.handlediv').live('click',function(){
                event.preventDefault();
                var e = $(this).parent();
                e.find('div').slideToggle('');
            });
            
            
            //$('#help').live('click',function(){
           //console.log(window);
           //event.preventDefault();
               // $(window).load(function(){
                 //   $(this).joyride();
                //});
            //});
            
            
            /*$(window).load(function() {
                $(this).joyride({
                    'cookieMonster': true,         // true/false for whether cookies are used
                            // choose your own cookie name
                    'cookieDomain': false});
            });*/
        
            /* Exemple utilisation jquery + POST */
            $("#searchForm").submit(function(event) {

                /* stop form from submitting normally */
                event.preventDefault(); 

                /* get some values from elements on the page: */
                var $form = $( this ),
                    term = $form.find( 'input[name="s"]' ).val(),
                    url = $form.attr( 'action' );

                /* Send the data using post and put the results in a div */
                $.post( url, { s: term },
                  function( data ) {
                      var content = $( data ).find( '#content' );
                      $( "#result" ).empty().append( content );
                  }
                );
              });
            
        });
        <?php endif; ?>
        
        var isCtrl = false;$(document).keyup(function (e) {
        if(e.which == 17) isCtrl=false;
        }).keydown(function (e) {
            if(e.which == 17) isCtrl=true;
            if(e.which == 83 && isCtrl == true) {
                $('.submit input').click();
                return false;
         }
        });

<?php $this->Html->scriptEnd(); ?>

<div class="sidebar">

    <div id="help"><a href="#">Obtenir de l'aide sur cette page</a></div>
    
    <div class="sidebar-bloc">
        <h3>Classement</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div id="classement" class="inside">
            <?php echo $this->Form->create('Cour'); ?>
            
            <p><span id="Matiere" class="bold">Matière :</span> <span id="Matiere"><?php echo $this->data['Theme']['Matiere']['name']; ?></span>
                <?php echo $this->Form->input('', array('label' => "", 'type' => 'select','options' => $matieres, 
            'name'=> "data[Cour][matiere_id]", 'id'=> 'matieres', 'style' => 'display:none;')); ?></p>
                
                    <div id="AjoutMatiere" style="display:none" >
                        <label for="NewMatiere">Votre nouvelle matière:</label>
                        <input name="data[Matiere][name]" id="NewMatiere" type="text">
                    </div>
                
            
            <p><span class="bold">Thème :</span> <?php echo $this->data['Theme']['name']; ?></p>
            <span id="ListeTheme" style="display:none">
                <select name="data[Cour][theme_id]" id="CourThemeId"></select>
                <span id="loader" class="loader"><?php echo $this->Html->image("loader.gif", array( "alt"=>"loading")); ?></span>
            </span>
            
                    <div id="AjoutTheme" style="display:none" >
                        <label for="NewTheme">Votre nouveau thème:</label>
                        <input name="data[Theme][name]" id="NewTheme" type="text" />
                    </div>
            <p></p>
            
            
            <a href="" id="classement-button" class="modifier">Modifier</a>
            <div id="classement-submit" style="display:none;" >
                <input class="modifier" type="submit" value="Mettre à jour" />
            </div>
            
            <a href="" id="classement-annuler" class="modifier" style="display:none;">Annuler</a>
            
            <div class="clr"></div>
        </div>
    </div>
    
    <div class="sidebar-bloc">
        <h3>Difficulté</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside" id="difficult">
            <p class="label-inline">
                <?php echo $this->Form->radio('difficult', array(
                    "Facile" => "Facile", 
                    "Moyen" => "Moyen", 
                    "Difficile" => "Difficile"
                ), array('legend'=>''));?>  
            </p>
            
            <span id="loader-difficult" class="loader"><?php echo $this->Html->image("loader.gif", array( "alt"=>"loading")); ?></span>
            <input type="submit" class="modifier" value="Modifier" />

            <div class="clr"></div>
        </div>
    </div>
    
    <div class="sidebar-bloc">
        <h3>Niveaux</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <?php echo $this->Form->input('tags', array('label' => '','id' => 'TagTag'));?> 
            <?php echo $this->Autocomplete->autocomplete('TagTag','Tag/name',array('TagId'=>'id')); ?>
            <div id="tags">
                <?php foreach($relatedTags as $tag): ?>
                        <span class="etat tag">
                            <?php echo $tag['Tag']['name']; ?> 
                            <?php echo $this->Html->link("x", array("controller" => "courtags", "action" => "delete", $tag['CourTag']['id'])); ?> 
                        </span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="sidebar-bloc">
        <h3>Publier</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <?php echo $this->Html->link('Prévisualiser les modifications', array("controller" => "cours", "action" => "preview", $this->data['Cour']['id'], $this->data['Cour']['slug']), array('class' => 'modifier', 'target' => 'onBlank')); ?>
            <p><span class="bold">Statut :</span> 
                <?php if($this->data['Cour']['validation']){
                        if($this->data['Cour']['published']){
                                echo '<span class="waiting">En attente de dépublication</span>';
                            }
                            else{
                                echo '<span class="waiting">En attente de publication</span>';
                            }
                        }else{
                            if($this->data['Cour']['published']){
                                echo '<span class="published">Publié</span>';
                            }
                            else{
                                echo '<span class="unpublished">Non-publié</span>';
                            }                    
                        }
                ?></p>
            <?php 

                 if(!$this->data['Cour']['validation']){
                     if($this->data['Cour']['published']){
                        echo $this->Html->link('Demander la mise hors-ligne', 
                             array("action"=>"askforunreleased", $this->data['Cour']['id']),
                             array("title" =>"Demander la publication de ce quiz", 'class' => 'modifier', 'escape' => false),
                             "Une fois dépublié, ce quiz n'apparaitra plus en ligne. Vous pourrez toutefois demander sa publication à nouveau. Souhaitez-vous toujours demander sa dépublication dès maintenant ?"
                        );
                     }else{
                        echo $this->Html->link('Publier', 
                             array("action"=>"publier", $this->data['Cour']['id']),
                             array("title" =>"Demander la publication de ce quiz", 'class' => 'modifier', 'escape' => false),
                             "Une fois publié, pour modifier ce quiz, vous devrez d'abord demander sa dépublication. Souhaitez-vous toujours demander la publication dès maintenant ?"
                        );  
                     }      
                 }else{
                    echo $this->Html->link('Annuler la demande', 
                         array("action"=>"askforunreleased", $this->data['Cour']['id']),
                         array("title" =>"Demander la publication de ce quizz", 'class' => 'modifier', 'escape' => false),
                         "Une fois dépublié, ce quiz n'apparaitra plus en ligne. Vous pourrez toutefois demander sa publication à nouveau. Souhaitez-vous toujours demander sa dépublication dès maintenant ?"
                    );      
                 }
                 ?>
            <div class="clr"></div>
        </div>
    </div>
</div>
        
<div id="breadcrumbs">
        <?php echo $this->Html->link('Mes cours', array("controller" => "cours", "action" => "manager")); ?>
        >> <?php echo $this->data['Theme']['Matiere']['name']; ?> 
        >> <?php echo $this->data['Theme']['name']; ?> 
</div>
        
<div id="cours">
    <h1><?php echo $this->data['Cour']['name']; ?> 
        <?php echo $this->Html->link($this->Html->image('add.jpg'), array('controller' => 'parties', 'action'=> 'add', $this->data['Cour']['id'], $this->data['Cour']['slug']), array('escape' => false, 'title' => 'Ajouter une partie', 'class' => 'ajax')); ?>
        <a href="#" title="Modifier le titre" onClick="$('#cours-intro').fadeOut(); $('#cours-edit').fadeIn();"><?php echo $this->Html->image('editer.png'); ?></a></h1>
    <div id="cours-intro">
        <?php echo $this->data['Cour']['contenu']; ?> 
    </div>
    <div id="cours-edit" style="display:none;" class="content-bloc">
        <h3>Modifier le titre et l'introduction du cours</h3>
        <div class="inside">
            <form action="/cours/edit/<?php echo $this->data['Cour']['id']; ?>" method="post">
            <?php echo $this->Form->input('name', array('label' => "Titre du cours:"));?>
            <?php echo $this->Form->input('contenu', array('label' => "Vous pouvez saisir l'introduction de ce cours ici :"));?>      
            
            
            
            <a href="" onClick="$(this).parent().parent().slideUp(); $('#cours-intro'). fadeIn(); return false;" class="modifier">Annuler</a>
            <input type="submit" value="Mettre à jour" class="modifier"/><div style="height:35px;"></div>
        </form>
        
        </div>
    </div>
        
<?php //echo $this->Html->link('Ajouter une partie', array('controller' => 'parties', 'action'=> 'add', $this->data['Cour']['id'], $this->data['Cour']['slug']), array('class' => 'button')); ?>

    <?php if($this->data['Partie'] != array()): ?>

        <?php foreach($this->data['Partie'] as $c): ?>
        <h2>
        <?php echo $this->Html->link($this->Html->image('delete.jpg'), array('controller' => 'parties', 'action'=> 'delete', $c['id'], $c['slug']), array('escape' => false, 'title' => 'Supprimer cette partie')); ?>
        <?php echo $this->Html->link('Partie '.$c['sort_order'].': '.$c['name'], array(), array('onClick' => "$('#".$c['slug']."').slideToggle('slow'); return false;"));?>
        </h2>
    <div style="display:inline-block">
        <?php echo $this->Html->link($this->Html->image('add.jpg'), array('controller' => 'sousparties', 'action'=> 'add', $c['id'], $c['slug']), array('escape' => false, 'title' => 'Ajouter une sous-partie', 'class' => 'ajax')); ?>
        <?php echo $this->Html->link($this->Html->image('editer.png'), array("controller" => "parties", "action"=>"edit", $c['id'], $c['slug']),array("escape" => false, 'title' => 'Modifier', 'class' => 'ajax')); ?>
    </div>
    
    <div class="contenu" id="<?php echo $c['slug']; ?>" style="display:none">   
        <?php echo $c['contenu']; ?>
    </div>
    
        <?php foreach($c['SousPartie'] as $sousPartie): ?>
         <h3><?php echo $this->Html->link($this->Html->image('delete.jpg'), array('controller' => 'sousparties', 'action'=> 'delete', $sousPartie['id'], $sousPartie['slug']), array('escape' => false, 'title' => 'Supprimer cette sous-partie')); ?>
            <?php echo $sousPartie['sort_order'].') '.$sousPartie['name']; ?>
            
                <?php echo $this->Html->link($this->Html->image('editer.png'), array("controller" => "sousparties", "action"=>"edit", $sousPartie['id'], $sousPartie['slug']),array("escape" => false, 'title' => 'Modifier', 'class' => 'ajax')); ?>

         </h3>
 
             <?php endforeach; ?>
       <?php endforeach; ?>

    
<?php else: ?>
        <p>Vous n'avez ajouté aucunes parties à ce cours pour le moment. Cliquez ci-dessus pour créer des parties.</p>
<?php endif; ?>
        </div>

<div id="seo-settings" class="content-bloc">

    <h3>Optimisation pour les moteurs de recherche (optionnel)</h3>
    <a href="" class="handlediv" title="Agrandir"></a>
    <div class="inside">
        <div id="meta_description">
            <?php echo $this->Form->create('Cour'); ?>
        <p><strong></strong></p>
        <?php echo $this->Form->input('meta_description', array(
            'type' => 'textarea', 
            'class' => 'mceNoEditor', 
            'rows' => '2', 
            'style' => 'width:96%;',
            'label' => 'Meta Description: <span style="font-weight:normal">Informer les moteurs de recherche du contenu de ce cours (160 caractères maximum)</span>'
            )); ?>

        </div>

        <div id="meta_keywords">
            <?php echo $this->Form->input('meta_keywords', array(
                    'style' => 'width:630px;',
                    'label' => 'Meta Keywords: <span style="font-weight:normal">Comme &lt;meta&gt; description, &lt;meta&gt; keyword permettent d\'améliorer le référencement naturel</span>'
                    )); ?>
        </div>

        <input type="submit" class="modifier" value="Enregistrer"/>
        <div style="height:40px"></div>
    </div>
    
    
</div>