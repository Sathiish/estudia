<?php echo $this->Html->scriptStart(array('inline'=>false)); ?>

$(function(){
    $('#sharebar').each(function(){
        var parent = $(this).parent();
        var dTop = $(this).offset().top;
        var elem = $(this);
        var dw = $(document).width();
        var right = (dw - 990 - 84*2)/2;

        elem.css('right', right);
        
        
        $(window).scroll(function(){
            if($(window).scrollTop() > dTop){
                elem.stop().animate({top:parent.offset().top - 5}, 500);
            }else{
                elem.stop().animate({top:dTop}, 500);
            }
        });
        
        if($(window).scrollTop() > dTop){
        var scroll = $(window).scrollTop();
            elem.stop().animate({top:scroll}, 500);
        }
        
        $(window).resize(function() {
            var dw = $(document).width();
            var right = (dw - 990 - 84*2)/2;

            elem.css('right', right);
        });
    });
    
    $('#email a').live('click', function(){
        event.preventDefault();
        $('#sendEmail').toggle('slide');
        if($('#email.actif').length>0)
            $('#email').removeClass('actif');
        else
            $('#email').addClass('actif');
    });
    
    $('#fermer').live('click', function(){
        event.preventDefault();
        $('#email').removeClass('actif');
        $('#sendEmail').fadeOut();
    });
        
    $('#sendEmailForm').live('submit', function(){
        event.preventDefault();
        var email=$("#inputEmail").val();
        
        if(!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)){
            alert("Votre adresse email doit être de la forme nom@domaine.com");
            $('#inputEmail')[0].focus();
            return;
        }
        
        var post=$("#sendEmailForm").serialize();
        $.post("/cours/recommander/",post,function(){
            $("#sendEmailForm").hide();
            $("#sendEmailThanks").show();
            
            setTimeout("$('#sendEmail').fadeOut(); $('#email').removeClass('actif');$('#sendEmailForm').show();$('#sendEmailThanks').hide();",3000);
        });
    });

    $('#inputEmail').focus(function(){
        var value=$('#inputEmail').val();
        if(value=='Email du destinataire')
            $('#inputEmail').val('');
    });
    
    $('#inputEmail').blur(function(){
        var value=$('#inputEmail').val();
        if(value=='')
            $('#inputEmail').val('Email du destinataire');
    });

    $('a#favorisLink').live('click',function(){
        event.preventDefault();
        var e = $(this); 
        var url = e.attr('href');
        
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data){
                var parent = e.parent();
                var id = parent.attr('id');

                if(id == "favoris"){
                    parent.attr('id', 'favorisDelete');
                }else{
                    parent.attr('id', 'favoris');
                }

                $('body').append(data);
            }
            
        });
    });

});

<?php echo $this->Html->scriptEnd(); ?>


<div id="sharebar" style="top: 180px; right: 136px; ">
    <div id="topLink">
       <a href="" onClick="$(document).scrollTop(0); return false;" title="Remonter"></a>
    </div>  
        
    
       <?php if(empty($c['CourFavori'])):?>
    <div id="favoris">
       <?php echo $this->Html->link('', array('action' => 'favoris', $c['Cour']['id']), array('id' => 'favorisLink','title' => 'Ajouter à mes favoris'));?>
            </div>
       <?php else: ?>
        <div id="favorisDelete">
       <?php echo $this->Html->link('', array('action' => 'favoris', $c['Cour']['id']), array('id' => 'favorisLink','title' => 'Supprimer de mes favoris'));?>
                </div>
       <?php endif; ?>

    
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
    <a class="addthis_button_facebook" title="Partager sur Facebook"></a>
    <a class="addthis_button_twitter" title="Partager sur Twitter"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f50784a01d6aa08"></script>
<!-- AddThis Button END -->
    
    <div id="email">
        <a href="" title="Envoyer par email"></a> 
        <div id="sendEmail" style="display:none;">
                <a href="#" id="fermer" title="Fermer"></a>
                <form id="sendEmailForm">
                    <p>Envoyer par mail</p>
                        <input id="inputEmail" type="text" name="sendEmail" value="Email du destinataire">
                        <input id="id" type="hidden" name="id" value="<?php echo $c['Cour']['id'];?>">
                        <input id="name" type="hidden" name="name" value="<?php echo $c['Cour']['name'];?>">
                        <input id="url" type="hidden" name="url" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
                        <input type="submit" value="OK">
                </form>
                <div id="sendEmailThanks" style="display:none;">
                    <p>Votre email a bien été envoyé.</p>
                </div>
        </div>
    </div>
    
    <div id="print">
        <a href="JavaScript:print();" title="Imprimer"></a>
    </div>

</div>
