<?php 
$oForm=new plugin_form($this->oKSprints);
$oForm->setMessage($this->tMessage);
?>
<form action="" method="POST" >
<table class="tb_edit">
	
	<tr class="input">
		<th>title</th>
		<td><?php echo $oForm->getInputText('title') ?></td>
	</tr>
		
	<tr class="input">
		<th>startdate</th>
		<td><?php echo $oForm->getInputText('startdate') ?></td>
	</tr>
		
	<tr class="input">
		<th>enddate</th>
		<td><?php echo $oForm->getInputText('enddate') ?></td>
	</tr>
		
	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Modifier" /> <a href="<?php echo $this->getLink('kSprints::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>

<?php echo $oForm->getToken('token',$this->token)?>

</form>

