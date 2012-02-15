<?php

class Forum extends AppModel{
    
    public $belongsTo = array('User', 'Category');
    
    public $hasMany = 'Topic';
    
    function beforeSave($options = array()) {
        $this->data['Forum']['slug'] = strtolower(Inflector::slug($this->data['Forum']['name'], '-'));
        
        return true;
    }
    
    public function increment($field, $id = null) {
        if (is_null($id)) {
          $id = $this->id;
        }
        return $this->updateAll(
          array($this->escapeField($field) => $this->escapeField($field) . '+1'),
          array($this->escapeField() => $id));
    }
    
    public function decrement($field, $id = null) {
        if (is_null($id)) {
          $id = $this->id;
        }
        return $this->updateAll(
          array($this->escapeField($field) => $this->escapeField($field) . '-1'),
          array($this->escapeField() => $id));
    }
    
    public function LastTopic ($forum_id, $name_last_topic, $last_topic_id){          
        $this->id = $forum_id;
        $this->saveField('last_topic', $last_topic_id);
        $this->saveField('name_last_topic', $name_last_topic);
        
        return true;
    }

}
?>
