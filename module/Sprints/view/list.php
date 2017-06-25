<table class="tb_list">
	<tr>
		
		<th>title</th>
		
		<th>startdate</th>
		
		<th>enddate</th>
		
		<th></th>
	</tr>
	<?php if($this->tKSprints):?>
		<?php foreach($this->tKSprints as $oKSprints):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oKSprints->title ?></td>
		
		<td><?php echo $oKSprints->startdate ?></td>
		
		<td><?php echo $oKSprints->enddate ?></td>
		
			<td>
				
				
<a href="<?php echo $this->getLink('kSprints::edit',array(
										'id'=>$oKSprints->getId()
									) 
							)?>">Edit</a>
			| 
<a href="<?php echo $this->getLink('kSprints::delete',array(
										'id'=>$oKSprints->getId()
									) 
							)?>">Delete</a>
			| 
<a href="<?php echo $this->getLink('kSprints::show',array(
										'id'=>$oKSprints->getId()
									) 
							)?>">Show</a>
			
				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="4">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a href="<?php echo $this->getLink('kSprints::new') ?>">New</a></p>
			
