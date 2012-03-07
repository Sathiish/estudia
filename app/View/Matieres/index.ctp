<h1>Les <?php echo $model; ?> classés par matière</h1>

<?php foreach ($matieres as $matiere): $matiere = current($matiere); ?>

<div class="box">
    
     <span class="count"><?php echo $this->Html->link($matiere["count_published_$model"]." $model", array(
                        "controller" => $model, 
                        "action" => "theme", 
                        $matiere['id'], 
                        $matiere['slug']
                        )); ?></span>
                            
    <span class="image">
        <?php echo $this->Html->link($this->Html->image('/img/matiere/'.$matiere["slug"].'.png'), 
                array(
                    "controller" => $model, 
                    "action" => "theme", 
                    $matiere['id'], 
                    $matiere['slug']
                    ),
                array(
                    'escape' => false
                )); ?>
    </span>
   
    <h3><?php echo $this->Html->link($matiere['name'], array(
                "controller" => $model, 
                "action" => "theme", 
                $matiere['id'], 
                $matiere['slug']
               )); ?></h3>


</div>
<?php endforeach; ?>