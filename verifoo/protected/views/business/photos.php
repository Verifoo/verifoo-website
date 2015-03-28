<?php
/* @var $this BusinessController */

?>
<?php $this->renderPartial('//layouts/businesslayoutleftCol', array('model'=>$model)); ?>
<div id="businessRCol">		
	<div class="businesslinks">
		<ul>
			<li  class="btn-primary">
				<a href="<?php echo Yii::app()->createUrl('business/view', array('id' => $model->id));?>">About</a>
			</li>
			<li class="activepage">
				Photos
			</li>
			<li class="btn-primary">
				<a href="<?php echo Yii::app()->createUrl('business/photos', array('id' => $model->id));?>">Posts</a>
			</li>
		</ul>
	</div>
<h2><?php echo $model->businessname; 
			echo '<div class="bStars">';
					//for($x=1;$x<=$numstar;$x++)
					 echo '<div class="star" style="width:'.(16*round($model->reviewAve)).'px"></div>';
				
			echo'</div>';
		if(Yii::app()->user->id==$model->user_id){
	  	 echo"<span class='h2span'>
	  	 		<a href='".Yii::app()->createUrl('business/update', array('id' => $model->id))."'>( Edit Business )</a>
	  	 	</span>";
		}
		//echo $model->reviewSum."--".$model->reviewCount.":".round($model->reviewSum/$model->reviewCount);
	?>
</h2>

<div class="businessInfo">
	<?php 
	
	if(isset(Yii::app()->user->id)):
		
					$bpmodel->photo_owner = Yii::app()->user->id; 
					$bpmodel->business_id = $model->id; 
					 $this->widget('bootstrap.widgets.TbModal', array(
					    'id' => 'tbmodal-reviewform',
					    'header' => 'Upload a photo for '.ucwords($model->businessname),
					    'content' => $this->renderPartial('_photoform',array('picture'=>$bpmodel,'photomodel'=>$bpmodel,'subject'=>'js:$("#subject").val()','body'=>'js:$("#body").val()'), true),
					    'footer' => array(
					    	TbHtml::button('Upload Now', array('onclick' => '$("#mainlayoutreview-form").submit();','data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
					        TbHtml::button('Close', array('data-dismiss' => 'modal')),
					     ),
					)); ?>
					 
					<?php echo TbHtml::button('Upload a photo', array(
					    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
					    'size' => TbHtml::BUTTON_SIZE_DEFAULT,
					    'data-toggle' => 'modal',
					    'data-target' => '#tbmodal-reviewform',
					    'id'=>'mainlayoutReviewForm',
					    'class' =>'btn btn-primary'
					));
		
	else:
		Yii::app()->user->returnUrl = Yii::app()->request->requestUri;//Yii::app()->request->urlReferrer;
		echo '<a class="btn btn-primary" href="'.Yii::app()->createUrl('user/login').'">Signup/Login to Upload a Photo</a>';
	endif;//end of if user is login
?>
</div>
<div class="businessphotos">
<h3>Photos </h3>
<?php
	$emptyText = 'No photos uploaded yet';
$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$photos,
					'itemView'=>'_businessPhotos',
					'id'=>"review_list",
					'enablePagination'=>true,
					'emptyText' => $emptyText,
					//'template'=>"{pager}\n{items}\n{pager}",
					'summaryText'=>'',
					//'pager' => array('class' => 'CLinkPager', 'header' => '','maxButtonCount' => 5), 
					'pager' => array(
		                    'class'=>'ext.infiniteScroll.IasPager', 
					        'rowSelector'=>'.photolist', 
					        'listViewId'=>'review_list', 
					        'header'=>'',
					        'loaderText'=>'Loading...',
					        'options'=>array(
						            'history'=>false, 
						            'triggerPageTreshold'=>12, 
						            'trigger'=>'Load more'
					        	),
	                   )
				)); 
?>
</div>
<?php if($model->user_id==Yii::app()->user->id):?>
<a name="ap"></a>
<div class="apPhotos">
<h3>Need Approval Photos </h3>
<?php
	$emptyText = 'No photos uploaded yet';
	$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$needapprovalphotos,
					'itemView'=>'_needApprovalPhotos',
					'id'=>"ap_photos",
					'enablePagination'=>true,
					'emptyText' => $emptyText,
					'summaryText'=>'',
					'pager' => array(
		                    'class'=>'ext.infiniteScroll.IasPager', 
					        'rowSelector'=>'.eachAPhoto', 
					        'listViewId'=>'ap_photos', 
					        'header'=>'',
					        'loaderText'=>'Loading...',
					        'options'=>array(
						            'history'=>false, 
						            'triggerPageTreshold'=>12, 
						            'trigger'=>'Load more'
					        	),
	                   )
	)); 
?>
</div>
<?php endif;?>
</div>