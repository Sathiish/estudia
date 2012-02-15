<?php echo $this->Form->create('Question', array('url'=> "/questions/repondre/$quizId/$nextQuestion")); ?>  
<?php echo $this->Form->input('question_id', array('type' => "hidden", "value"=>"$questionId"));?>
<?php $time = time(); ?>
<?php echo $this->Form->input('time', array('type' => "hidden", "value"=>"$time"));?>

<span class="question">
    <?php echo strip_tags($question['Question']['question'], '<a>'); ?>
</span>

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

<script>
$(document).ready(function(){
	$('.qcm-answer').each(function(i,el) {
		var $el = $(el),
			$input = $el.find('input'),
			$letter = $el.find('.answer-letter');
                        console.log($letter);
		
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
</script>