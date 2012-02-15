<ul class="sommaire">

<?php foreach ($cours as $c): ?>
    <li><?php echo $this->Html->link($c['Cour']['name'], 
            array(
                "controller" => "cours", 
                "action" => "show", 
                $c['Cour']['id'], 
                $c['Cour']['slug']
                )); ?></li>
<?php endforeach; ?>

</ul>
