<?php echo $this->Html->css('media', null, array('inline' => false));?>

<div class="media">
    <div id="menu-media">
        <ul>
            <li><a href="#import">Importer</a></li>
            <li><a href="#web">Depuis le web</a></li>
            <li><a href="#bibliotheque">Bibliothèque</a></li>
        </ul>
    </div>

    <div id="bloc">
        <div id="import">
            <?php echo $this->Form->create('Media',array('type'=>'file')); ?>
                <?php echo $this->Form->input('name',array('label'=>"Nom de l'image :")); ?>
            <div id="droparea">
                <p>Déposez vos fichiers (jpg/png) ici</p>
        		<span class="or">ou</span>
                <?php echo $this->Form->input('file',array('label'=>'', "type"=>"file")); ?>
            </div>
            <?php echo $this->Form->end('Ajouter', array('id' => 'uploader')); ?>
            
            <div id="filelist">
            </div>
            
        </div>

        <div id="web">
            <?php echo $this->Form->create('Media'); ?>
                <?php echo $this->Form->input('url',array('label'=>"URL de l'image :")); ?>
            <?php echo $this->Form->end('Insérer'); ?>
        </div>

        <div id="bibliotheque">
            <?php 

            if(!isset($this->params->pass[1])){
                echo "<p>Vous devez tout d'abord créer le contenu avant de pouvoir lui ajouter des images. L'ajout d'image se fera en cliquant sur cette même icône.</p>";
                die();    
            } ?>

            <table>
                <tr>
                    <th class="first">Image</th>
                    <th>Nom</th>
                    <th class="last">Actions</th>
                </tr>
                <?php foreach ($medias as $k => $v): $v = current($v); ?>
                <tr>
                    <td><?php echo $this->Html->image($v['url'],array('style'=>'max-width:200px')); ?></td>
                    <td><?php echo $v['name']; ?></td>
                    <td>
                            <?php foreach($formats as $kk=>$vv): ?>
                                    <?php echo $this->Html->link("Image ".$vv."px",array('action'=>'show',$v['id'],$kk)); ?> <br>
                            <?php endforeach; ?>
                            <?php echo $this->Html->link("Image originale",array('action'=>'show',$v['id'])); ?> <br>
                            <?php echo $this->Html->link("Supprimer",array('action'=>'delete',$v['id']),null,'Voulez vraiment supprimer l\'image'); ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>

    </div>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<!--<script type="text/javascript" src="/js/plupload/plupload.js"></script>
<script type="text/javascript" src="/js/plupload/plupload.flash.js"></script>
<script type="text/javascript" src="/js/plupload/plupload.html5.js"></script>
<script type="text/javascript" src="/js/media.js"></script>-->
<script>

jQuery(function($){
    $('.media').each(function(){
        var current = null;
        current = $(this).find('a:first').attr('href');
        $(this).find('a[href="'+current+'"]').addClass('active');
        $(current).siblings().hide();

        $(this).find('a').click(function(){
           var link = $(this).attr('href'); 
           if(link != current){
               e = $(this).parent().parent().children().children();
               e.each(function(){
                $(this).removeClass('active');
               });
               $(this).addClass('active');
               $(link).show().siblings().hide();
               current = link;
           }
           return false;
        });
    });
});
</script>