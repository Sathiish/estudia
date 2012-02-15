<?php

class Post extends AppModel{
    
    public $belongsTo = array('User', 'Topic');
    
    function getActive($topic_id){
        $TopicActive = $this->Topic->find('first', array(
            "conditions" => "Topic.id = $topic_id",
            "fields" => "Topic.id, Topic.name, Topic.slug, Topic.content, Topic.forum_id, Topic.created, User.id, User.username, Forum.id, Forum.name, Forum.slug",
            "recursive" => 0
         ));
        
        return $TopicActive;
    }
}
?>
