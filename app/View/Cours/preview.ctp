<div id="breadcrumbs">
        <?php echo $this->Html->link('Mes cours', array("controller" => "cours", "action" => "manager")); ?>
            >> <?php echo $p['Theme']['Matiere']['name'];?> 
            >> <?php echo $p['Theme']['name'];?>
            >> <?php echo $p['Cour']['name'];?>
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
            <p>Auteur: <?php echo $this->Html->link(ucfirst($p['User']['username']), array("controller" => "users", "action" => "index", $p['User']['username'])); ?></p>
            <p>Créé le <?php echo date("j M Y", strtotime($p['Cour']['created'])); ?></p>
        </div>
    </div>
</div>


<div id="cours">

   <h1><?php echo $p['Cour']['name']; ?></h1>

<div id="cours-intro">
    <?php echo $p['Cour']['contenu']; ?>
</div>
    
     <div class="cours plan">
 <span class="titre"><a href="#" id="toggleLink">Sommaire</a></span>

    <ul id="sommaire" class="sommaire">
      <?php foreach($p['Partie'] as $partie): 
        echo '<li>';
           echo $this->Html->link($partie['sort_order'].'. '.$partie['name'], "#p".$partie['id']); 
           echo '<ul>';
                foreach($partie['SousPartie'] as $sousPartie):
                    echo '<li style="margin-left:20px">';
                    echo $this->Html->link($partie['sort_order'].'.'.$sousPartie['sort_order'].'. '.$sousPartie['name'], "#sp".$sousPartie['id']);                
                    echo '</li>';
                endforeach;
           echo '</ul>';
        echo '</li>';
      endforeach; ?>
    </ul>


    

 
</div>

    <hr />
 
 <div>
        <?php foreach($p['Partie'] as $partie): 
                echo '<div id="p'.$partie['id'].'" style="margin-top:10px">';
                echo '<h2><a href="#" class="toggleLink">Partie '.$partie['sort_order'].': '.$partie['name'].'</a></h2>';
                echo '<div class="cours-intro">'.$partie['contenu'].'</div>';
                        foreach($partie['SousPartie'] as $sousPartie):
                            echo '<div id="sp'.$sousPartie['id'].'" class="souspartie">';
                                echo '<h3><a href="#" class="toggleLink">'.$sousPartie['sort_order'].'. '.$sousPartie['name'].'</a></h3>';
                                echo '<div>'.$sousPartie['contenu'].'</div>';
                            echo '</div>';
                        endforeach;
                echo '</div>';
            endforeach; ?>
    </div>
  
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