<div class="form">
						
	<?php 
		
		$form=$this->beginWidget('CActiveForm', array(
		'id'=>'mainlayoutmodal-form',
		'enableAjaxValidation'=>false,
		'action' => Yii::app()->createUrl('business/updatelogo',array('id'=>$picture->id)),
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
	)); ?>
		<div class="row">
			
	      	<div class="row">
	        	<?php echo $form->hiddenField($picture,'id');
	        	?>
			</div>
			<?php if(isset($picture->logo) && $picture->logo!=''){ ?>
			<div class="row">
		     	 <?php $this->widget('ext.SAImageDisplayer', array(
					    'image' => $picture->logo,
					    'size' => 'p240',
					    'group' => 'business',
					    'defaultImage' => 'default.jpg',
					)); ?>
		    </div>
		    <?php  } ?>
			
			<div class="row">
		        <?php echo $form->labelEx($picture,'logo'); ?>
		        <?php echo CHtml::activeFileField($picture, 'logo'); ?>  
		        <?php echo $form->error($picture,'logo'); ?>
			</div>
			
		</div>
	<?php $this->endWidget(); ?>
</div>	