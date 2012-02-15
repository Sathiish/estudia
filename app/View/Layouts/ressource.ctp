<!DOCTYPE html>
<html lang="fr">
<head>
<title><?php echo $title_for_layout?></title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php echo $this->Html->css('ressource/style'); ?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<?php echo $scripts_for_layout ?>

</head>
<body>



<?php echo $content_for_layout ?>

        </div>
    </div>
</div>

<!-- Add a footer to each displayed page -->
<div class="clr"></div>
<div class="FBG">
    <div class="FBG_resize">
      <div class="click_blog"><?php echo $this->Html->image('test_img.gif', array('alt' => 'picture','width'=>'26', 'height'=>'24'))?> 

        <p>L'éducation est un progrès social... L'éducation est non pas une préparation à la vie, l'éducation est la vie même. <span style="color:#7b7b7b;font-weight:bold;">John Dewey</span></p>
        <div class="rss"> 
             <a href="http://twitter.com/#!/zeschool" target="_blank"><?php echo $this->Html->image('rss_4.gif', array('alt' => 'picture','width'=>'16', 'height'=>'16', 'class' => 'floated'))?></a>
             <a href="mailto:contact@zeschool.fr"><?php echo $this->Html->image('rss_3.gif', array('alt' => 'picture','width'=>'16', 'height'=>'16', 'class' => 'floated'))?></a>
             <a href="http://www.facebook.com/zeschool" target="_blank"><?php echo $this->Html->image('rss_2.gif', array('alt' => 'picture','width'=>'16', 'height'=>'16', 'class' => 'floated'))?></a>
             <a href="http://zeschool.fr/blog/feed" target="_blank"><?php echo $this->Html->image('rss_1.gif', array('alt' => 'picture','width'=>'16', 'height'=>'16', 'class' => 'floated'))?></a>
             Suivez-nous !
        </div>

        <div class="clr"></div>

      </div>
      <div class="blog">
        <h2>RESSOURCES<span></span></h2>
        <div class="clr"></div>
        <ul>
          <li><a href="#">Par classe</a></li>
          <li><a href="#">Par matière</a></li>
          <li><a href="#">Exercices</a></li>
        </ul>
      </div>
      <div class="blog">
        <h2>EXAMEN ET +</h2>
        <div class="clr"></div>
        <ul>
          <li><a href="#">Révision du bac</a></li>
          <li><a href="#">Concours</a></li>
          <li><a href="#">Le centre d'orientation</a></li>
        </ul>
      </div>
      <div class="blog">
        <h2>Miscelaneous</h2>
        <div class="clr"></div>
        <ul>
          <li><a href="#">Découvrir le site</a></li>
          <li><a href="#">L'abonnement sur ZeSchool</a></li>
          <li><a href="#">FAQ</a></li>
        </ul>
      </div>
      <div class="blog last">
        <h2>Contact</h2>
        <p>Tél: 01 83 74 09 17<br>
          Site: <a href="#">www.zeschool.fr</a><br>
          Email: <a href="#">contact@zeschool.fr</a></p>
        <div class="clr"></div>
      </div>
      <div class="clr"></div>
    </div>
  </div>
<div class="footer">
  <div class="footer_resize">
    <p class="leftt"><a href="#">Mentions légales</a> <a href="http://zeschool.fr/blog/qui-sommes-nous/" target="_blank">Qui sommes-nous ?</a> <a href="http://zeschool.fr/blog/contact">Contact</a> <a href="#">FAQ</a></p>
    <p class="right">© Copyright <a href="http://www.zeschool.com">ZeSchool</a>. Tous droits réservés.</p>
    <div class="clr"></div>
</div>
</body>
</html>