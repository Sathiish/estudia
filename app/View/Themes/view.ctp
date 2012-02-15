<ul class="sommaire">

<?php foreach ($themes as $theme): ?>
    <li><?php echo $this->Html->link($theme['Theme']['name'], 
            array(
                "controller" => "cours", 
                "action" => "view", 
                $theme['Theme']['id'], 
                $theme['Theme']['slug']
                )); ?></li>
<?php endforeach; ?>

</ul>