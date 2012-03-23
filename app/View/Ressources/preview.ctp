<div id="breadcrumbs">
        <?php echo $filAriane['Theme']['Matiere']['Classe']['name']; ?> 
        >> <?php echo $filAriane['Theme']['Matiere']['name']; ?> 
        >> <?php echo $filAriane['Theme']['name']; ?> 
        >> <?php echo $filAriane['Ressource']['name']; ?> 
</div>

<?php echo $this->Element('sharebar'); ?>
<?php echo $this->Element('sidebar'); ?>

<div class="sidebar-bloc">
        <h3>Pour s'entraîner</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        
        <div class="inside">
            
        </div>
    </div>
    
    <div class="sidebar-bloc">
        <h3>Pour aller plus loin</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        
        <div class="inside">
            <p>Auteur: <?php echo $this->Html->link(ucfirst($r['User']['username']), array("controller" => "users", "action" => "index", $r['User']['username'])); ?></p>
            <p>Créé le <?php echo date("j M Y", strtotime($r['Ressource']['created'])); ?></p>
        </div>
    </div>
</div>


<div id="cours">

<h1><?php echo $r['Ressource']['name']; ?></h1>
 
<div><?php echo $r['Ressource']['content']; ?></div>
  
</div>



<?php $this->Html->script('jsMath/easy/load.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    jsMath.Process(document);
    
$(function(){
    $('#toggleLink').live('click',function(){
        event.preventDefault();
        $('#sommaire').slideToggle('slow');
    });
    
    $('.toggleLink').live('click',function(){
        event.preventDefault();
        var e = $(this).parent().parent(); 
        var id = e.attr('id');
        
        $('#'+ id).find('div').slideToggle('');
    });
    
    $('a.handlediv').live('click',function(){
        event.preventDefault();
        var e = $(this).parent();
        e.find('div').slideToggle('');
    });  

});
<?php $this->Html->scriptEnd(); ?>