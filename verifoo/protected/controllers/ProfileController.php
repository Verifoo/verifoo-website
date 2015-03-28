<?php

class ProfileController extends Controller
{
	
	public $layout='//layouts/userlayout';
	private $_model;
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','search','photos','friends'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','updatelogo','follow','addfriend'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionFriends()
	{
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else if(Yii::app()->user->id)
			$id = Yii::app()->user->id;
		else
			$this->redirect(array('user/login'));
		
		$model = $this->loadUser();
		
		//$friends=Friend::model()->with('user')->findAllByAttributes(array('user_id'=>$id));
		$friends=new CActiveDataProvider('Friend', array(
					    'criteria'=>array(
							    'condition'=>'(t.user_id=:user_id || t.friend_id=:user_id) && confirm=1',
							    'with'=>'user',
					    		'params'=>array(':user_id'=>$id),
					    ),
					  
					    'pagination'=>array('pageSize'=>'32'),
					));
		$this->render('friends',array(
	    	'model'=>$model,'friends'=>$friends,
			'profile'=>$model->profile,
			'fullname'=>ucwords($model->profile->firstname." ".substr($model->profile->lastname, 0,1)."."),
			'following'=>0,
		));
	}
	public function actionView($id)
	{
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($baseUrl.'/css/business.css');
		$cs->registerScriptFile('/js/jquery.rating.js'); 
		
		$model = $this->loadUser();
		$reviews=new CActiveDataProvider('Review', array(
		    'criteria'=>array('condition'=>'reviewer_id='.$model->id,
		    'alias'=>'review',
		    'with'=>array('business'=>array('alias'=>'business')),
		    'order' => 'review.id DESC',
		    ),
		    'pagination'=>array('pageSize'=>'1'),
		));	
		
		
		$this->render('view',array(
	    	'model'=>$model,'reviews'=>$reviews,
			'profile'=>$model->profile
		));
	}
	public function actionFollow()
	{
		$reviewerid = $_GET['reviewer_id'];
		$reviewid = $_GET['review_id'];
		if(is_numeric($reviewerid))
		{
			
			$following=Userfollow::model()->find(array(
					    'select'=>'id',
					    'condition'=>'user_id=:rID && follower_id=:fid',
					    'params'=>array(':rID'=>$reviewerid,':fid'=>Yii::app()->user->id),
			));
			if(count($following)==0)
			{
				$model = new Userfollow;
				$model->user_id = $reviewerid;
				$model->follower_id = Yii::app()->user->id;
				$model->datefollowed = date("Y-m-d H:i:s");
				$model->save(false);
				echo CJSON::encode(array('status'=>'Stop Following'));
			}else{
					Userfollow::model()->deleteByPk($following->id);
					echo CJSON::encode(array('status'=>'Follow'));
				
			}
		}
	}
	
