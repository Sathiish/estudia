<?php
class MediasController extends AppController{
	
	public $components = array('Img'); 

	public function beforeFilter(){
		parent::beforeFilter(); 
		$this->layout = 'modal';
	}

	public function index($type, $post_id){
            //On choisit si c'est un quiz ou un cours
            if($type == "cours"){
                $target = "cour_id";
            }elseif($type == "quiz"){
                $target = "quiz_id";
            }elseif($type == "ressource"){
                $target = "ressource_id";
            }
                            
		if($this->request->is('post')){
			$data = $this->request->data['Media'];
			if(isset($data['url'])){
				$this->redirect(array('action'=>'show','?class=&alt=&src='.urlencode($data['url'])));
			}
			$dir = IMAGES.date('Y');
			if(!file_exists($dir))
				mkdir($dir,0777);
			$dir .= DS.date('m');
			if(!file_exists($dir))
				mkdir($dir,0777);
                        $dir .= DS.$type;
			if(!file_exists($dir))
				mkdir($dir,0777);
			$f = explode('.',$data['file']['name']); 
			$ext = '.'.end($f);  
			$filename = Inflector::slug(implode('.',array_slice($f,0,-1)),'-');
			// Sauvegarde en bdd
			$success = $this->Media->save(array(
				'name' => $data['name'],
				'url'  => date('Y').'/'.date('m').'/'.$type.'/'.$filename.$ext,
				$target => $post_id,
                                'user_id' => $this->Auth->user('id')
			));
			if($success){
				move_uploaded_file($data['file']['tmp_name'], $dir.DS.$filename.$ext);
				foreach(Configure::read('Media.formats') as $k=>$v){
					$prefix = $k;
					$size = explode('x',$v);
					$this->Img->crop( $dir.DS.$filename.$ext,$dir.DS.$filename.'_'.$prefix.'.jpg',$size[0],$size[1]); 
				}
			}else{
				$this->Session->setFlash("L'image n'est pas au bon format","notif",array('type'=>'error'));
			}
		}
		$d = array(); 
		$d['medias'] = $this->Media->find('all',array(
			'conditions' => array($target => $post_id)
		));
		$d['biblio'] = $this->Media->find('all',array(
			'conditions' => array('user_id' => $this->Auth->user('id'))
		));
		$d['formats'] = Configure::read('Media.formats'); 
		$this->set($d);
	}

	public function show($id=null,$format = ''){
		$d = array();
		if($this->request->is('post')){
			$this->set($this->request->data['Media']);
			$this->layout = false;
			$this->render('tinymce'); 
			return; 
		}
                if(is_numeric($id)){
			$this->Media->id = $id;  
			$media = current($this->Media->read());
			$d['src'] = Router::url('/img/'.$media['url'.$format]); 
			$d['alt'] = $media['name'];  
			$d['class'] = 'alignLeft';  
		}else{
			$d = $this->request->query; 
			$d['src'] = urldecode($d['src']); 
		}
		$this->set($d);
	}

	public function delete($id){
		$this->Media->id = $id;
		$file = $this->Media->field('url');
		unlink(IMAGES.DS.$file);
		$f = explode('.',$file); 
		$ext = '.'.end($f);  
		$file =implode('.',array_slice($f,0,-1));
		foreach(glob(IMAGES.DS.$file.'_*.jpg') as $v){
			unlink($v);
		}
		$this->Media->delete($id);
		$this->Session->setFlash("L'image a bien été supprimée","notif");
		$this->redirect($this->referer());
	}
        
	function admin_index($type, $post_id){
            $this->_isAdmin();
            
            //On choisit si c'est un quiz ou un cours
            if($type == "cours"){
                $target = "cour_id";
            }elseif($type == "quiz"){
                $target = "quiz_id";
            }
		if($this->request->is('post')){
			$data = $this->request->data['Media'];
			if(isset($data['url'])){
				$this->redirect(array('action'=>'show','?class=&alt=&src='.urlencode($data['url'])));
			}
			$dir = IMAGES.date('Y');
			if(!file_exists($dir))
				mkdir($dir,0777);
			$dir .= DS.date('m');
			if(!file_exists($dir))
				mkdir($dir,0777);
                        $dir .= DS.$type;
                        if(!file_exists($dir))
				mkdir($dir,0777);
			$f = explode('.',$data['file']['name']); 
			$ext = '.'.end($f);  
			$filename = Inflector::slug(implode('.',array_slice($f,0,-1)),'-');
			// Sauvegarde en bdd
			$success = $this->Media->save(array(
				'name' => $data['name'],
				'url'  => date('Y').'/'.date('m').'/'.$filename.$ext,
				'post_id'=> $post_id
			));
			if($success){
				move_uploaded_file($data['file']['tmp_name'], $dir.DS.$filename.$ext);
				foreach(Configure::read('Media.formats') as $k=>$v){
					$prefix = $k;
					$size = explode('x',$v);
					$this->Img->crop( $dir.DS.$filename.$ext,$dir.DS.$filename.'_'.$prefix.'.jpg',$size[0],$size[1]); 
				}
			}else{
				$this->Session->setFlash("L'image n'est pas au bon format","notif",array('type'=>'error'));
			}
		}
		$d = array(); 
		$d['medias'] = $this->Media->find('all',array(
			'conditions' => array($target => $post_id)
		));
		$d['formats'] = Configure::read('Media.formats'); 
		$this->set($d);
	}

	function admin_show($id=null,$format = ''){
            $this->_isAdmin();
		$d = array();
		if($this->request->is('post')){
			$this->set($this->request->data['Media']);
			$this->layout = false;
			$this->render('tinymce'); 
			return; 
		}
		if($id){
			$this->Media->id = $id;  
			$media = current($this->Media->read());
			$d['src'] = Router::url('/img/'.$media['url'.$format]); 
			$d['alt'] = $media['name'];  
			$d['class'] = 'alignLeft';  
		}else{
			$d = $this->request->query;
			$d['src'] = urldecode($d['src']); 
		}
		$this->set($d);
	}

	function admin_delete($id){
            $this->_isAdmin();
		$this->Media->id = $id;
		$file = $this->Media->field('url');
		unlink(IMAGES.DS.$file);
		$f = explode('.',$file); 
		$ext = '.'.end($f);  
		$file =implode('.',array_slice($f,0,-1));
		foreach(glob(IMAGES.DS.$file.'_*.jpg') as $v){
			unlink($v);
		}
		$this->Media->delete($id);
		$this->Session->setFlash("L'image a bien été supprimée","notif");
		$this->redirect($this->referer());
	}
        
        public function message(){
            
        }

}