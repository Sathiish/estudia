<?php echo $this->Html->css('quiz', null, array('inline' => false));?>
<?php $this->Html->script('quiz/main.js',array('inline'=>false)); ?>


<?php $nbreQuestion = count($quizz); ?>

<?php $i = 1; ?>
<?php   if($i <= $nbreQuestion){ ?>

    
    <?php echo $this->Form->create('Question', array('url'=> "/questions/answer/$quizId")); ?>  

    <?php foreach ($quizz as $q): ?>
<?php $questionId =  $q['Question']['id']; ?>
<div id="quiz<?php echo $questionId; ?>">
                <span class="question"><?php echo strip_tags($q['Question']['question'], '<a>'); ?></span>

                        <?php $options = array(); $j=1; ?>
                        <?php foreach ($q['Answer'] as $o): ?>
                            <?php $options[$o['id']] = $o['name']; $j++; ?>
                        <?php endforeach; ?>

    <div class="reponse"><?php echo $this->Form->radio('answer_id',$options, array('separator' => '<br />','legend'=>false, 'name'=>"answer_id[$questionId]", 'escape'=>false)); ?></div>


</div>
    <?php endforeach; ?>
    <?php echo $this->Form->end('Suivant'); ?>


<?php   }else{ ?>
    
<p>Il n'y a plus de question</p>
<?php   }
