<div class="reviewForm">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'mainlayoutreview-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
	)); ?>
	<div class="reviewForm">
		<div class="row">
	        <?php echo $form->labelEx($photomodel,'photoname'); ?>
	        <?php echo CHtml::activeFileField($photomodel, 'photoname'); ?>  
	        <?php echo $form->error($photomodel,'photoname'); ?>
		</div>
		<div class="row">
			<?php
				echo $form->hiddenField($photomodel,'photo_owner'); 
			?> 
			<?php echo $form->hiddenField($photomodel,'business_id'); ?> 
		</div>
		<br/>
		<div class="row">
			<?php echo $form->labelEx($photomodel,'description'); ?>
			<?php echo $form->textArea($photomodel,'description'); ?>
			<?php echo $form->error($photomodel,'description'); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>
