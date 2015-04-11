<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout='//layouts/userlayout';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		if(isset($_POST['User']))
		{
			$model = $this->loadUser();
			$oldfilename = $model->image;
			
			$file = CUploadedFile::getInstance($model,'image');
			if (is_object($file) && get_class($file)==='CUploadedFile') {
				$model->image = $file;
				 $newname = time().".".Yii::app()->user->id.".".strtolower($file->extensionName);
			}else{
				$model->image = $oldfilename;
			}
		    if (is_object($file) && get_class($file)==='CUploadedFile') {
		        $fileDirectory = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'images/users/originals/';
				
				
		        $model->image->saveAs($fileDirectory.$newname);
				$model->image = $newname;
				$model->save(false);
		        if ($oldfilename != ''&& file_exists(Yii::getPathOfAlias('webroot.uploads.images/users/originals').DIRECTORY_SEPARATOR.$oldfilename)) {
		        	 unlink($fileDirectory. $oldfilename);
					CustomImage::customUnlink($oldfilename,'users');
		        }
				
		    }                  
			exit;
        }
		$model = $this->loadUser();
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		
		$profile=$model->profile;	
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			$model->bday = $_POST['User']['year']."-".$_POST['User']['month']."-".$_POST['User']['day'];
			if($model->validate()&&$profile->validate()) {
				$model->save(false);
				$profile->save();
                
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('/user/profile'));
			} else $profile->validate();
		}
		
		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
			'monthsArray'=>CustomTool::getMonthsArray(),
			'daysArray'=>CustomTool::getDaysArray(),
			'yearsArray'=>CustomTool::getYearsArray(),
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}