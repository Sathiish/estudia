
<div class="clr"></div>
<div class="FBG">
    <div class="FBG_resize">
      <div class="click_blog"><?php echo $this->Html->image('test_img.gif', array('alt' => 'picture','width'=>'26', 'height'=>'24'))?> 

        <p>L'éducation est un progrès social... L'éducation est non pas une préparation à la vie, l'éducation est la vie même. <span style="color:#7b7b7b;font-weight:bold;">John Dewey</span></p>
        <div id="sprite">
            <ul>
                 <li><a id="mysprite1" href="http://www.facebook.com/pages/ZeSchool/176348839105396" target="_blank"></a></li>
                 <li><a id="mysprite2" href="http://twitter.com/#!/zeschool" target="_blank"></a></li>
                 <li><a id="mysprite3" href="mailto:contact@zeschool.fr"></a></li>
                 <li><a id="mysprite4" href="http://zeschool.fr/blog/feed" target="_blank"></a></li>
            
            </ul>
        </div>

        <div class="clr"></div>

      </div>
      <div class="blog">
        <h2>RESSOURCES<span></span></h2>
        <div class="clr"></div>
        <ul>
          <li><?php echo $this->Html->link('Par niveaux', array("controller" => "tags", "action" => "index")); ?></li>
          <li><?php echo $this->Html->link('Par matière', array("controller" => "matieres", "action" => "index")); ?></li>
          <li><?php echo $this->Html->link('Exercices', array("controller" => "quiz", "action" => "index")); ?></li>
        </ul>
      </div>
      <div class="blog">
        <h2>INFOS</h2>
        <div class="clr"></div>
        <ul>
          <li><?php echo $this->Html->link('Qui sommes-nous ?', array("controller" => "pages", "action" => "quisommesnous")); ?></li>
          <li><?php echo $this->Html->link('Mentions légales', array("controller" => "pages", "action" => "mentionslegales")); ?></li>
          <li><?php echo $this->Html->link('Contact', array("controller" => "contact", "action" => "index")); ?></li>
        </ul>
      </div>
      <div class="blog last">
        
        <div class="clr"></div>
      </div>
      <div class="clr"></div>
    </div>
  </div>
<div class="footer">
  <div class="footer_resize">
   
    <span class="right">© Copyright <a href="http://www.zeschool.com">ZeSchool</a>. Tous droits réservés.</span>
    <div class="clr"></div>
  </div>
</div>

<?php echo $scripts_for_layout ?>

</body>
</html>