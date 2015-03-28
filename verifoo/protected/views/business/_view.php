<?php
/* @var $this BusinessController */
/* @var $data Business */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('businessname')); ?>:</b>
	<?php echo CHtml::encode($data->businessname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category')); ?>:</b>
	<?php echo CHtml::encode($data->category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('openschedule')); ?>:</b>
	<?php echo CHtml::encode($data->openschedule); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('foundeddate')); ?>:</b>
	<?php echo CHtml::encode($data->foundeddate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facebook_page')); ?>:</b>
	<?php echo CHtml::encode($data->facebook_page); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('twitter_page')); ?>:</b>
	<?php echo CHtml::encode($data->twitter_page); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gplus_page')); ?>:</b>
	<?php echo CHtml::encode($data->gplus_page); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('views')); ?>:</b>
	<?php echo CHtml::encode($data->views); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dti_registered')); ?>:</b>
	<?php echo CHtml::encode($data->dti_registered); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dti_number')); ?>:</b>
	<?php echo CHtml::encode($data->dti_number); ?>
	<br />

	*/ ?>

</div>