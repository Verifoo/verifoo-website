<?php $this->renderPartial('//layouts/userlayoutleftCol', array('model'=>$model)); 
Yii::app()->user->returnUrl = Yii::app()->request->requestUri;
?>
<div id="rightCol">
	<div class="businesslinks">
		<ul>
			<li class="btn-primary">
				<a href="<?php echo Yii::app()->createUrl('profile/view', array('id' => $model->id));?>">About</a>
			</li>
			<li class="activepage">
				Friends
			</li>
			<li class="btn-primary">
				<a href="<?php echo Yii::app()->createUrl('profile/photos', array('id' => $model->id));?>">Photos</a>
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
<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");

$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?><h3>Friends of <?php echo $fullname;?> </h3>

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
<div class="friendlist">
		<?php if(sizeof($friends)>0):
			?>
					
						<?php $this->widget('zii.widgets.CListView', array(
							'dataProvider'=>$friends,
							'itemView'=>'_friends',
							'template'=>'{pager}{items}{pager}',
							'enablePagination'=>true,
							'pager' => array('class' => 'CLinkPager', 'header' => '','maxButtonCount' => 5),
						)); 
					
						?>
		<?php endif;?>
</div>
</div>