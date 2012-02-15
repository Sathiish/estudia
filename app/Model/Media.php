<?php
class Media extends AppModel{
	
	public $useTable = 'medias';
	public $validate = array(
		'url' => array(
			'rule' 		 => '/^.*\.(jpg|png|jpeg)$/',
			'allowEmpty' => true,
			'message'	 => "Le fichier n'est pas une image valide"
		)
	);

	public function beforeDelete(){
		$file = $this->field('url');
		unlink(IMAGES.DS.$file);
		$f = explode('.',$file); 
		$ext = '.'.end($f);  
		$file =implode('.',array_slice($f,0,-1));
		foreach(glob(IMAGES.DS.$file.'_*.jpg') as $v){
			unlink($v);
		}
		return true; 
	}

	public function afterFind($data){
		foreach($data as $k=>$d){
			if(isset($d['Media']['url']) && isset($d['Media']['type']) && $d['Media']['type'] == 'image'){
				$filename = implode('.',array_slice(explode('.',$d['Media']['url']),0,-1));
				foreach(Configure::read('Media.formats') as $kk=>$vv){
					$d['Media']['url'.$kk] = $filename.'_'.$kk.'.jpg';
				}
			}
			$data[$k] = $d;
		}
		return $data;
	}

}