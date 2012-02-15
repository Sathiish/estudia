<h4>UN OUTIL DE <span class="bold vert">PARTAGE DE RESSOURCES</span> PEDAGOGIQUES //</h4>

<p>
<?php echo $this->Html->image('tutos/creation_quiz.jpg', array('alt' => 'picture','width'=>'233', 'height'=>'164',  'style'=>'float:left'))?>
  Vous recherchez <span class="bold vert">des supports d'entraînement pour votre classe</span>? ou Vous souhaitez créer des ressources en ligne à partager avec vos élèves? Notre module 
  de création de quiz vous permet de créer gratuitement et de mettre en forme des quiz d'entraînement et leurs corrigés. Ces exercices en ligne permettront une
évaluation simple, rapide et ciblée des connaissances de vos élèves. </p>

<p>Vous êtes étudiant <span class="bold vert">à la recherche d'exercices pour vos révisions</span> ? Les étudiants cherchant à s'entraîner et à évaluer leurs connaissances 
    trouveront dans la bibliothèque d'exercices tous les outils pour réviser efficacement et aller plus loin dans leur apprentissage.</p>



<h4>L’inscription est <span class="bold vert">rapide et gratuite</span> !</h4>

<h4>Elève ou enseignant, rejoignez dès à présent notre communauté pour créer vos propres cours et exercices ou consulter gratuitement notre bibliothèque collaborative 
    de ressources. </h4>

<button><?php echo $this->Html->link('Créer un compte', array("tutoriel"=>false, "controller"=>"users", "action" => "inscription")); ?></button>
<button><?php echo $this->Html->link('Voir un exemple de quiz', array("controller"=>"users", "action" => "inscription")); ?></button>	

