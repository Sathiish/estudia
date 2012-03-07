<?php echo $this->Html->css('form', null, array('inline' => false));?>
<?php $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>

<?php $this->Html->scriptStart(array('inline'=>false)); ?>
        tinyMCE.init({
                mode : 'textareas',
                theme: 'advanced',
                editor_deselector : "mceNoEditor",
                plugins: 'inlinepopups,paste,emotions,fullscreen',
                entity_encoding : "raw",
                
                theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,emotions,|, fullscreen',
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
                relative_urls : false,
                content_css : '/css/wysiwyg.css'
        });
        
        function send_to_editor(content){
                var ed = tinyMCE.activeEditor;
                ed.execCommand('mceInsertContent',false,content); 
        }
        
        jQuery(function(){
            $('select#matieres').live('click', function(data){
                    var value = $('select#matieres option:selected').val();
                    var url = "/themes/selectbox/"+value;

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

                        $('select#CourThemeId').live('click', function(data){
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
        });


<?php $this->Html->scriptEnd(); ?>

<div class="sidebar">

    <div id="help"><a href="#">Obtenir de l'aide sur cette page</a></div>
    
    
</div>
        
<div id="breadcrumbs">
        <?php echo $this->Html->link('Mes cours', array("controller" => "cours", "action" => "manager")); ?>
        >> Créer un cours
</div>
        
<div id="cours">
    <h1>Créer un nouveau cours</h1>


            <?php echo $this->Form->create('Cour'); ?>
            <p><span id="Matiere" class="bold">Matière :</span>
                        <?php echo $this->Form->input('', array('label' => "", 'type' => 'select','options' => $matieres, 
                    'name'=> "data[Cour][matiere_id]", 'id'=> 'matieres')); ?></p>
                
            <div id="AjoutMatiere" style="display:none" >
                <label for="NewMatiere">Votre nouvelle matière:</label>
                <input name="data[Matiere][name]" id="NewMatiere" type="text">
            </div>
                
            <div id="ListeTheme">
                <select name="data[Cour][theme_id]" id="CourThemeId"></select>
                <span id="loader" class="loader"><?php echo $this->Html->image("loader.gif", array("alt"=>"loading")); ?></span>
            </div>
            
            <div id="AjoutTheme" style="display:none" >
                <label for="NewTheme">Votre thème n'est pas dans la liste? Pas de problèmes, il suffit de le créer:</label>
                <input name="data[Theme][name]" id="NewTheme" type="text" />
            </div>
            
            <?php echo $this->Form->input('name', array('label' => "Titre du cours:"));?>
            <?php echo $this->Form->input('contenu', array('label' => "Vous pouvez saisir l'introduction de ce cours ici :"));?>      
            

            <?php echo $this->Form->end('Créer'); ?>
            
            
            
            <div class="clr"></div>
        </div>

        </div>

