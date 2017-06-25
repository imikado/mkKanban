<?php 
class module_default extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		$this->project_id=_root::getParam('project_id',1);
	}
	
	public function _index(){
		
	
		$tColumn=model_Columns::getInstance()->findAllByProject($this->project_id);
		
		$tTask=model_Tasks::getInstance()->findAllByProject($this->project_id);
		
		$tSprints=model_Sprints::getInstance()->findAllByProject($this->project_id);
		
		$tTaskInSprints=model_Tasks::getInstance()->findAllInSprintsByProject($this->project_id);
		
		$oProject=model_Projects::getInstance()->findById($this->project_id);
		
		
		$oView=new _view('default::index');
		$oView->oProject=$oProject;
		
		$oView->tColumn=$tColumn;
		$oView->tTask=$tTask;
		$oView->project_id=$this->project_id;
	    
		$this->oLayout->add('main',$oView);
		
		$oView=new _view('default::sprints');
		$oView->project_id=$this->project_id;
		$oView->tSprints=$tSprints;
		$oView->tTaskInSprints=$tTaskInSprints;
		
		$this->oLayout->add('main',$oView);
	}
	
	private function redirect($sNav_){
		_root::redirect($sNav_,array('project_id'=>$this->project_id));
	}
	
	public function _addColumn(){
		model_Columns::getInstance()->addColumn(_root::getParam('project_id'),'new column');
		
		$this->redirect('default::index');
	}
	
	public function _addTask(){
		
		model_Tasks::getInstance()->addTask(_root::getParam('column_id'),'new task');
		
		$oColumn=model_Columns::getInstance()->findById(_root::getParam('column_id'));
		
		$this->project_id=$oColumn->project_id;
		
		$this->redirect('default::index');
	}
	
	public function _addSprint(){
		model_Sprints::getInstance()->addSprint(_root::getParam('project_id'),'new sprint');
		
		$this->redirect('default::index');
	}
	
	public function after(){
		$this->oLayout->show();
	}
}
