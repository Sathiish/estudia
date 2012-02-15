<ul class="sommaire">
    <?php foreach($matieres as $k=>$v): ?>
    <li><?php echo $this->Html->link($v, array("controller" => "courtags", "action" => "view", $k, $tagId)); ?></li>
    <?php endforeach; ?>
</ul>