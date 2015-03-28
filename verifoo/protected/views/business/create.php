
<?php
Yii::app()->user->returnUrl = Yii::app()->request->requestUri;
?>

<h2>Create Business</h2>

<?php $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile,'category'=>$category)); ?>
