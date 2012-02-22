<?php $this->Html->script('quiz/main.js',array('inline'=>false)); ?>
<?php echo $this->Html->css('quiz', null, array('inline' => false));?>

<?php $quiz=current($p); ?>

<div id="onglets_tutos" class="onglets_tutos">
  <ul>
      <li class="selected">
      <?php echo $this->Html->link('Quiz hors ligne',array("controller" => "quiz", "action" => "visualiser", $quiz['id'], $quiz['slug'])); ?></li>
      <li>
      <?php echo $this->Html->link('Edition',array("controller" => "quiz", "action" => "edit", $quiz['id'], $quiz['slug'])); ?></li>
  </ul>
</div>

<div>
<h1><?php echo $quiz['name']; ?></h1>

<p><?php echo $quiz['description']; ?></p>

<?php echo $this->Html->link('Commencer le quizz', array('', $quiz['id']), array('class' => 'button', 'onClick' => "return false;")) ?>

</div>

<?php $this->Html->script('jsMath/easy/load.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    jsMath.Process(document);
<?php $this->Html->scriptEnd(); ?>