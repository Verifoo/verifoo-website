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
?><h2><?php echo ucwords($profile->firstname." ".$profile->lastname); 
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
		<p><span class="p_l">Username: </span><?php echo isset($model->username)? $model->username: '';?></p>
		<p><span class="p_l">Birthdate: </span><?php echo CHtml::encode(date("F d, Y",strtotime($model->bday))); ?></p>
		<?php if(Yii::app()->user->id==$model->id): ?>
			<p><span class="p_l">Email: </span><?php echo CHtml::encode($model->email); ?></p>
		<?php endif;?>
		<p><span class="p_l">Member Since: </span><?php echo date("M d, Y H:i:s a",strtotime($model->create_at)); ?></p>
		<p><span class="p_l">Last Login: </span><?php echo date("M d, Y H:i:s a",strtotime($model->lastvisit_at)); ?></p>
		<?php 
		$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
		if ($profileFields) {
			foreach($profileFields as $field) {
				//echo "<pre>"; print_r($profile); die();
			?>
			<p><span class="p_l"><?php echo CHtml::encode(UserModule::t($field->title)); ?>: </span><?php echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?></p>
	
			<?php
			}//$profile->getAttribute($field->varname)
		}?>
	</div>