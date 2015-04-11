<?php $this->renderPartial('//layouts/userlayoutleftCol', array('model'=>$model)); ?>
<div id="rightCol">
	<div class="businesslinks">
		<ul>
			<li class="btn-primary">
				<a href="<?php echo Yii::app()->createUrl('profile/view', array('id' => $model->id));?>">About</a>
			</li>
			<li class="btn-primary">
				<a href="<?php echo Yii::app()->createUrl('profile/friends', array('id' => $model->id));?>">Friends</a>
			</li>
			<li class="btn-primary">
				<a href="<?php echo Yii::app()->createUrl('profile/photos', array('id' => $model->id));?>">Photos</a>
			</li>
			<li class="activepage">
				Reviews
			</li>
		</ul>
	</div>	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
<?php 
	$fullname = ucwords($model->profile->firstname." ".substr($model->profile->lastname, 0,1).".");
$this->pageTitle=$fullname.UserModule::t(" Profile").' - '.Yii::app()->name;
?><h3><?php echo $fullname." Reviews";
	  if(Yii::app()->user->id==$model->id){
	  	 echo"<span class='h3span'><a href='".Yii::app()->createUrl('user/profile/edit')."'>( Edit Profile )</a></span>";}
	  ?> 
  </h3>

<?php
	$emptyText = 'No reviews yet';
$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$reviews,
					'itemView'=>'_userReviews',
					'id'=>"review_list",
					'enablePagination'=>true,
					'emptyText' => $emptyText,
					//'template'=>"{pager}\n{items}\n{pager}",
					'summaryText'=>'',
					//'pager' => array('class' => 'CLinkPager', 'header' => '','maxButtonCount' => 5), 
					'pager' => array(
		                    'class'=>'ext.infiniteScroll.IasPager', 
					        'rowSelector'=>'.reviewlist', 
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