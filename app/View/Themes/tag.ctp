<ul class="sommaire">
    <?php foreach($themes as $theme): ?>
    <li><?php echo $this->Html->link($theme['Theme']['name'], array("controller" => "cours", "action" => "tag", $theme['CourTag']['tag_id'], $theme['Tag']['slug'])); ?></li>
    <?php endforeach; ?>
</ul>