	public function actionAddfriend()
	{
		$uid = $_GET['friend_id'];
		if(is_numeric($uid))
		{
			$friendship=Friend::model()->find('(user_id=:rID && friend_id=:uid) || (user_id=:uid && friend_id=:rID) ',array(':rID'=>$uid,':uid'=>Yii::app()->user->id));
			if(count($friendship)==0)
			{
				$model = new Friend;
				$model->friend_id = $uid;
				$model->user_id = Yii::app()->user->id;
				$model->inviteby = Yii::app()->user->id;
				$model->dateadded = date("Y-m-d H:i:s");
				$model->confirm=0;
				$model->save();
				echo CJSON::encode(array('status'=>'Friend request sent'));
			}else {
				if(isset($friendship->confirm) && $friendship->confirm==0)
				{
					if($friendship->inviteby!=Yii::app()->user->id){
						$friendship->confirm =1;
						$friendship->save();
						echo CJSON::encode(array('status'=>'Your friend'));
					}else{
						echo CJSON::encode(array('status'=>'Friend request sent'));
					}
				}else{
						Friend::model()->deleteByPk($friendship->id);
						echo CJSON::encode(array('status'=>'Add friend'));
				}
			}
			
		}
	}
	public function actionPhotos($id)
	{
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($baseUrl.'/css/business.css');
		$model=$this->loadUser($id);
		$photos=new CActiveDataProvider('Businessphoto', array(
		    'criteria'=>array('condition'=>'photo_owner='.$id,
		    'alias'=>'bphotos',
		    ),
		    'pagination'=>array('pageSize'=>'25'),
		));	
		$this->render('photos',array(
			'photos'=>$photos,'model'=>$model,'profile'=>$model->profile,
		));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Business;
		$profile = new Businessprofile;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Business']))
		{
			$model->attributes=$_POST['Business'];
			$profile->attributes=$_POST['Businessprofile'];
			$model->user_id = Yii::app()->user->id;
			$model->views = 0;
			$model->dti_verified = 0;
			$model->datecreated = date("Y-m-d H:i:s");
			if($model->category!='')
				$model->category = implode(':',$model->category);
			
			$oldfilename = $model->logo;
			$file =CUploadedFile::getInstance($model,'logo');
			if (is_object($file) && get_class($file)==='CUploadedFile') {
				$model->logo = $file;
				 $newname = time().".".Yii::app()->user->id.".".strtolower($file->extensionName);
			}else{
				$model->logo = $oldfilename;
			}
		    if (is_object($file) && get_class($file)==='CUploadedFile') {
		        $fileDirectory = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'images/business/originals/';
				
		        $model->logo->saveAs($fileDirectory.$newname);
				$model->logo = $newname;
		        if ($oldfilename != ''&& file_exists(Yii::getPathOfAlias('webroot.uploads.images/business/originals').DIRECTORY_SEPARATOR.$oldfilename)) {
		        	 unlink($fileDirectory. $oldfilename);
					CustomImage::customUnlink($oldfilename,'business');
		        }
				
		    }   
		    
			if($model->save()){
				$profile->business_id=$model->id;
				$profile->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$ct = new CustomTool;
		$category = $ct->getCategoryList();
		$this->render('create',array(
			'model'=>$model, 
			'profile'=>$profile,'category'=>$category
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdatelogo($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Business']))
		{
			
			$oldfilename = $model->logo;
			$model=$this->loadModel($id);
			$file =CUploadedFile::getInstance($model,'logo');
			if (is_object($file) && get_class($file)==='CUploadedFile') {
				$model->logo = $file;
				 $newname = time().".".Yii::app()->user->id.".".strtolower($file->extensionName);
			}else{
				$model->logo = $oldfilename;
			}
		    if (is_object($file) && get_class($file)==='CUploadedFile') {

		        $fileDirectory = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'images/business/originals/';
					
		        $model->logo->saveAs($fileDirectory.$newname);
				$model->logo = $newname;
		        if ($oldfilename != ''&& file_exists(Yii::getPathOfAlias('webroot.uploads.images/business/originals').DIRECTORY_SEPARATOR.$oldfilename)) {
		        	 unlink($fileDirectory. $oldfilename);
					CustomImage::customUnlink($oldfilename,'business');
		        }

		    }   
		}
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		
	} 
	public function actionUpdate($id)
	{
		
		$model=$this->loadModel($id);
		$profile=$model->businessprofile;
		$this->performAjaxValidation(array($model,$profile));
		if(!CustomTool::isBusinessOwner($model->user_id))
			$this->redirect(array('business/view','id'=>$model->id));
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Business']))
		{
			$oldfilename = $model->logo;
			$model->attributes=$_POST['Business'];
			$profile->attributes=$_POST['Businessprofile'];
			if($model->category!='')
				$model->category = implode(':',$model->category);
			$file =CUploadedFile::getInstance($model,'logo');
			if (is_object($file) && get_class($file)==='CUploadedFile') {
				$model->logo = $file;
				 $newname = time().".".Yii::app()->user->id.".".strtolower($file->extensionName);
			}else{
				$model->logo = $oldfilename;
			}
		    if (is_object($file) && get_class($file)==='CUploadedFile') {

		        $fileDirectory = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'images/business/originals/';
					
		        $model->logo->saveAs($fileDirectory.$newname);
				$model->logo = $newname;
		        if ($oldfilename != ''&& file_exists(Yii::getPathOfAlias('webroot.uploads.images/business/originals').DIRECTORY_SEPARATOR.$oldfilename)) {
		        	 unlink($fileDirectory. $oldfilename);
					CustomImage::customUnlink($oldfilename,'business');
		        }

		    }   

			if($model->save()){
				$profile->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		if($model->category!=null)
		{
			$model->category = explode(':',$model->category);
		}
		$ct = new CustomTool;
		$category = $ct->getCategoryList();
		$this->render('update',array(
			'model'=>$model,'profile'=>$profile, 'category'=>$category
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Business');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionSearch()
	{
		
		$businesses = null;
		$biscuit = null;
		if(isset($_GET['searchname']))
		{
			
			if(isset($_GET['searchname']) && $_GET['searchname']!=''){
				$biscuit = $_GET['searchname'];
				//CustomCookie::putInAJar($biscuit,5);//5 = number of key search stored
				
				$searchCtrl = new SearchController();
				$businesses = $searchCtrl->search($biscuit);
				print_r($businesses);exit;
			}
		    /*
		    $businesses=new CActiveDataProvider('Business',array(
						'criteria' => array(
						'order' => 'id DESC',
						'condition'=>'businessname LIKE :match',
						'params'    => array(':match' => "%$keyword%")
					),
					'pagination'=>array('pageSize'=>'32'),
					)
			);
		    */
		    
			$this->render('search',array('b_list'=>$businesses,'keyword'=>$biscuit));
		}
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Business('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Business']))
			$model->attributes=$_GET['Business'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->with('profile')->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param Business $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='business-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
