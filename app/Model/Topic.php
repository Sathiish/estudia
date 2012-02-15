<?php

class Topic extends AppModel{
    
    public $belongsTo = array('User', 'Forum');
    
    public $hasMany = 'Post';
    
    function beforeSave($options = array()) {
        parent::beforeSave($options); 
        if(!empty($this->data['Topic']['name'])){
            $this->data['Topic']['slug'] = strtolower(Inflector::slug($this->data['Topic']['name'], '-'));
        }
                
        return true;
    }
    
    function getActive($forum_id){
             $ForumActive =  $this->Forum->find('first', array(
                "conditions" => "Forum.id = $forum_id",
                "fields" => "Forum.id, Forum.name, Forum.slug",
                "recursive" => -1
             ));
             
             return $ForumActive;
    }
    
    public function increment($field, $id = null) {
        if (is_null($id)) {
          $id = $this->id;
        }
        return $this->updateAll(
          array($this->escapeField($field) => $this->escapeField($field) . '+1'),
          array($this->escapeField() => $id));
    }
    
    public function LastPost($username_last_post, $topic_id){          
        $this->id = $topic_id;
        return $this->saveField('username_last_post', $username_last_post);
    }
}
?>
