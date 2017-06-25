<h1 style="font-weight:normal;border-bottom:1px dotted gray;color:#014a7c "><a style="font-weight:bold" href="<?php echo _root::getLink('Projects::list')?>">List</a> / <?php echo $this->oProject->title?></h1>
<?php

$columnColor='#014a7c';

$taskColor='#444';

?>

<style>


a{
text-decoration:none;
}
.column{
width:320px;
height:300px;
float:left;
border-left:2px solid <?php echo $columnColor?>;
 overflow-y:scroll;
padding-bottom:70px;
}
.column h2{
text-align:center;
border-bottom:2px solid <?php echo $columnColor?>;
font-size:15px;
font-weight:normal;
color:<?php echo $columnColor?>;
}
.column h2 a{
font-size:14px;

}

.task{
float:left;
width:282px;
border:1px solid <?php echo $taskColor?>;
margin:4px 0px;
margin-left:8px;
background:#f3f6a8;
}
.task h2{
border-bottom:1px dotted <?php echo $taskColor?>;
background:#f3f6a8;
margin-top:0px;	
text-align:right;
font-size:12px;
}
.task h2 a{
font-size:12px;

}



.clear{
clear:both;
}

#popup{
position:absolute;
border:2px solid gray;
background:transparent;
width:400px;
height:400px;
display:none;
}
#popup h2{
background:gray;
color:white;
text-align:right;
margin:0px;
}
#popup h2 a{ 
color:white;
}
#popupFrame{
border:0px;
width:398px;
height:398px;
background:white;
}

.block{


}

#backofficeFrame,#backofficeForm{
display:none;
}

.task sup{
background:#ccc;
border:2px solid <?php echo $taskColor?>;
padding:4px 4px;
}
.task p{
padding:5px;
}

.btn{
display:block;
display:inline;
border:0px solid #b02525; 
background:#b02525;
color:white;
padding: 1px 4px;
}

</style>
<script>
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {

	var tP=ev.target.getElementsByTagName("p");
	
	var tId=ev.target.id.split('_');
	var sPkey=tId[1];
	
	var sTitle= tP[0].innerHTML;
	
	ev.dataTransfer.setData("text", ev.target.id);
	ev.dataTransfer.setData("pkey", sPkey);
	ev.dataTransfer.setData("title", sTitle);
    
    
}

function drop(ev) {
    ev.preventDefault();
    var taskId = ev.dataTransfer.getData("text");
    
    
    var columnId;
    
    var tTargetDetail=ev.target.id.split('_');
    
    
    var tData=Array();
    var tChildren;
    
    if(tTargetDetail[0]=='task'){
	ev.target.parentElement.insertBefore(document.getElementById(taskId),ev.target);
	
	columnId=ev.target.parentElement.id;
	
	tChildren=ev.target.parentElement.children;
    
    
    }else if(tTargetDetail[0]=='column'){
	ev.target.appendChild(document.getElementById(taskId));
	
	columnId=ev.target.id;
	
	tChildren=ev.target.children;

    }else if(ev.target.parentElement.className=='task'){
	
	ev.target.parentElement.parentElement.insertBefore(document.getElementById(taskId),ev.target.parentElement);
	
	columnId=ev.target.parentElement.parentElement.id;
	
	tChildren=ev.target.parentElement.parentElement.children;
	
    }else{
	alert('drag and drop not permitted here: "'+ev.target.type+'"');
	return false;
    }
    
    tData.push(moveTask(columnId,taskId) );
    
    
    
    
    
    var sTaskList='';
    
    for (i = 0; i < tChildren.length; i++) {
	
	if(tChildren[i].id){
		var sTaskId=tChildren[i].id;
		var tTaskDetail=sTaskId.split('_');
		
		if(tTaskDetail[0]=='task'){
			
			sTaskList+=tTaskDetail[1]+';';
		
		}
	
	}
    }
    
    tData.push(updateOrderTaskColumn(columnId,sTaskList) );
    
    sendData('tasks::updateColumnTask','['+tData.join(',')+']');
    
    //console.log(ev.target.children);
    
   
}

function sendData(url_,data_){
	var a=getById('backofficeText');
	var b=getById('backofficeForm');
	if(a && b){
		b.action='index.php?:nav='+url_;
		a.value=data_;
		
		b.submit();
	}
}

function closeMyPopup(){ 
	var a=getById('popup');
	var b=getById('popupFrame');
	if(a && b){
		b.src='';
		a.style.display='none';
	}
	return false;
}
function openMyPopup(width_,height_){
	var a=getById('popup');
	var b=getById('popupFrame');
	if(a && b){
		a.style.display='block';
		a.style.width=width_+'px';
		a.style.height=height_+'px';
		
		b.style.width=(width_)+'px';
		b.style.height=(height_-12)+'px';
	}
}

function editTask(id){

	openMyPopup(300,200);
	
	var b=getById('popupFrame');
	if(b){
		b.src='<?php echo _root::getLink('tasks::edit',array('id'=>null),false)?>'+id;
	}
	
	return false;
}

function editColumn(id){
	openMyPopup(300,150);
	
	var b=getById('popupFrame');
	if(b){
		b.src='<?php echo _root::getLink('Columns::edit',array('id'=>null),false)?>'+id;
	}
	
	return false;
}

function moveTask(columnId,taskId){
	return '{ "action":"move","columnId":"'+columnId+'", "taskId":"'+taskId+'"}';
}
function updateOrderTaskColumn(columnId,sTaskList){
	return '{ "action":"updateOrder","columnId":"'+columnId+'","tasks":"'+sTaskList+'"}';
}





</script>

<form target="backofficeFrame" id="backofficeForm" action="" method="POST" ><textarea id="backofficeText" name="data"></textarea></form>
<iframe id="backofficeFrame" name="backofficeFrame" src=""></iframe>

<div id="popup"><h2><a href="#" onclick="return closeMyPopup()">Fermer</a></h2><iframe src="" id="popupFrame"></iframe></div>

<div class="block">

	<?php if($this->tColumn):?>
	<?php foreach($this->tColumn as $oColumn):?>
	<div id="column_<?php echo $oColumn->id?>" class="column" ondrop="drop(event)" ondragover="allowDrop(event)">
		<h2><?php echo $oColumn->name?> <a class="btn" href="#" onclick="return editColumn(<?php echo $oColumn->id?>)">edit</a>  <a class="btn" href="<?php echo _root::getLink('default::addTask',array('column_id'=>$oColumn->id))?>"> + task </a> </h2>
		
		<?php foreach($this->tTask as $oTask):?>
			
			<?php if($oTask->column_id!=$oColumn->id) continue;?>
		
			<div id="task_<?php echo $oTask->id?>" class="task" draggable="true" ondragstart="drag(event)"  >
				<h2>#<?php echo $oTask->id?> <a class="btn" href="#" onclick="return editTask(<?php echo $oTask->id?>)">edit</a> <?php if($oTask->complexity):?><sup><?php echo $oTask->complexity?></sup><?php endif;?> </h2>
				<p><?php echo $oTask->title?></p>
			 </div>
			
			
		
		<?php endforeach;?>
		
	</div>
	<?php endforeach;?>

	<?php endif;?>

	<div class="column" style="width:90px;overflow-y:hidden;">
		<h2><a class="btn" href="<?php echo _root::getLink('default::addColumn',array('project_id'=>$this->project_id))?>">+ Column</a></h2>
	</div>
	
	<div class="clear"></div>

</div>