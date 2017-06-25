<?php 
class module_Columns extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('popup');
		$this->oLayout->color='#eee';
		
		//_root::setConfigVar('site.mode','prod');
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tColumns=model_Columns::getInstance()->findAll();
		
		$oView=new _view('Columns::list');
		$oView->tColumns=$tColumns;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}
		
	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oColumns=new row_Columns;
		
		$oView=new _view('Columns::new');
		$oView->oColumns=$oColumns;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
			
	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oColumns=model_Columns::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('Columns::edit');
		$oView->oColumns=$oColumns;
		$oView->tId=model_Columns::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
		
	
	
	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oColumns=model_Columns::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('Columns::delete');
		$oView->oColumns=$oColumns;
		
		

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
			$oColumns=new row_Columns;	
		}else{
			$oColumns=model_Columns::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('name','position');
		foreach($tColumn as $sColumn){
			$oColumns->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oColumns->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('tasks::closePopupAndReload');
		}else{
			return $oColumns->getListError();
		}
		
	}
	
	public function _closePopupAndReload(){
		die('<script>parent.closeMyPopup();parent.location.reload();</script>');
	}
	
	public function _closePopup(){
		die('<script>parent.closeMyPopup();</script>');
	}
	
	
	public function processDelete(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oColumns=model_Columns::getInstance()->findById( _root::getParam('id',null) );
				
		$oColumns->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('Columns::list');
		
	}
		
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

