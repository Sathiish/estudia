<?php echo $this->Html->css('homepage', null, array('inline'=>false)); ?>
<?php echo $this->Html->css('jquery.uslider', null, array('inline'=>false)); ?>

<?php echo $this->Html->script('jquery.uslider.js', array('inline'=>false)); ?>

<div id="slider">
    <!--start slideshow -->
    <div class="flash_slider">
      <a href="">
        <ul id="uslider" class="uslider">
           <li><img src="/img/slideshow/slide1.gif" width="902" height="291"/></li>
           <li><img src="/img/slideshow/slide2.gif" width="902" height="291"/></li>
           <li><img src="/img/slideshow/slide3.gif" width="902" height="291" /></li>
        </ul>
      </a>
<script type="text/javascript">
$(document).ready(function(){
   $('#uslider').uSlider();
});
</script>

    </div>
    
    <div class="clr"></div>
    <?php echo $this->Html->image('simple_bg.gif', array('alt' => 'picture','width'=>'960', 'height'=>'25'))?>

    <div class="clr"></div>
    <div class="slide_blog"> <img src="/img/main_img_2.gif" alt="picture" width="40" height="37">
      <h3>Créer un cours<br><span>Créer, partager, diffuser</span></h3>
      <p>Pour compléter la base documentaire de votre e-classe, créez facilement votre cours en ligne en vous aidant des ressources partagées par les autres enseignants.
          <br />Améliorez ainsi les supports pédagogiques que vous partager avec vos élèves.
        </p>
        <button><?php echo $this->Html->link('En savoir plus', array("tutoriel"=>true, "controller"=>"pages", "action" => "tutoriel_cours")); ?></button></div>
    
    <div class="slide_blog"> <img src="/img/qcm.png" alt="picture" width="40" height="37">
      <h3>Créer un exercice<br><span>Entrainement simple et efficace</span></h3><p>En quelques clics, créez facilement vos QCM en ligne.<br />
        Personnalisez les questions et les corrigés de vos exercices ainsi que les paramètres de traitement des résultats de vos élèves.</p>
      <button><?php echo $this->Html->link('En savoir plus', array("tutoriel"=>true, "controller"=>"pages", "action" => "tutoriel_quiz")); ?></button></div>
    
    <div class="slide_blog last"> <img src="/img/main_img_3.gif" alt="picture" width="40" height="37">
    <h3>Créer votre e-classe<br><span>Un lieu de vie éducatif</span></h3>
        <p>Avec la e-classe, vous profitez d'un espace d'expression privé et interactif 
            pour l'édition, la diffusion et le partage de cours et d'exercices avec vos élèves.<br />
            Suivez, accompagnez et communiquez avec votre classe en toute simplicité !</p>
      <button><?php echo $this->Html->link('En savoir plus', array("tutoriel"=>true, "controller"=>"pages", "action" => "tutoriel_eclasse")); ?></button></div>
    
    <div class="clr"></div>

  </div>

<div class="clr"></div>