<ul class="sommaire">
    <?php foreach($tags as $tag): $tag = $tag['Cour']; ?>
    <li><?php echo $this->Html->link($tag['name'], array("controller" => "courtags", "action" => "view", $tag['id'])); ?></li>
    <?php endforeach; ?>
</ul>
