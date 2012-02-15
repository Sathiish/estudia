<?php

class Message extends AppModel {
    
    var $belongsTo = array(
        'UserExpediteur' => array(
                'className' => 'User',
                'foreignKey' => 'expediteur'
            ),
        'UserDestinataire' => array(
                'className' => 'User',
                'foreignKey' => 'destinataire'
            ),
    );

    function beforeSave($options = array()) {
        $this->data['Message']['slug'] = strtolower(Inflector::slug($this->data['Message']['sujet'], '-'));
        $this->data['Message']['expediteur'] = AuthComponent::user('id');
                
        //On recherche le dernier dernier fil de conversation pour récupérer son conversation_id et l'incrémenter si celui-ci est nul
        if($this->data['Message']['conversation_id'] == 0){
            $derniereConversation = $this->find('first', 
                            array(
                                'order' => array(
                                    'Message.conversation_id DESC'),
                                'fields' => array(
                                    'Message.conversation_id')
                            )
                    );
            $derniereConversation = $derniereConversation['Message']['conversation_id'];
            $this->data['Message']['conversation_id'] = $derniereConversation + 1;
        }
        else{
            $conversation_id = $this->data['Message']['conversation_id'];
            $sujet = $this->find('first', 
                            array(
                                'condition' => "Message.conversation_id = $conversation_id",
                                'order' => array(
                                    'Message.created DESC'),
                                'fields' => array(
                                    'Message.sujet')
                            )
                    );
            $sujet = $sujet['Message']['sujet']; 
            $this->data['Message']['sujet'] = $sujet;
        }
        return true;
    }
    
}
?>
