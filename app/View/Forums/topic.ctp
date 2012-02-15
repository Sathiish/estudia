    <div class="titre"><span>Les matières de la bibliothèque</span></div>
    
    <?php foreach($topics as $topic): $topic = current($topic); ?>

        <div>
            <div>
                <div><?php echo $this->Html->link($topic['name'], array('action'=> 'post', $topic['id'], $topic['slug']));?></div>

            </div>

        </div>
    <?php endforeach; ?>
