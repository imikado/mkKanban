<?php 
class module_Sprints extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('popup');
		$this->oLayout->color='#def0f4';
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tKSprints=model_Sprints::getInstance()->findAll();
		
		$oView=new _view('Sprints::list');
		$oView->tKSprints=$tKSprints;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}
		
	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oKSprints=new row_kSprints;
		
		$oView=new _view('Sprints::new');
		$oView->oKSprints=$oKSprints;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
			
	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oKSprints=model_Sprints::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('Sprints::edit');
		$oView->oKSprints=$oKSprints;
		$oView->tId=model_Sprints::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}
		
	
	
	public function _show(){
		$oKSprints=model_Sprints::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('Sprints::show');
		$oView->oKSprints=$oKSprints;
		
		

		$this->oLayout->add('main',$oView);
	}
	
	public function _planning(){
	
		$this->oLayout->setLayout('template1');
		
		$oSprint=model_Sprints::getInstance()->findById(_root::getParam('id'));
		
		$tTaskInSprint=model_Tasks::getInstance()->findAllBySprint(_root::getParam('id'));
		$iTotalInSprint=0;
		if($tTaskInSprint){
			foreach($tTaskInSprint as $oTask){
				$iTotalInSprint+=$oTask->complexity;
			}
		}
		$oStartdate=new Datetime($oSprint->startdate);
		$oEnddate=new Datetime($oSprint->enddate);
		
		$oInterval=date_diff($oStartdate,$oEnddate);
		$nbJSprint=$oInterval->format('%d');
		
		$nbJourOuvre=0;
		
		$oCalculDate=clone $oStartdate;
		for($i=0;$i<$nbJSprint;$i++){
			if(false==in_array($oCalculDate->format('w'),array('0','6')) ){
				$nbJourOuvre++;
			}
			$oCalculDate->add(new DateInterval('P1D'));
		}
		
		$productivity=$iTotalInSprint/$nbJourOuvre;
		
		$tTaskOutSprint=model_Tasks::getInstance()->findAllOutSprint(_root::getParam('id'));
		$iTotalOutSprint=0;
		if($tTaskOutSprint){
			foreach($tTaskOutSprint as $oTask){
				$iTotalOutSprint+=$oTask->complexity;
			}
		}
		$nbJtoSolde=ceil($iTotalOutSprint/$productivity);
		
		
		$nbDay=0;
		$oLastDate=clone $oEnddate;
		while($nbDay<$nbJtoSolde){
			
			if(false==in_array($oLastDate->format('w'),array('0','6'))){
					
				$nbDay++;
			}
			
			$oLastDate->add(new DateInterval('P1D'));
		}
		
		//$oLastDate->add(new DateInterval('P'.$nbSolde.'D'));
		
		
	
	
		$oView=new _view('Sprints::planning');
		$oView->oSprint=$oSprint;
		$oView->iTotalInSprint=$iTotalInSprint;
		$oView->iTotalOutSprint=$iTotalOutSprint;
		$oView->oLastDate=$oLastDate;
		$oView->nbJourOuvreSprint=$nbJourOuvre;
		$oView->nbDayJouvrePrev=$nbDay;

		$this->oLayout->add('main',$oView);
		
		plugin_debug::addSpy('out',$iTotalOutSprint);
	}
		
	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oKSprints=model_Sprints::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('Sprints::delete');
		$oView->oKSprints=$oKSprints;
		
		

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
			$oKSprints=new row_kSprints;	
		}else{
			$oKSprints=model_Sprints::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('title','startdate','enddate');
		foreach($tColumn as $sColumn){
			$oKSprints->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oKSprints->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('tasks::closePopupAndReload');
		}else{
			return $oKSprints->getListError();
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
	
		$oKSprints=model_Sprints::getInstance()->findById( _root::getParam('id',null) );
				
		$oKSprints->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('Sprints::list');
		
	}
		
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

