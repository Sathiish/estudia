
<div class="clr"></div>
<div id="FBG">
    <div class="FBG_resize">
      <div class="click_blog">
        <p style="margin-top:-10px;color:#fff;margin-left:70px">L'éducation est un progrès social... L'éducation est non pas une préparation à la vie, l'éducation est la vie même. John Dewey</p>
        

        <div class="clr"></div>

      </div>
        <img class="footer_border" src="/img/footer_border.gif" alt="border"/>
      <div class="blog">
        <img src="/img/ressource.png" alt="ressources"/>
        <div class="clr"></div>
        <ul>
          <li><?php echo $this->Html->link('Cours', array("controller" => "matieres", "action" => "index", "cours")); ?></li>
          <li><?php echo $this->Html->link('QCM', array("controller" => "matieres", "action" => "index", "quiz")); ?></li>
          <li><?php echo $this->Html->link('Classes', '#', array('onclick' => "alert('A venir très prochainement'); return false;")); ?></li>
        </ul>
      </div>
      <div class="blog">
        <img src="/img/infos.png" alt="infos"/>
        <div class="clr"></div>
        <ul>
          <li><?php echo $this->Html->link('Qui sommes-nous ?', array("controller" => "pages", "action" => "quisommesnous")); ?></li>
          <li><?php echo $this->Html->link('CGU', array("controller" => "pages", "action" => "cgu")); ?></li>
          <li><?php echo $this->Html->link('Contact', array("controller" => "contact", "action" => "index")); ?></li>
        </ul>
      </div>

        <img class="footer_border2" src="/img/footer_border.gif" alt="border"/>

              <div class="blog last">
           <img src="/img/followus.png" alt="réseaux sociaux"/>
        <div class="clr"></div>
        <div>
            <ul id="sprite">
                 <li class="facebook"><a href="http://www.facebook.com/pages/ZeSchool/176348839105396" target="_blank">     </a></li>
                 <li class="twitter"><a href="http://twitter.com/#!/zeschool" target="_blank"></a></li>
                 <li class="email"><a href="mailto:contact@zeschool.fr"></a></li>
                 <li class="rss"><a href="http://zeschool.fr/blog/feed" target="_blank"></a></li>
            
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