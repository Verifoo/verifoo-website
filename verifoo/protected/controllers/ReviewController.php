<?php

class ReviewController extends Controller
{
	public $layout='//layouts/userlayout';
	public function actionIndex()
	{
		
		$this->render('index');
	}
	public function actionEdit($id)
	{
		$model=$this->loadModel($id);
		$umodel = User::model()->findByPk(Yii::app()->user->id);
		if(isset($_POST['Review']))
		{
			
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
				'model'=>$model,'user_model'=>$umodel,
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