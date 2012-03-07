<div class="label-inline">
    <?php $matiere = $this->requestAction('/matieres/mliste'); ?>
    <?php echo $this->Form->input('matiere', array('type' => 'select', 'label' => 'Matière', 'options' => $matiere)); ?>
</div>