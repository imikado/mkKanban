<style>
.line{
border-bottom:3px solid #777;
background:#1b599f;
padding:5px;

margin-bottom:10px;
}
.line a{
font-size:14px;
text-decoration:none;
color:white;
}
a:hover{
color:orange;
}
</style>

<h1>Projects</h1>

<div>
	 
	<?php if($this->tKProjects):?>
		<?php foreach($this->tKProjects as $oKProjects):?>
		<div class="line">
			
		 
		
			<a style="padding-right:20px" href="<?php echo $this->getLink('default::index',array(
										'project_id'=>$oKProjects->getId()
									) 
							)?>">
				<?php echo $oKProjects->title ?>
		
			</a>
		 
		
			 
				
				
			<a style="float:right" href="<?php echo $this->getLink('Projects::edit',array(
										'id'=>$oKProjects->getId()
									) 
							)?>">[Edit]</a>
							

			<div style="clear:both"></div>		 
		</div>
			
 				
				
			 
		<?php endforeach;?>
	<?php else:?>
		
		<div>Aucune ligne</div>
		
	<?php endif;?>
</div>

<p><a href="<?php echo $this->getLink('Projects::new') ?>">New</a></p>
			
