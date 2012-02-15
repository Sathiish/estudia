
<ul class="sommaire">

<?php foreach ($matieres as $matiere): ?>
    <li><?php echo $this->Html->link($matiere['Matiere']['name'], 
            array(
                "controller" => "courtags", 
                "action" => "view", 
                $matiere['Matiere']['id'], 
                $matiere['Matiere']['slug']
                )); ?></li>
<?php endforeach; ?>

</ul>

