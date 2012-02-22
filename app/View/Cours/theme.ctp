<ul class="sommaire">

<?php foreach ($cours as $c): ?>
    <li><?php echo $this->Html->link($c['Theme']['name'], 
            array(
                "controller" => "cours", 
                "action" => "view", 
                $c['Theme']['id'], 
                $c['Theme']['slug']
                )); ?></li>
<?php endforeach; ?>

</ul>
