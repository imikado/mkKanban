<form action="" method="POST">
<table class="tb_delete">
	
	<tr>
		<th>name</th>
		<td><?php echo $this->oColumns->name ?></td>
	</tr>
		
	<tr>
		<th>position</th>
		<td><?php echo $this->oColumns->position ?></td>
	</tr>
		
	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Confirmer la suppression" /> <a href="<?php echo $this->getLink('Columns::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>


<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>


</form>
