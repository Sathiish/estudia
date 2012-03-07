
<div class="clr"></div>
<div id="FBG">
    <div class="FBG_resize">
      <div class="click_blog">
        <p><?php echo $this->Html->image('test_img.gif', array('alt' => 'picture','width'=>'26', 'height'=>'24'))?> 
L'éducation est un progrès social... L'éducation est non pas une préparation à la vie, l'éducation est la vie même. <span class="auteur">John Dewey</span></p>
        

        <div class="clr"></div>

      </div>
      <div class="blog">
        <h2>RESSOURCES<span></span></h2>
        <div class="clr"></div>
        <ul>
          <li><?php echo $this->Html->link('Cours', array("controller" => "matieres", "action" => "index", "cours")); ?></li>
          <li><?php echo $this->Html->link('Quiz', array("controller" => "matieres", "action" => "index", "quiz")); ?></li>
          <li><?php echo $this->Html->link('Par niveaux', '#', array('onclick' => "alert('A venir très prochainement'); return false;")); ?></li>
        </ul>
      </div>
      <div class="blog">
        <h2>INFOS</h2>
        <div class="clr"></div>
        <ul>
          <li><?php echo $this->Html->link('Qui sommes-nous ?', array("controller" => "pages", "action" => "quisommesnous")); ?></li>
          <li><?php echo $this->Html->link('CGU', array("controller" => "pages", "action" => "cgu")); ?></li>
          <li><?php echo $this->Html->link('Contact', array("controller" => "contact", "action" => "index")); ?></li>
        </ul>
      </div>
      <div class="blog last">
        
        <h2>SUIVEZ-NOUS!</h2>
        <div class="clr"></div>
        <div id="sprite">
            <ul>
                 <li><a id="mysprite1" href="http://www.facebook.com/pages/ZeSchool/176348839105396" target="_blank"></a></li>
                 <li><a id="mysprite2" href="http://twitter.com/#!/zeschool" target="_blank"></a></li>
                 <li><a id="mysprite3" href="mailto:contact@zeschool.fr"></a></li>
                 <li><a id="mysprite4" href="http://zeschool.fr/blog/feed" target="_blank"></a></li>
            
            </ul>
        </div>
      </div>
      <div class="clr"></div>
    </div>
    
    <div class="footer">
      <div class="footer_resize">

        <span class="right">© Copyright <a href="http://www.zeschool.com">ZeSchool</a>. Tous droits réservés.</span>
        <div class="clr"></div>
      </div>
    </div>
  </div>


<?php echo $scripts_for_layout ?>

</body>
</html>