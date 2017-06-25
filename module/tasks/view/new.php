<?php 
$oForm=new plugin_form($this->oTasks);
$oForm->setMessage($this->tMessage);
?>
<form action="" method="POST" >

<table class="tb_new">
	
	<tr>
		<th>title</th>
		<td><?php echo $oForm->getInputText('title') ?></td>
	</tr>
		
	<tr>
		<th>description</th>
		<td><?php echo $oForm->getInputTextarea('description') ?></td>
	</tr>
		
	<tr>
		<th>complexity</th>
		<td><?php echo $oForm->getInputText('complexity') ?></td>
	</tr>
		
	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Ajouter" /> <a href="<?php echo $this->getLink('tasks::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>

<?php echo $oForm->getToken('token',$this->token)?>

</form>
