
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
				<h4>
					<?php if($data->dti_verified==1):;?>
						<div class="verified">
							<img src="<?php echo Yii::app()->getBaseUrl(true).'/images/verified.png' ?>" alt="Business Verified" title="Business Verified"/>
						</div>
					<?php endif;?>	
					<a href="<?php echo Yii::app()->createUrl('search/card', array('id' => $data->id,'search'=>$searchwords));?>"><?php echo MHelper::String()->truncate($data->businessname, 64); ?></a>
					<div class="bStars">
						<div class="star" style="width:<?php echo (22*round($data->reviewAve));?>px"></div>
					</div>	
				</h4>
			</div>
				
		</div>
		<div class="midDesc<?php echo $data->id;?>">
			
			
		</div>
		<div id="b<?php  echo $data->id;?>" class="sb_d">
			<p class="businessfield">Contact #: <span class="lightblue"><?php echo CHtml::encode($data->phonenumber);?></span></p>
			<p class="businessfield">Address : <span class="lightblue"><?php echo CHtml::encode($data->address); ?></span></p>
			<?php echo MHelper::String()->truncate($data->description, 512); ?>
		</div>
		<br/>
		
		<a href="<?php echo Yii::app()->createUrl('search/card', array('id' => $data->id,'search'=>$searchwords));?>">
			<div id="businessControlReview<?php  echo $data->id;?>" class="bCtrl bCtrl1">View Map </div>
		</a>
		<a href="<?php echo Yii::app()->createUrl('business/photos', array('id' => $data->id));?>">
			<div id="businessControlReview<?php  echo $data->id;?>" class="bCtrl bCtrl2">View Photo </div>
		</a>
		<a href="<?php echo Yii::app()->createUrl('business/view', array('id' => $data->id,'#'=>'reviews'));?>">
			<div id="businessControlReview<?php  echo $data->id;?>" class="bCtrl bCtrl3">View Review </div>
		</a>
	</div>

</div>	