
<div class="reviewlist">
		<div class="reviewPhoto">
			<a class="" href="<?php echo Yii::app()->createUrl('profile/view',array('id'=>$data->reviewer_id));?>">
			<?php 
			 
			 		$fullname = CustomTool::generateUname($data->reviewer_id);
					$this->widget('ext.SAImageDisplayer', array(
					    'image' => $data->user['image'],
					    'size' => 'p64',
					    'title' => $fullname,
					    'group' => 'users',
					    'defaultImage' => 'default.jpg',
					)); 
					
				 ?>
			</a>
		<div class="reviewUL">
			<?php if(isset(Yii::app()->user->id)):
					if(Yii::app()->user->id!=$data->reviewer_id):
						$exists=Userfollow::model()->exists('user_id=:rID && follower_id=:fid',array(':rID'=>$data->reviewer_id,':fid'=>Yii::app()->user->id));
						$friendship=Friend::model()->find('(user_id=:rID && friend_id=:uid) || (user_id=:uid && friend_id=:rID) ',array(':rID'=>$data->reviewer_id,':uid'=>Yii::app()->user->id));
					?>
					<a href="<?php if(isset(Yii::app()->user->id)){ echo '#';}else{ echo Yii::app()->createUrl('user/login');}?>" class="ufollow" id="ufollow<?php echo $data->id;?>" reviewer-id="<?php echo $data->reviewer_id;?>" >
						<?php if($exists==0){echo ' Follow ';}else{echo 'Stop Following';}?>
					</a>
					<a href="<?php $userfollowing = 0;  if(isset(Yii::app()->user->id)){ echo '#';}else{ echo Yii::app()->createUrl('user/login');}?>" class="afriend" id="afriend<?php if(isset(Yii::app()->user->id)){ echo $data->reviewer_id;}?>" reviewer-id="<?php echo $data->reviewer_id;?>" >
						<?php if(count($friendship)==0){echo 'Add friend';}
							  else {
							  	if(isset($friendship->confirm)&&$friendship->confirm==1){echo 'Your friend';}
							  	else {
							  		if(isset($friendship->inviteby)&&$friendship->inviteby==$data->reviewer_id){echo 'Confirm as friend';}
							  		else{echo 'Friend request sent';}
								}
							  }
						?>
					</a>
					<a href="<?php if(isset(Yii::app()->user->id)){ echo '#';}else{ echo Yii::app()->createUrl('user/login');}?>" class="umessage" id="umessage<?php if(isset(Yii::app()->user->id)){ echo $data->id;}?>">Send message</a>
			
			<?php else:?>
				<a href="<?php echo Yii::app()->createUrl('review/edit',array('id'=>$data->id));?>">Update Review</a>
			<?php endif;
			else:?>
				<a href="<?php echo Yii::app()->createUrl('user/login');?>">Follow </a>
				<a href="<?php echo Yii::app()->createUrl('user/login');?>">Add friend</a>
				<a href="<?php echo Yii::app()->createUrl('user/login');?>">Send message</a>
			<?php endif;?>	
			
		</div>
		</div>
		<div class="reviewDescription">
			<div class="reviewerName">
				<a class="" href="<?php echo Yii::app()->createUrl('profile/view',array('id'=>$data->reviewer_id));?>">
						<?php echo $fullname;?></a>
			</div>
			<div class="reviewPostedDate">Posted: <?php echo date("M d, Y ",strtotime($data->date_review));?></div>
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
