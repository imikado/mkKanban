<form action="" method="POST">
<table class="tb_delete">
	
	<tr>
		<th>title</th>
		<td><?php echo $this->oKSprints->title ?></td>
	</tr>
		
	<tr>
		<th>startdate</th>
		<td><?php echo $this->oKSprints->startdate ?></td>
	</tr>
		
	<tr>
		<th>enddate</th>
		<td><?php echo $this->oKSprints->enddate ?></td>
	</tr>
		
	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Confirmer la suppression" /> <a href="<?php echo $this->getLink('kSprints::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>


<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>


</form>
