<?php
class model_Tasks extends abstract_model{
	
	protected $sClassRow='row_Tasks';
	
	protected $sTable='kTasks';
	protected $sConfig='kanban';
	
	protected $tId=array('id');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE id=?',$uId );
	}
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable);
	}
	
	public function findAllByProject($project_id_){
		
		return $this->findManySimple('SELECT '.$this->sTable.'.* 
			FROM '.$this->sTable.' 
				INNER JOIN kColumns 
					ON kColumns.id='.$this->sTable.'.column_id 
			WHERE project_id=? ORDER BY '.$this->sTable.'.position ASC',$project_id_);
	}
	
	public function findAllInSprintsByProject($project_id_){
		
		return $this->findManySimple('SELECT '.$this->sTable.'.* 
				,kTasksInSprints.sprint_id
				
			FROM '.$this->sTable.' 
				INNER JOIN kTasksInSprints 
					ON kTasksInSprints.task_id='.$this->sTable.'.id 
				INNER JOIN kSprints 
					ON kSprints.id=kTasksInSprints.sprint_id 
			WHERE project_id=? ORDER BY '.$this->sTable.'.position ASC',$project_id_);
	}
	public function findAllOutSprint($project_id_){
		
		return $this->findManySimple('SELECT '.$this->sTable.'.* 
				,kTasksInSprints.sprint_id
				
			FROM '.$this->sTable.' 
				INNER JOIN kColumns 
					ON kColumns.id='.$this->sTable.'.column_id 
					
				LEFT OUTER JOIN kTasksInSprints 
					ON kTasksInSprints.task_id='.$this->sTable.'.id 
				
			WHERE project_id=? AND kTasksInSprints.id is NULL ORDER BY '.$this->sTable.'.position ASC',$project_id_);
	}
	
	
	public function findAllBySprint($sprint_id){
		return $this->findMany('SELECT '.$this->sTable.'.* FROM '.$this->sTable.' 
			INNER JOIN kTasksInSprints
				ON kTasksInSprints.task_id='.$this->sTable.'.id 
			WHERE kTasksInSprints.sprint_id=?',$sprint_id);
	}
	
	
	public function getSelect(){
		$tab=$this->findAll();
		$tSelect=array();
		if($tab){
		foreach($tab as $oRow){
			$tSelect[ $oRow->id ]=$oRow->title;
		}
		}
		return $tSelect;
	}
	
	public function addTask($column_id_,$sName_){

		$oTask=new row_tasks;
		$oTask->title=$sName_;
		$oTask->description='';
		$oTask->column_id=$column_id_;
		$oTask->save();
	
	}
	
	public function move($taskId,$columnId){
		$oTask=$this->findById($taskId);
		$oTask->column_id=$columnId;
		$oTask->save();
		
	}
	public function refInSprint($taskId,$sprintId){
		$this->execute('insert into kTasksInSprints (task_id,sprint_id) values (?,?)',$taskId,$sprintId);
		
	}		
	

}

class row_Tasks extends abstract_row{
	
	protected $sClassModel='model_Tasks';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
	private function getCheck(){
		$oPluginValid=new plugin_valid($this->getTab());
		
		
		/* renseigner vos check ici
		$oPluginValid->isEqual('champ','valeurB','Le champ n\est pas &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isNotEqual('champ','valeurB','Le champ est &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isUpperThan('champ','valeurB','Le champ n\est pas sup&eacute; &agrave; '.$valeurB);
		$oPluginValid->isUpperOrEqualThan('champ','valeurB','Le champ n\est pas sup&eacute; ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isLowerThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur &agrave; '.$valeurB);
		$oPluginValid->isLowerOrEqualThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isEmpty('champ','Le champ n\'est pas vide');
		$oPluginValid->isNotEmpty('champ','Le champ ne doit pas &ecirc;tre vide');
		$oPluginValid->isEmailValid('champ','L\email est invalide');
		$oPluginValid->matchExpression('champ','/[0-9]/','Le champ n\'est pas au bon format');
		$oPluginValid->notMatchExpression('champ','/[a-zA-Z]/','Le champ ne doit pas &ecirc;tre a ce format');
		*/

		return $oPluginValid;
	}

	public function isValid(){
		return $this->getCheck()->isValid();
	}
	public function getListError(){
		return $this->getCheck()->getListError();
	}
	public function save(){
		if(!$this->isValid()){
			return false;
		}
		parent::save();
		return true;
	}

}
