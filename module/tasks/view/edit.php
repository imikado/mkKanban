<?php 
$oForm=new plugin_form($this->oTasks);
$oForm->setMessage($this->tMessage);
?>
<form action="" method="POST" >
<table class="tb_edit">
	
	<tr class="input">
		<th>title</th>
		<td><?php echo $oForm->getInputText('title') ?></td>
	</tr>
		
	<tr class="input">
		<th>description</th>
		<td><?php echo $oForm->getInputTextarea('description') ?></td>
	</tr>
		
	<tr class="input">
		<th>complexity</th>
		<td><?php echo $oForm->getInputText('complexity') ?></td>
	</tr>
		
	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Modifier" /> <a href="<?php echo $this->getLink('tasks::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>

<?php echo $oForm->getToken('token',$this->token)?>

</form>

