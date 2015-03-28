<?php

$this->breadcrumbs=array(
	'Businesses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Business', 'url'=>array('index')),
	array('label'=>'Create Business', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#business-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Manage Businesses</h2>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'business-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array( 
		'name'=>'user.username',
		'value'=>'$data->user->username','value' => 'isset($data->user->username) ? $data->user->username : Null',
		'type'=>'raw',
		),
		array( 
		'name'=>'user.profile.firstname',
		'value'=>'$data->user->profile->firstname','value' => 'isset($data->user->profile->firstname) ? $data->user->profile->firstname : Null',
		'type'=>'raw',
		),
		array( 
		'name'=>'user.profile.lastname',
		'value'=>'$data->user->profile->lastname','value' => 'isset($data->user->profile->lastname) ? $data->user->profile->lastname : Null',
		'type'=>'raw',
		),
		array(
			'name'=>'user.email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data->user,"email"), "mailto:".$data->user->email)',
		),
		'businessname',
		'address',
		'zipcode',
		array(
			'name'=>'dti_verified',
			'value'=>'Business::itemAlias("DTIStatus",$data->dti_verified)',
			'filter'=>Business::itemAlias("DTIStatus"),
		),
		array(
			'name'=>'status',
			'value'=>'Business::itemAlias("BusinessStatus",$data->status)',
			'filter' => Business::itemAlias("BusinessStatus"),
		),
		/*
		
		'openschedule',
		'foundeddate',
		'facebook_page',
		'twitter_page',
		'gplus_page',
		'views',
		'dti_registered',
		'dti_number',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
