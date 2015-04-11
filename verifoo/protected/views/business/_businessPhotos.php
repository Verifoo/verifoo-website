
<div class="eachPhoto">
		<?php
	       /* $this->widget('ext.lyiightbox.LyiightBox2', array(
	           'thumbnail' => Yii::app()->easyImage->thumbSrcOf('uploads/images/businessphotos/'.$data->business_id.'/'.$data->photoname, array('scaleAndCrop' => array('width' => 100, 'height' => 100))),
	            'image' => ',
	            'title' => $data->description,
			    'visible' => true,
			  //'group' => 'myOwnGallery'
			        ));*/
		
		 ?>
<a title="<?php echo $data->description;?>" rel="gallery" class="fancybox" href="<?php echo '/../uploads/images/businessphotos/'.$data->business_id.'/'.$data->photoname;?>">
		<img src="<?php echo Yii::app()->easyImage->thumbSrcOf('uploads/images/businessphotos/'.$data->business_id.'/'.$data->photoname, array('scaleAndCrop' => array('width' => 100, 'height' => 100)));?>" 
		alt="<?php echo $data->description;?>"/>
</a>
		

</div>