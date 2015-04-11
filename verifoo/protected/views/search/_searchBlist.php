
<div class="view businesslist" id="bCard<?php echo $data->id;?>" business-data="<?php  echo $data->id;?>" >
    <div class="bPics">
    	
    	<?php $this->widget('ext.SAImageDisplayer', array(
		    'image' => $data->logo,
		    'size' => 'p160',
		    'group' => 'business',
		    'defaultImage' => 'default.jpg',
		    'title' => $data->businessname,
		)); ?>
	</div>
	<div class="searchbDescription">
		<div class="topDesc">
			<div class="bName"><h6><?php echo $data->businessname;?></h6></div>
			<div class="bStars2">
				<div class="star" style="width:<?php echo (22*round($data->reviewAve));?>px"></div>
			</div>
		</div>
		<div class="midDesc<?php echo $data->id;?>">
		</div>
		
	</div>
	

</div>	