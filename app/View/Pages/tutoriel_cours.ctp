<h4>UN OUTIL DE <span class="bold violet">PARTAGE DE RESSOURCES</span> PEDAGOGIQUES //</h4>

<p>
<?php echo $this->Html->image('tutos/creation_cours.gif', array('alt' => 'picture','width'=>'261', 'height'=>'164',  'style'=>'float:left'))?>
    Notre module de création de cours, assisté pas à pas, vous permet de créer gratuitement et de mettre en forme un contenu pédagogique. A noter 
    qu’il est possible d’utiliser des cours déjà rédigés et mis en forme en faisant simplement un copier/coller d’une page web ou d’un 
    document Word.</p>

<p><span class="bold violet">Vous disposez d’un savoir que vous souhaitée faire partager au monde ?</span> Alors vous pouvez créer vos propres ressources sous forme de 
    cours, et le soumettre afin que celui-ci soit visible par tous les internautes. Les rédacteurs de contenus pédagogiques ne sont pas 
    forcément des professeurs, mais ces contenus répondent toujours aux mêmes critères de qualité: le cours doit-être structuré, 
    compréhensible et écrit dans un français irréprochable.</p>

<h4>Découvrez ici <span class="bold violet">comment créer votre cours</span> en quelques clics //</h4>

<p class="tuto_ecrit"><span class="bold violet">1 -</span> Une fois connecté à votre compte, rendez-vous dans la rubrique « mes cours »</p>
 
<?php echo $this->Html->image('tutos/image1.gif', array('alt' => 'picture','width'=>'445', 'height'=>'116',  'style'=>'float:right;'))?>
<div class="clr"></div>

<p class="tuto_ecrit"><span class="bold violet">2 -</span> Ensuite, cliquez sur le bouton « créer un nouveau cours »</p>
<?php echo $this->Html->image('tutos/image2.gif', array('alt' => 'picture','width'=>'445', 'height'=>'258',  'style'=>'float:right;'))?>
<div class="clr"></div>

<p class="tuto_ecrit"><span class="bold violet">3 -</span> Remplissez le formulaire d’informations sur votre cours, en lui attribuant : un thème (chaque matière est prédéfinie et est 
    constituée d’un ensemble de thèmes), un niveau de difficulté, un temps d’apprentissage indicatif pour l’élève, et un bien sûr un titre. 
    Vous avez aussi la possibilité de rédiger une introduction pour votre cours, ce qui permettra aux autres membres d’avoir un aperçu 
    rapide du contenu de  votre cours. Une fois le formulaire rempli, cliquez sur « enregistrer »</p> 
  <?php echo $this->Html->image('tutos/image3.gif', array('alt' => 'picture','width'=>'445', 'height'=>'322',  'style'=>'float:right;'))?>
<div class="clr"></div>

<p class="tuto_ecrit"><span class="bold violet">4 –</span> Ce nouveau cours apparait maintenant dans la liste de vos cours, il est prêt à être complété : cliquez sur « gérer les parties ».</p> 
   <?php echo $this->Html->image('tutos/image4.gif', array('alt' => 'picture','width'=>'445', 'height'=>'317',  'style'=>'float:right;'))?>
<div class="clr"></div>

<p class="tuto_ecrit"><span class="bold violet">5 –</span> Cliquez ensuite sur « ajouter une nouvelle partie » pour compléter votre cours. Remplissez le formulaire avec le titre et le 
    contenu de votre partie, puis cliquez sur « enregistrer cette partie ».Renouvelez cette opération à chaque fois que vous souhaiterez ajouter une partie à votre cours.
</p>
   <?php echo $this->Html->image('tutos/image5.gif', array('alt' => 'picture','width'=>'445', 'height'=>'386',  'style'=>'float:right;'))?>
<div class="clr"></div>

<p class="tuto_ecrit">A chaque fois que vous ajouter une partie, celle-ci apparait dans la structure de votre cours. Vous pouvez à votre guise monter, descendre, modifier ou supprimer une partie.</p>
   <?php echo $this->Html->image('tutos/image6.gif', array('alt' => 'picture','width'=>'445', 'height'=>'359',  'style'=>'float:right;'))?>
<div class="clr"></div>


<h4>L’inscription est <span class="bold violet">rapide et gratuite</span> !</h4>

<h4>Elève ou enseignant, rejoignez dès à présent notre communauté pour créer vos propres cours et exercices ou consulter gratuitement notre bibliothèque collaborative 
    de ressources. </h4>

<button><?php echo $this->Html->link('Créer un compte', array("tutoriel"=>false, "controller"=>"users", "action" => "inscription")); ?></button>
<button><?php echo $this->Html->link('Voir un exemple de cours', array("tutoriel"=>false,"controller"=>"ressources", "action" => "show", 23)); ?></button>
