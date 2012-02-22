<?php $this->Html->script('quiz/main.js',array('inline'=>false)); ?>
<?php echo $this->Html->css('quiz', null, array('inline' => false));?>

<?php $quiz=current($quiz); ?>
<div>
<p>Vous vous apprêtez à démarrer le quiz intitulé <?php echo $quiz['name']; ?></p>

<?php echo $quiz['description']; ?>

<?php echo $this->Html->link('Commencer le quizz', array('controller' => 'questions', 'action' => 'repondre', $quiz['id']), array('class' => 'button')) ?>

</div>

<?php $this->Html->script('jsMath/easy/load.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    jsMath.Process(document);
<?php $this->Html->scriptEnd(); ?>