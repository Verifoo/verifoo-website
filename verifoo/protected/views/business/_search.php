<?php
/* @var $this BusinessController */
/* @var $model Business */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'businessname'); ?>
		<?php echo $form->textField($model,'businessname',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	
	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>
	<?php /*
	<div class="row">
		<?php echo $form->label($model,'business_type'); ?>
		<?php echo $form->textField($model,'business_type',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	 
	<div class="row">
		<?php echo $form->label($model,'website'); ?>
		<?php echo $form->textField($model,'website',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'openschedule'); ?>
		<?php echo $form->textField($model,'openschedule',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'foundeddate'); ?>
		<?php echo $form->textField($model,'foundeddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'facebook_page'); ?>
		<?php echo $form->textField($model,'facebook_page',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'twitter_page'); ?>
		<?php echo $form->textField($model,'twitter_page',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gplus_page'); ?>
		<?php echo $form->textField($model,'gplus_page',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'dti_number'); ?>
		<?php echo $form->textField($model,'dti_number',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	*/?>
	<div class="row">
		<?php echo $form->label($model,'views'); ?>
		<?php echo $form->textField($model,'views',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dti_verified'); ?>
		<?php echo $form->textField($model,'dti_verified',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->