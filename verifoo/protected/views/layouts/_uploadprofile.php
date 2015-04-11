<div class="form">
						
	<?php 
		
		$form=$this->beginWidget('CActiveForm', array(
		'id'=>'uploadprofile-form',
		'enableAjaxValidation'=>false,
		'action' => Yii::app()->createUrl('user/profile/updateimage',array('id'=>Yii::app()->user->id)),
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
	)); ?>
		<div class="row">
			
	      	<div class="row">
	        	<?php echo $form->hiddenField($picture,'id');?>
			</div>
			<?php if(isset($picture->image) && $picture->image!=''){ ?>
			<div class="row">
		     	 <?php $this->widget('ext.SAImageDisplayer', array(
					    'image' => $picture->image,
					    'size' => 'p190',
					    'group' => 'users',
					    'defaultImage' => 'default.jpg',
					    'title' => 'Profile Image',
					)); ?>
		    </div>
		    <?php  } ?>
			
			<div class="row">
		        <?php echo $form->labelEx($picture,'image'); ?>
		        <?php echo CHtml::activeFileField($picture, 'image'); ?>  
		        <?php echo $form->error($picture,'image'); ?>
			</div>
			
		</div>
	<?php $this->endWidget(); ?>
</div>	