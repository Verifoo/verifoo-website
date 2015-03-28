<?php $this->renderPartial('//layouts/userlayoutleftCol', array('model'=>$model)); ?>
<div id="rightCol">
	<div class="businesslinks">
	<ul>
		<li class="btn-primary">
			<a href="<?php echo Yii::app()->createUrl('profile/view', array('id' => $model->id));?>">About</a>
		</li>
		<li class="activepage">
			Photos
		</li>
		<li class="btn-primary">
			<a href="<?php echo Yii::app()->createUrl('profile/activities', array('id' => $model->id));?>">Activities</a>
		</li>
	</ul>
</div>	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
<?php 
	$fullname = $fullname = ucwords($model->profile->firstname." ".substr($model->profile->lastname, 0,1).".");
$this->pageTitle=$fullname.UserModule::t(" Profile").' - '.Yii::app()->name;
?><h2><?php echo $fullname;
	  if(Yii::app()->user->id==$model->id){
	  	 echo"<span class='h2span'><a href='".Yii::app()->createUrl('user/profile/edit')."'>( Edit Profile )</a></span>";}
	  ?> 
  </h2>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
	<?php
Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('profileMessage'));

$this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>false,
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true),// success, info, warning, error or danger
        ),
)); ?>
</div>
<?php endif; ?>

<div class="forProfile">
	<p><span class="p_l">Address: </span><?php echo $profile->address; ?></p>
	<p><span class="p_l">Member Since: </span><?php echo date("M d, Y ",strtotime($model->create_at)); ?></p>
	<p><span class="p_l">Last Login: </span><?php echo date("M d, Y H:i:s a",strtotime($model->lastvisit_at)); ?></p>
	
</div>
<div class="reviews">
<h3>Photos </h3>
<?php
	$emptyText = 'No photos uploaded yet';
$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$photos,
					'itemView'=>'_userPhotos',
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
</div>