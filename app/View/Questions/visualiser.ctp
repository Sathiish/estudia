<?php $question= $p; ?>

<div id="breadcrumbs">
	<?php echo $this->Html->link("Mes quiz", array("controller" => "quiz", "action" => "manager"), array("title" => "Voir tous mes quiz"));?>
            >> <?php echo $this->Html->link(strip_tags($question['Quiz']['name']), array("controller" => "quiz", "action" => "edit", $question['Quiz']['id']), array("title" => "Quiz"));?>
            >> <?php echo strip_tags($question['Question']['question']); ?>
</div>

<div id="onglets_tutos" class="onglets_tutos">
  <ul>
      <li class="selected">
      <?php echo $this->Html->link('Quiz hors ligne',array("controller" => "questions", "action" => "visualiser", $question['Question']['id'])); ?></li>
      <li>
      <?php echo $this->Html->link('Edition',array("controller" => "questions", "action" => "edit", $question['Question']['id'])); ?></li>
  </ul>
</div>
      
<?php echo $this->Form->create('Question'); ?>  

<?php $time = time(); ?>
<?php echo $this->Form->input('time', array('type' => "hidden", "value"=>"$time"));?>



<div class="question">
    <?php echo strip_tags($question['Question']['question'], '<a>'); ?>
</div>

    <?php $options = array(); $j=1; ?>
    <?php foreach ($question['Answer'] as $o): ?>
        <?php $options[$o['id']] = $o['name']; $j++; ?>
    <?php endforeach; ?>

    <?php foreach ($options as $k=>$v): ?>
        <div class="qcm-answer">
            <label for="QuestionAnswerId<?php echo $k; ?>"><?php echo $v; ?>
            <input type=radio name="data[Question][answer_id]" id="QuestionAnswerId<?php echo $k; ?>" value="<?php echo $k; ?>"/>
            <span class="rep answer-letter"></span>
            
            </label>
        </div>
    <?php endforeach; ?>


    <div class="qcm-answer">
    <?php //echo $this->Form->radio('answer_id',$options, array('separator' => '</div><div class="qcm-answer">','legend'=>false, 'escape'=>false, 'style' => 'display:none')); ?>
</div>

<?php echo $this->Form->end('Question Suivante'); ?>


<?php $this->Html->script('jsMath/easy/load.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    jsMath.Process(document);
    
    $(document).ready(function(){
	$('.qcm-answer').each(function(i,el) {
		var $el = $(el),
			$input = $el.find('input'),
			$letter = $el.find('.answer-letter');
		
		$letter.text('').addClass((i+1));
		$input.hide();
		
		$el.click(function(event) {
			event.preventDefault();
			$input.attr('checked','checked');
			$el.parent().find('.checked').removeClass('checked');
			$letter.addClass('checked');
		});
	});
});
<?php $this->Html->scriptEnd(); ?>