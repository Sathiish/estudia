<p>Auteur : <?php echo $quiz['User']['username']; ?>
<p>Thème : <?php echo $quiz['Ressource']['titre']; ?>

 
    <?php foreach($quiz['Question'] as $question): ?>
        <div>
            <?php echo $question['question'];?><br />
                <?php foreach($question['Answer'] as $answer): ?>
                    <div>
                        <?php echo $answer['name'];?>
                        <?php if($answer['correct']) echo " - Correct";?>
                    </div>
    <?php endforeach; ?>
            <?php echo $question['explanation'];?>
        </div>
    <?php endforeach; ?>
    
<p><?php 

    $titre = (!isset($unreleased))? "Publier": "Dépublier";
echo $this->Html->link("$titre ce quiz",$this->Html->url($link,true)); ?></p>