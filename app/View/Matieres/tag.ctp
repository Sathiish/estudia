
<ul class="sommaire">

<?php foreach ($matieres as $matiere): ?>
    <li><?php echo $this->Html->link($matiere['Matiere']['name'], 
            array(
                "controller" => "themes", 
                "action" => "tag", 
                $matiere['Tag']['id'], 
                $matiere['Tag']['slug']
                )); ?></li>
<?php endforeach; ?>

</ul>

