<div id="breadcrumbs">
        <?php echo $this->Html->link('Matière', array("controller" => "matieres", "action" => "index", 'cours'), array('title' => 'Toutes les matières')); ?>
        >> <?php echo $this->Html->link(strip_tags($path['Matiere']['name']), array("controller" => "cours", "action" => "theme", $path['Matiere']['id'], $path['Matiere']['slug'])); ?>
        >> <?php echo $this->Html->link(strip_tags($path['Theme']['name']), array("controller" => "cours", "action" => "view", $path['Theme']['id'], $path['Theme']['slug'])); ?>
        >> <?php echo strip_tags($c['Cour']['name']); ?>
</div>

<?php echo $this->Element('sharebar'); ?>
<?php echo $this->Element('sidebar'); ?>

<?php if(!empty($quizRelated)): ?>
    <div class="sidebar-bloc">
        <h3>Pour s'entraîner</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <ul style="margin: 0; list-style: none;">
                <?php foreach($quizRelated as $sug): ?>
                <li style="text-align: left"><?php echo $this->Html->link($sug['Quiz']['name'], array('controller' => 'quiz', 'action' => 'start', $sug['Quiz']['id'], $sug['Quiz']['slug'])); ?></li>
                <?php endforeach; ?>              
            </ul>
        </div>
    </div>
<?php endif; ?>

<?php if(!empty($coursRelated)): ?>
    <div class="sidebar-bloc">
        <h3>Pour aller plus loin</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        <div class="inside">
            <ul style="margin: 0; list-style: none;">
                <?php foreach($coursRelated as $sug): ?>
                <li style="text-align: left"><?php echo $this->Html->link($sug['Cour']['name'], array('action' => 'show', $sug['Cour']['id'], $sug['Cour']['slug'])); ?></li>
                <?php endforeach; ?>              
            </ul>
        </div>
    </div>
<?php endif; ?>

    <div class="sidebar-bloc">
        <h3>Notez ce cours</h3>
        <a href="" class="handlediv" title="Agrandir"></a>
        
        <div class="inside">
            <div id="note">
                <?php if(!empty($c['CourNote'])): ?>
                    <p>Note moyenne:  <?php if(ceil($c['Cour']['moyenne']) >=1) echo $this->Html->image(ceil($c['Cour']['moyenne']).'etoiles.png', array('alt' => 'note')). ' ('.$c['Cour']['moyenne']; ?>/5)</p>
                    <p>Votre note: <?php if(ceil($c['CourNote']['0']['note']) >=1) echo $this->Html->image(ceil($c['CourNote']['0']['note']).'etoiles.png'). ' ('.$c['CourNote']['0']['note']; ?>/5)</p>
                <?php else: ?>
                    <p>Avez-vous trouver ce cours intéressant? Clair? Notez-le afin de donner votre avis!</p>
                    <ul class="notes-echelle">
                        <li>
                                <label for="note01" title="Note&nbsp;: 1 sur 5"></label>
                                <input type="radio" name="notesA" id="note01" value="1" />
                        </li>
                        <li>
                                <label for="note02" title="Note&nbsp;: 2 sur 5"></label>
                                <input type="radio" name="notesA" id="note02" value="2" />
                        </li>
                        <li>
                                <label for="note03" title="Note&nbsp;: 3 sur 5"></label>
                                <input type="radio" name="notesA" id="note03" value="3" />
                        </li>
                        <li>
                                <label for="note04" title="Note&nbsp;: 4 sur 5"></label>
                                <input type="radio" name="notesA" id="note04" value="4" />
                        </li>
                        <li>
                                <label for="note05" title="Note&nbsp;: 5 sur 5"></label>
                                <input type="radio" name="notesA" id="note05" value="5" />
                        </li>
                    </ul>
               <?php endif; ?>
            </div>
            <div class="clr"></div>
        </div>
    </div>
  
</div>

<div id="cours">

    <div id="code">
        <img src="/img/fleche-lateral.png"/>
        <p class="cadre">Code web: <?php echo $c['Cour']['raccourci']; ?></p><div id="qrcode"></div>
        <p>Rendez-vous sur <a href="#">http://www.zeschool.com/code</a> pour saisir le code web ou scanner le QR code.</p>
    </div>

    <h1><?php echo $c['Cour']['name']; ?></h1>
<p style="margin-top:-10px; font-size: 12px;line-height: 35px">Par <?php echo $this->Html->link($c['User']['username'], array("controller" => "users", "action" => "index", $c['User']['username'])); ?>
            :: mis en ligne le <?php echo date("j M Y", strtotime($c['Cour']['created'])); ?>
            <span style="float:right">
                <?php if(ceil($c['Cour']['moyenne']) >=1) echo $this->Html->image(ceil($c['Cour']['moyenne']).'etoiles.png'); ?>
            </span>
</p>
<div id="cours-intro">
    <?php echo $c['Cour']['contenu']; ?>
</div>

 <div class="cours plan">
 <span class="titre"><a href="#" id="toggleLink">Plan du cours</a></span>

    <ul id="sommaire" class="sommaire">
      <?php foreach($c['Partie'] as $partie): 
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
        <?php foreach($c['Partie'] as $partie): 
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


<?php $this->Html->script('qrcode.min.js',array('inline'=>false)); ?>
<?php echo $this->Html->scriptStart(array('inline'=>false)); ?>
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
    
    $('#qrcode').qrcode({width: 90, height: 90, text: "<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/code/'.$c['Cour']['raccourci']; ?>"});
    
    $("ul.notes-echelle").addClass("js");

    $("ul.notes-echelle li").addClass("note-off");

    $("ul.notes-echelle li").mouseover(function() {
            $(this).nextAll("li").addClass("note-off");
            $(this).prevAll("li").removeClass("note-off");
            $(this).removeClass("note-off");
    });

    $("ul.notes-echelle").mouseout(function() {
            $(this).children("li").addClass("note-off");
            $(this).find("li input:checked").parent("li").trigger("mouseover");
    });
    
    $('ul.notes-echelle li input').click(function(){
    	var note = $(this).attr('value');  
    	var id = <?php echo $c['Cour']['id']; ?> 
    	$.ajax({
            type: 'GET',
            url: '/cours/note/'+id+'/'+note,
                        
/*            beforSend: function(){    
            	$('#poll').children().fadeOut();   
            },*/
            
            success: function(data){
            	//data = parseInt(data);
            	$('#note').html(data);
            }
            
        });
   });
    

});

<?php echo $this->Html->scriptEnd(); ?>