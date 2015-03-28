
<div class="eachAPhoto" style="display:block;">
		<?php
	        $this->widget('ext.lyiightbox.LyiightBox2', array(
	           'thumbnail' => Yii::app()->easyImage->thumbSrcOf('uploads/images/businessphotos/'.$data->business_id.'/'.$data->photoname, array('scaleAndCrop' => array('width' => 100, 'height' => 100))),
	            'image' => '/../uploads/images/businessphotos/'.$data->business_id.'/'.$data->photoname,
	            'title' => $data->description,
			    'visible' => true,
			  //'group' => 'myOwnGallery'
			        ));
		?>
		<div class="photo_owner">
			Uploaded By: <a class="" href="<?php echo Yii::app()->createUrl('profile/view',array('id'=>$data->photo_owner));?>"><?php echo CustomTool::generateUname($data->photo_owner);?></a>
		</div>
</div>