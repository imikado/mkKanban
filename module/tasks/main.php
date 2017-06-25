<?php 
class module_tasks extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('popup');
		$this->oLayout->color='#f3f6a8';
		
		//_root::setConfigVar('site.mode','prod');
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	
	public function _updateColumnTask(){
		$tData=json_decode($_POST['data']);
		
		$tActionAllow=array('move','updateOrder','refInSprint');
		
 		if($tData){
			foreach($tData as $oData){
				
				if(false==in_array($oData->action,$tActionAllow) ){
					continue;
				}
				
				$sAction=$oData->action;
				
				$this->$sAction($oData);
			
			
			}
		
		}
		
		
	}
	
	private function move($oData){		
		
		list($foo,$taskId)=explode('_',$oData->taskId);
		list($foo,$columnId)=explode('_',$oData->columnId);
		
		model_Tasks::getInstance()->move($taskId,$columnId);
		
		echo "move success";
	
	}
	private function updateOrder($oData){
		
		list($foo,$columnId)=explode('_',$oData->columnId);
		$tTasksList=explode(';',$oData->tasks);
		
		if($tTasksList){
			foreach($tTasksList as $i => $taskId){
				$oTask=model_Tasks::getInstance()->findById($taskId);
				if($oTask){
					$oTask->position=$i+1;
					$oTask->save();
				}
				
			}
		}
		echo "update success";
	}
	private function refInSprint($oData){		
		
		list($foo,$taskId)=explode('_',$oData->taskId);
		list($foo,$sprintId)=explode('_',$oData->sprintId);
		
		model_Tasks::getInstance()->refInSprint($taskId,$sprintId);
		
		echo "ref success";
	
	}
	 
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tTasks=model_Tasks::getInstance()->findAll();
		
		$oView=new _view('tasks::list');
		$oView->tTasks=$tTasks;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}
		
	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oTasks=new row_Tasks;
		
		$oView=new _view('tasks::new');
		$oView->oTasks=$oTasks;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
			
	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oTasks=model_Tasks::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('tasks::edit');
		$oView->oTasks=$oTasks;
		$oView->tId=model_Tasks::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
		
	
	
	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oTasks=model_Tasks::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('tasks::delete');
		$oView->oTasks=$oTasks;
		
		

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
			$oTasks=new row_Tasks;	
		}else{
			$oTasks=model_Tasks::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('title','description','complexity');
		foreach($tColumn as $sColumn){
			$oTasks->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oTasks->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('tasks::closePopupAndReload');
		}else{
			return $oTasks->getListError();
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
	
		$oTasks=model_Tasks::getInstance()->findById( _root::getParam('id',null) );
				
		$oTasks->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('tasks::list');
		
	}
		
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

