
<div class="reviewlist">
		<div class="ureviewPhoto">
			<a href="<?php echo Yii::app()->createUrl('business/view', array('id'=>$data->business_id));?>">
			<?php 
			 
					$this->widget('ext.SAImageDisplayer', array(
					    'image' => $data->business['logo'],
					    'size' => 'p240',
					    'group' => 'business',
					    'defaultImage' => 'default.jpg',
					)); 
					
				 ?>
			</a>
		<div class="reviewUL">
			<?php if(isset(Yii::app()->user->id) && Yii::app()->user->id==$data->reviewer_id):?>
				<a class="" href="" id="eReview<?php echo $data->reviewer_id;?>">Edit Review</a>
			<?php endif;?>
			
		</div>
		</div>
		<div class="ureviewDescription">
			<div class="reviewerName">
				<?php echo($data->business['businessname']);?>
			</div>
			<div class="reviewPostedDate">Posted: <?php echo date("M d, Y H:i:s a",strtotime($data->date_review));?></div>
			<div class="reviewStars">
				<?php
					 echo '<div class="star" style="width:'.($data->rate*16).'px"></div>';
				
				?>
			</div>
			<div id="review<?php  echo $data->id;?>" class="reviewComment">
				<?php echo $data->comment; ?>
			</div>
		</div>

</div>	