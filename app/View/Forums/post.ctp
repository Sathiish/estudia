    <div class="titre"><span>Les matières de la bibliothèque</span></div>
    
    <?php echo $topicActive['Topic']['name']?><br />
    <?php echo $topicActive['Topic']['created']?><br />
    <?php echo $topicActive['Topic']['content']?><br /><br />

    <?php foreach($posts as $post): $post = current($post); ?>

        <div>
            <div>
                <div><?php echo $post['content'];?></div>
                <div><?php echo $post['created'];?></div>

            </div>

        </div>
    <?php endforeach; ?>
