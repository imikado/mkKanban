<table class="tb_show">
	
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
				<a href="<?php echo $this->getLink('kSprints::list')?>">Retour</a>
			</p>
		</td>
	</tr>
</table>
