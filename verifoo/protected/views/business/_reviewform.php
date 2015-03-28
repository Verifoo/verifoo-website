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
			<?php echo $form->error($reviewmodel,'reviewer_id'); ?>
			<?php echo $form->labelEx($reviewmodel,'rate'); ?>
			<?php
				echo $form->hiddenField($reviewmodel,'reviewer_id'); 
			?> 
			<?php echo $form->hiddenField($reviewmodel,'business_id'); ?> 
			<?php
			$this->widget('CStarRating',array(
						'model' => $reviewmodel,
						//'attribute'=>'rate',
			            'name'=>'Review[rate]',
			            'value'=>'3',
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
		</div>
		<br/>
		<div class="row">
			<?php echo $form->labelEx($reviewmodel,'comment'); ?>
			<?php echo $form->textArea($reviewmodel,'comment'); ?>
			<?php echo $form->error($reviewmodel,'comment'); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>
