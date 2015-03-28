<div class="ufriendPhoto">
			<a href="<?php echo Yii::app()->createUrl('profile/view', array('id'=>$data->friend_id));?>">
				<div class="userprofile">
			<?php 
					/*$this->widget('ext.SAImageDisplayer', array(
					    'image' => $data->user['image'],
					    'size' => 'p128',
					    //'title' => $fullname,
					    'group' => 'users',
					    'defaultImage' => 'default.jpg',
					));*/
					if(isset($data->user['image']) && $data->user['image']!='') 
						echo Yii::app()->easyImage->thumbOf('uploads/images/users/originals/'.$data->user['image'], array('scaleAndCrop' => array('width' => 128, 'height' => 128)));
					else
						echo Yii::app()->easyImage->thumbOf('uploads/images/users/originals/default.jpg', array('scaleAndCrop' => array('width' => 128, 'height' => 128)));
				 ?>
				 </div>
			</a>
		<div class="reviewUL">
				<a class="" href="<?php echo Yii::app()->createUrl('profile/view', array('id' => $data->user['id']));?>" ><?php echo CustomTool::generateUname($data->user['id']);?></a>
		</div>

</div>	