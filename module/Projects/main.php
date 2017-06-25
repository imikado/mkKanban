<?php 
class module_Projects extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tKProjects=model_Projects::getInstance()->findAll();
		
		$oView=new _view('Projects::list');
		$oView->tKProjects=$tKProjects;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}
		
	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oKProjects=new row_Projects;
		
		$oView=new _view('Projects::new');
		$oView->oKProjects=$oKProjects;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
			
	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oKProjects=model_Projects::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('Projects::edit');
		$oView->oKProjects=$oKProjects;
		$oView->tId=model_Projects::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
		
	
	
	
	
	

	private function processSave(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$iId=_root::getParam('id',null);
		if($iId==null){
			$oKProjects=new row_Projects;	
		}else{
			$oKProjects=model_Projects::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('title');
		foreach($tColumn as $sColumn){
			$oKProjects->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oKProjects->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('Projects::list');
		}else{
			return $oKProjects->getListError();
		}
		
	}
	
	
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

