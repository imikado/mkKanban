<table class="tb_list">
	<tr>
		
		<th>name</th>
		
		<th>position</th>
		
		<th></th>
	</tr>
	<?php if($this->tColumns):?>
		<?php foreach($this->tColumns as $oColumns):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oColumns->name ?></td>
		
		<td><?php echo $oColumns->position ?></td>
		
			<td>
				
				
<a href="<?php echo $this->getLink('Columns::edit',array(
										'id'=>$oColumns->getId()
									) 
							)?>">Edit</a>
			| 
<a href="<?php echo $this->getLink('Columns::delete',array(
										'id'=>$oColumns->getId()
									) 
							)?>">Delete</a>
			
				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="3">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a href="<?php echo $this->getLink('Columns::new') ?>">New</a></p>
			
