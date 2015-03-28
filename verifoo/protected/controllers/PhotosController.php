<?php

class PhotosController extends Controller
{
	public $layout='//layouts/userview';
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Businessphoto', array(
			'criteria'=>array(
				'params' => array(':id'=>$_GET['id']),
		        'condition'=>'photo_owner =:id',
		    ),
			'pagination'=>array(
				'pageSize'=>32,
			),
		));
		exit;
		$this->render('/photos/index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionView()
	{
		$dataProvider=new CActiveDataProvider('Businessphoto', array(
			'criteria'=>array(
				'params' => array(':id'=>$_GET['id']),
		        'condition'=>'photo_owner =:id',
		    ),
			'pagination'=>array(
				'pageSize'=>32,
			),
		));
		$this->render('/photos/view',array(
			'dataProvider'=>$dataProvider,'userid'=>$_GET['id'],
		));
	}
	public function actionShow()
	{
		
	}
	public function actionBusiness()
	{
		
	}
	public function loadUserModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}