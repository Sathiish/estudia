<?php

class Ressource extends AppModel {
    
        public $useTable = false;
//    var $displayField = 'titre';
//    
////    var $belongsTo = array('User');
////    var $hasMany = 'Quiz';
////        
//    var $actsAs = array('Tree', 'Containable');
//
//    var $validate = array(
//            'titre' => array(
//                    'rule'       => array('between', 3, 200),
//                    'required'   => true,
//                    'allowEmpty' => false,
//                    'message'    => "La ressource doit avoir un titre."
//            ),
//            'parent_id' => array(
//                'checkParadox' => array(
//                    'rule'    => 'checkParadox',
//                    'on'      => 'update',
//                    'message' => "Une catégorie ne peut pas devenir sa propre fille !"
//                )
//            )
//    );
//    
//    /**
//     * Retourne faux si l'id est égal au nouvel id parent
//     *
//     * @param array $data Données à valider, en provenance du formulaire.
//     * @return boolean Faux si id == parent_id, vrai sinon.
//     */
//    function checkParadox($data)
//    {
//            if(isset($this->data[$this->alias]['id']))
//            {
//                    return $data['parent_id'] != $this->data[$this->alias]['id'];
//            }
//            return true;
//    }
//    
//    function beforeSave($options = array()) {
//        $this->data['Ressource']['slug'] = strtolower(Inflector::slug($this->data['Ressource']['titre'], '-'));
//        
//        return true;
//    }
//
//    
//    /*
//     * Permet de lister toutes les matières
//     */
//    function getAllMatieres(){
//        $AllMatieres = $this->find('all', array(
//            "fields" => "id, titre, slug",
//            "conditions" => "parent_id = 0 AND etat = 1",
//            "order" => "titre ASC"
//        ));
//        
//        return $AllMatieres;
//    }
//    
//    /*
//     * Permet de récupérer le rang d'un enregistrement
//     * - matière
//     * - thème
//     * - cours
//     * - partie
//     * @param int $id
//     * @return string
//     */
//    function getRang($id){
//        $path = count($this->getPath($id, 'id'));
//        switch ($path){
//            case 1:
//                $rang = 'matiere';
//                break;
//            case 2:
//                $rang = 'theme';
//                break;
//            case 3:
//                $rang = 'cours';
//                break;
//            case 4:
//                $rang = 'partie';
//                break;
//            case 5:
//                $rang = 'sous-partie';
//                break;
//            default:
//                $rang = "";
//        }
//        
//        return $rang;
//    }
//    
//    function getCours($id){
//        $cours = $this->getPath($id, array('slug','id','titre'), 1);
//        
//        return $cours;
//    }
        
}
?>