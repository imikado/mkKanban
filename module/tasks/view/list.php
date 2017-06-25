<table class="tb_list">
	<tr>
		
		<th>title</th>
		
		<th>description</th>
		
		<th>complexity</th>
		
		<th></th>
	</tr>
	<?php if($this->tTasks):?>
		<?php foreach($this->tTasks as $oTasks):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oTasks->title ?></td>
		
		<td><?php echo $oTasks->description ?></td>
		
		<td><?php echo $oTasks->complexity ?></td>
		
			<td>
				
				
<a href="<?php echo $this->getLink('tasks::edit',array(
										'id'=>$oTasks->getId()
									) 
							)?>">Edit</a>
			| 
<a href="<?php echo $this->getLink('tasks::delete',array(
										'id'=>$oTasks->getId()
									) 
							)?>">Delete</a>
			
				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="4">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a href="<?php echo $this->getLink('tasks::new') ?>">New</a></p>
			
