<?php
/* @var $this BusinessController */
/* @var $model Business */

$this->breadcrumbs=array(
	'Businesses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Business', 'url'=>array('index')),
	array('label'=>'Create Business', 'url'=>array('create')),
	array('label'=>'View Business', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Business', 'url'=>array('admin')),
);
?>

<h2>Update Business with Control #:<?php echo $model->id; ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile,'category'=>$category)); ?>