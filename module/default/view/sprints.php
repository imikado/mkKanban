<?php $sprintColor='gray'?>
<style>
.sprints{
border:1px solid <?php echo $sprintColor?>;
margin-bottom:5px;
background:#def0f4;
padding-bottom:20px;
}

.sprints h2{
border-bottom:1px dotted <?php echo $sprintColor?>;
margin-top:0px;	
text-align:left;
font-size:12px;
}
.sprints h2 a{
font-size:12px;

}
.sprints .dropZone{
border: 1px dotted gray;
padding:10px;
}

.reftask{
border:1px solid #444;
background:#ddd;
width:auto;
padding:4px;
margin:4px;
}

</style>
<script>
function dropSprint(ev){
	ev.preventDefault();
	var taskId = ev.dataTransfer.getData("text");
	var taskPkey = ev.dataTransfer.getData("pkey");
	var taskTitle=ev.dataTransfer.getData("title");


	var sprintId;

	var tTargetDetail=ev.target.id.split('_');


	var tData=Array();
	var tChildren;
	
	console.log('dropSprint');

	if(tTargetDetail[0]=='reftask'){
		ev.target.parentElement.insertBefore(document.getElementById(taskIdName),ev.target);

		columnId=ev.target.parentElement.id;

		tChildren=ev.target.parentElement.children;


	}else if(tTargetDetail[0]=='sprint'){
	
		sprintId=ev.target.id;
		
		
		//check if exist
		var tChildren=ev.target.getElementsByTagName("span");
		if(tChildren){
			for(var i=0;i<tChildren.length;i++){
				if(tChildren[i].id=='reftask_'+taskPkey){
					return false;
				}
			}
		}
	
		var a=getById( ev.target.id );
		if(a){
			a.innerHTML+='<span class="reftask" id="reftask_'+taskPkey+'">#'+taskPkey+' '+ev.dataTransfer.getData('title')+'</span>';
		}
	
		

	
	
	}else{
		alert('drag and drop not permitted here: "'+ev.target.type+'"');
		return false;
	}

	tData.push(refTaskInSprint(sprintId,taskId) );


 

	sendData('tasks::updateColumnTask','['+tData.join(',')+']');

	//console.log(ev.target.children);

   
}

function refTaskInSprint(sprintId,taskId){
	return '{ "action":"refInSprint","sprintId":"'+sprintId+'", "taskId":"'+taskId+'"}';
}


function editSprint(id){

	openMyPopup(300,200);
	
	var b=getById('popupFrame');
	if(b){
		b.src='<?php echo _root::getLink('Sprints::edit',array('id'=>null),false)?>'+id;
	}
	
	return false;
}

</script>
<p>
<a class="btn" href="<?php echo _root::getLink('default::addSprint',array('project_id'=>$this->project_id)) ?>">+ Sprints</a>
</p>

<?php if($this->tSprints):?>
<?php foreach($this->tSprints as $oSprints):?>

	<div class="sprints" id="sprint_<?php echo $oSprints->id?>" ondrop="dropSprint(event)" ondragover="allowDrop(event)">
		<h2>
			#<?php echo $oSprints->id?> <?php echo $oSprints->title?> 
			<a class="btn" href="#" onclick="return editSprint(<?php echo $oSprints->id?>)">edit</a>
			<a class="btn" target="_blank" href="<?php echo _root::getLink('Sprints::planning',array('id'=>$oSprints->id))?>">planning</a>
			<?php if($oSprints->startdate):?>[<?php echo $oSprints->startdate?> - <?php echo $oSprints->enddate?>]<?php endif;?>  
		</h2>
		
		<?php if($this->tTaskInSprints):?>
			<?php foreach($this->tTaskInSprints as $oTaskInSprint):?>
				<?php if($oTaskInSprint->sprint_id!=$oSprints->id) continue;?>
			
				<span class="reftask" id="reftask_<?php echo $oTaskInSprint->id?>">#<?php echo $oTaskInSprint->id?> <?php echo $oTaskInSprint->title?></span>
			<?php endforeach;?>
		<?php endif;?>
		
	
	</div>

<?php endforeach;?>
<?php endif;?>
