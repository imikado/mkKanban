<?php 
$oForm=new plugin_form($this->oColumns);
$oForm->setMessage($this->tMessage);
?>
<form action="" method="POST" >
<table class="tb_edit">
	
	<tr class="input">
		<th>name</th>
		<td><?php echo $oForm->getInputText('name') ?></td>
	</tr>
		
	<tr class="input">
		<th>position</th>
		<td><?php echo $oForm->getInputText('position') ?></td>
	</tr>
		
	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Modifier" /> <a href="<?php echo $this->getLink('Columns::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>

<?php echo $oForm->getToken('token',$this->token)?>

</form>

