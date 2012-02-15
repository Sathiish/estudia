<ul class="sommaire">
    <?php foreach($c as $theme): ?>
    <li><?php echo $this->Html->link($theme['Theme']['name'], array("controller" => "courtags", "action" => "view", $theme['Theme']['id'], $this->params->pass['1'])); ?></li>
    <?php endforeach; ?>
</ul>

<?php //$c = current($c); ?>
<?php debug($c); ?>
