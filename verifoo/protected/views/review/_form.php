<?php
/* @var $this BusinessController */
/* @var $model Business */
/* @var $form CActiveForm */
?>

<div class="form">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'business-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="reviewForm">
		<div class="row">
			<?php echo $form->error($model,'reviewer_id'); ?>
			<?php echo $form->labelEx($model,'rate'); ?>
			<?php
				echo $form->hiddenField($model,'reviewer_id'); 
			?> 
			<?php echo $form->hiddenField($model,'business_id'); ?> 
			<?php
			$this->widget('CStarRating',array(
						'model' => $model,
						//'attribute'=>'rate',
			            'name'=>'Review[rate]',
			            'value'=>$model->rate,
			            'minRating'=>1,
			            'maxRating'=>5,
			            'allowEmpty' =>false,
			            'titles'=>array(
			                '1'=>'Normal',
			                '2'=>'Average',
			                '3'=>'OK',
			                '4'=>'Good',
			                '5'=>'Excellent'
			            	),
			            ));
			?>
		</div><br/>
		<div class="row">
			<?php echo $form->labelEx($model,'comment'); ?>
			<?php echo $form->textArea($model,'comment'); ?>
			<p id="txtCtr"></p>
			<?php echo $form->error($model,'comment'); ?>
		</div>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save Review'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->