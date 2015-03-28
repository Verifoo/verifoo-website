<?php

class ReviewController extends Controller
{
	public function actionIndex()
	{
		
		$this->render('index');
	}
	public function actionEdit($id)
	{
		$model=$this->loadModel($id);
		
		if(isset($_POST['Review']))
		{
			//$reviewCheck = Review::model()->findByAttributes(array('condition'=>'user_id=:userID && business_id=:bID','params'=>array(':rID'=>$_POST['Review']['reviewer_id'],':bID'=>$_POST['Review']['business_id'])));
			
			$model->attributes=$_POST['Review'];
			
			if($model->validate())
			{
				if($model->save()){
					$business=Business::model()->findByPk($model->business_id);
					Yii::app()->user->setFlash('rated','Thank you for reviewing '.ucwords($business->businessname));
					$this->redirect(array('business/view','id'=>$model->business_id));
				}
				
			}
		}
		if($model->reviewer_id== Yii::app()->user->id){
			$this->render('edit',array(
				'model'=>$model,
			));
		}else {
			$this->redirect(array('review/index','id'=>$model->reviewer_id));		
		}
	}
	
	
	public function loadModel($id)
	{
		$model=Review::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Events $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='events-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}