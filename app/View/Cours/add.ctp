<h1>Créer un nouveau cours</h1>


<?php echo $this->Form->create('Cour'); ?>



<div class="label-inline">
            <?php echo $this->Form->input('', array('label' => 'Matière: ', 'type' => 'select', 'options' => $matieres, 
        'name'=> "data[Cour][matiere_id]", 'id'=> 'matieres')); ?></div>

<div id="AjoutMatiere" style="display:none" >
    <label for="NewMatiere">Votre nouvelle matière:</label>
    <input name="data[Matiere][name]" id="NewMatiere" type="text">
</div>

<div class="label-inline"><?php echo $this->Form->input('classe_id', array('label' => 'Niveau: ')); ?></div>

<div  class="label-inline" id="ListeTheme">
    <label for="CourThemeId">Thème:</label>
    <select name="data[Cour][theme_id]" id="CourThemeId"></select>
    <span id="loader" class="loader"><?php echo $this->Html->image("loader.gif", array("alt"=>"loading")); ?></span>
</div>

<div id="AjoutTheme" style="display:none" >
    <label for="NewTheme">Votre thème n'est pas dans la liste? Pas de problèmes, il suffit de le créer:</label>
    <input name="data[Theme][name]" id="NewTheme" type="text" />
</div>

<?php echo $this->Form->input('name', array('label' => "Titre du cours:"));?>
    
            

<?php echo $this->Form->end('Créer'); ?>



