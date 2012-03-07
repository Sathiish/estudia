<h1>Les thèmes en <?php echo strtolower($matiere['Matiere']['name']); ?></h1>

<?php foreach ($cours as $c): ?>
    <div class="box">
        
    <span class="count"><?php echo $this->Html->link($c['Theme']["count_published_cours"]." cours", array(
                        "controller" => "cours", 
                        "action" => "view", 
                        $c['Theme']['id'], 
                        $c['Theme']['slug']
                        )); ?></span>
                            
    <span class="image">
        <?php echo $this->Html->link($this->Html->image('/img/matiere/'.$c['Theme']["slug"].'.png'), 
                array(
                    "controller" => "cours", 
                    "action" => "view", 
                    $c['Theme']['id'], 
                    $c['Theme']['slug']
                    ),
                array(
                    'escape' => false
                )); ?>
    </span>
   
    <h3><?php echo $this->Html->link($c['Theme']['name'], 
            array(
                "controller" => "cours", 
                "action" => "view", 
                $c['Theme']['id'], 
                $c['Theme']['slug']
                )); ?></h3>
    
    </div>
<?php endforeach; ?>
