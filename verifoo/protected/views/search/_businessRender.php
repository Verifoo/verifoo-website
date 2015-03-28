
<div class="view sblist">
    <div class="bPics">
    	<a href="<?php echo Yii::app()->createUrl('search/card', array('id' => $data->id,'search'=>$searchwords));?>">
    	<?php $this->widget('ext.SAImageDisplayer', array(
		    'image' => $data->logo,
		    'size' => 'p160',
		    'group' => 'business',
		    'defaultImage' => 'default.jpg',
		    'title' => $data->businessname,
		)); ?>
		</a>
	</div>
	<div class="prepend-24 inline card-1">
		<div class="topDesc">
			<div class="bName">
				<h4><a href="<?php echo Yii::app()->createUrl('search/card', array('id' => $data->id,'search'=>$searchwords));?>"><?php echo $data->businessname;?></a>
					<div class="bStars">
						<div class="star" style="width:<?php echo (16*round($data->reviewAve));?>px"></div>
					</div>	
				</h4>
			</div>
				
		</div>
		<div class="midDesc<?php echo $data->id;?>">
			
			
		</div>
		<div id="b<?php  echo $data->id;?>">
			<p class="businessfield">Contact #: <span class="lightblue"><?php echo CHtml::encode($data->phonenumber);?></span></p>
			<p class="businessfield">Address : <span class="lightblue"><?php echo CHtml::encode($data->address); ?></span></p>
			<?php echo MHelper::String()->truncate($data->description, 258); ?>
		</div>
		<br/>
		
		<a href="<?php echo Yii::app()->createUrl('search/card', array('id' => $data->id,'search'=>$searchwords));?>"><div id="businessControlReview<?php  echo $data->id;?>" class="btn btn-primary businessControl">View Map </div></a>
	</div>

</div>	