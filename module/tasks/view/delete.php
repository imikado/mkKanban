<form action="" method="POST">
<table class="tb_delete">
	
	<tr>
		<th>title</th>
		<td><?php echo $this->oTasks->title ?></td>
	</tr>
		
	<tr>
		<th>description</th>
		<td><?php echo $this->oTasks->description ?></td>
	</tr>
		
	<tr>
		<th>complexity</th>
		<td><?php echo $this->oTasks->complexity ?></td>
	</tr>
		
	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Confirmer la suppression" /> <a href="<?php echo $this->getLink('tasks::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>


<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>


</form>
