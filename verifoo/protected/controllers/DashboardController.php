<?php

class DashboardController extends RController
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	 
	public $layout='//layouts/main'; 
	private $_model;
	/**
	 * @return array action filters
	 */
	
	public function filters()
	{
		return array(
			'rights',
			);
	}
	 
	
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
				'select'=>'username, lastvisit_at',
		        'condition'=>'status>'.User::STATUS_BANNED.' AND lastvisit_at >= DATE_SUB( NOW() , interval 24 hour)',
		        'order'=>'lastvisit_at ASC'
		    ),
				
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));
		
		
		$data=new CActiveDataProvider('User', array(
		    'criteria'=>array('condition'=>'status=0',
		    'with'=>array('profile'=>array('alias'=>'profile','with'=>array('team'=>array('alias'=>'team')))),
		    ),
		    'pagination'=>array('pageSize'=>'10'),
		));			    
		$withSched = Yii::app()->db->createCommand()
					    ->select('sc.userid')
					    ->from('schedules sc')
						->where('sc.dateend>:today', array(':today'=>date('Y-m-d H:i:s')))
					    ->queryAll();
		foreach($withSched as $res_id):
                                $result_ids[] = "'".$res_id['userid']."'";
        endforeach;
		$waitingforSched=new CActiveDataProvider('User', array(
		    'criteria'=>array(
			    'condition'=>'status=1 AND (schedules.dateend<NOW() OR schedules.dateend IS NULL) AND user.id NOT IN ('.implode(",",$result_ids).')',
			    'with'=>array('schedules'),
			    'together' => true,
			    'distinct'=>true,
		    ),
		    'pagination'=>array('pageSize'=>'5'),
		));	
		
		$newsDataProvider=new CActiveDataProvider('News',array(
						'criteria' => array(
						'order' => 'id DESC',
						//'condition'=>'id !='.$first->id,
					),
					'pagination'=>array('pageSize'=>'3'),
					)
		);
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'membersnotactive' =>$data,
			'waitingforSched' =>$waitingforSched,
			'newsDataProvider' =>$newsDataProvider,
		));
	}
	public function actionApprove($id)
	{
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($id)&& isset($_POST))
		{
			$usr = User::model()->findByPk($id);
			$usr->status = 1;
			$usr->save();			
		}
	}
	public function actionViewAllmembers()
	{
		$post=User::model()->find('user_id=:postID', array(':postID'=>Yii::app()->user->id));
		
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
				'select'=>'username, lastvisit_at',
		        'condition'=>'status>'.User::STATUS_BANNED.' AND superuser='.$post->superuser.' AND id!='.Yii::app()->user->id,
		        'order'=>'lastvisit_at ASC'
		    ),
				
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
		$model = new User;
		 $this->render('viewallmembers',array(
            'members'=>$dataProvider,'model'=>$model
        ));
	}
	public function actionSeekingapproval()
	{
		
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
				'select'=>'username, lastvisit_at',
		        'condition'=>'status>'.User::STATUS_NOACTIVE,
		        'order'=>'id ASC'
		    ),
				
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));
		
		$count = User::model()->countByAttributes(array(
            'status'=> 0
        ));
		$data = Yii::app()->db->createCommand()
					    ->select('u.username, u.image,p.firstname,p.lastname,p.position,p.gender,t.teamname')
					    ->from('users u')
						->leftJoin('profiles p','u.id=p.user_id')
						->leftJoin('team t','p.team_id=t.id')
						->where('u.status=:stat', array(':stat'=>1))
					    ->queryAll();
						
	print_r($data);exit;
						
		$this->render('seekingapproval',array(
			'dataProvider'=>$dataProvider,
			'countNotActive'=>$count,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
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


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	public function getForecast($date) {
		$health=Serverroom::model()->findByAttributes(array('checkeddate'=>$date->format('Y-m-d')));
		$conditions = '';
		if(sizeof($health)>0)
		{
			$conditions = $health->status;
		}
		
		 $weekdayIndex = $date->format('N') - 1;
		 if($weekdayIndex < 5) {
		    $temperature = rand(0, 15) . ' °C';
		 } else {
		    $temperature = rand(20, 30) . ' °C';
		 }
		 
		 return array(
		    'temperature' => $temperature,
		    'conditions' => $conditions,
		 );
	}
	public function actionSendstat() {
		
		if(isset($_GET['stat']) && $_GET['stat']!='')
		{	
			$stat = trim(addslashes($_GET['stat']));
		}
		if(isset($_GET['checkday']) && $_GET['checkday']!='')
		{	
			$checkday = trim(addslashes($_GET['checkday']));
		}
		
		$alreadyChecked=Serverroom::model()->findByAttributes(array('checkeddate'=>$checkday));
		if(sizeof($alreadyChecked)>0)
		{
			if($alreadyChecked->status !=$stat && ($stat==Serverroom::STATUS_NOT || $stat == Serverroom::STATUS_OK))
			{
				$alreadyChecked->status = $stat;
				$alreadyChecked->addedby = Yii::app()->user->id;
				$alreadyChecked->save();
				
				
				$model1 = new ServerroomComment;
				$model1->server_id = $alreadyChecked->id;
				$model1->user_id = Yii::app()->user->id;
				$model1->comment = ucwords(CustomTool::generateFullname($model1->user_id))." updated the Server Room status: ";
				$model1->state = $stat;
				$model1->datecomment = date("Y-m-d H:i:s");
				$model1->save();
				$json = CJSON::encode($model1);
				echo $json;
			}
		}else{
			if($stat==Serverroom::STATUS_NOT || $stat == Serverroom::STATUS_OK)
			{
				$server = new Serverroom;
				$server->addedby = Yii::app()->user->id;
				$server->status = $stat;
				$server->checkeddate = $checkday;
				$server->save();
				
				$model = new ServerroomComment;
				$model->server_id = $server->id;
				$model->user_id = $server->addedby;
				$model->state = $stat;
				$model->datecomment = date("Y-m-d H:i:s");
				$model->comment = ucwords(CustomTool::generateFullname($model->user_id))." checked the Server Room status: ";
				$model->save();
				$json = CJSON::encode($model);
				echo $json;
			}
		}
		
	}
	public function actionCheckdevice() {
		
		if(isset($_GET['device']) && $_GET['device']!='')
		{	
			$device = trim(addslashes($_GET['device']));
		}
		
		
		$deviceObj=Peripherals::model()->findByPk($device);
		if(sizeof($deviceObj)>0)
		{
			echo CJSON::encode(array('quantity'=>$deviceObj->quantity)); 
		}
		
	}
	public function actionSendhardware() {
		
		$model=new Peripherals;             
        $this->performAjaxValidation($model);  
        
        if(isset($_POST['Peripherals']))
        {
                $model->attributes=$_POST['Peripherals'];
                $valid=$model->validate();            
                if($valid){
                	if(isset($_POST['Peripherals']))
					{
						$model->attributes=$_POST['Peripherals'];
						$model->save();
						echo CJSON::encode(array('status'=>'success','devicename'=>$model->devicename, 'quantity'=>$model->quantity, 'id'=>$model->id));
                    	Yii::app()->end();		
					}
                 echo CJSON::encode(array('status'=>'validNotSave')); 
                }
                else{
                    $error = CActiveForm::validate($model);
                    if($error!='[]')
                        echo $error;
                    Yii::app()->end();
                }
       }
	}
	public function actionUpdatehardware() {
		
		if(isset($_POST['Peripherals']))
        {
        		$post=Peripherals::model()->findByPk($_POST['Peripherals']['devicename']);
				
        		$this->performAjaxValidation($post);
				  	
				$post->quantity = $_POST['Peripherals']['quantity'];	
                $valid=$post->validate();            
                if($valid){
                	if(isset($post) && sizeof($post)>0)
					{
						$post->save();
						echo CJSON::encode(array('status'=>'success','devicename'=>$post->devicename, 'quantity'=>$post->quantity, 'id'=>$post->id));
                    	Yii::app()->end();		
					}
                 echo CJSON::encode(array('status'=>'validNotSave')); 
                }
                else{
                    $error = CActiveForm::validate($post);
                    if($error!='[]')
                        echo $error;
                    Yii::app()->end();
                }
       }
	}
	public function actionAssignhardware() {
		
		$model=new PeripheralAssignments;             
        $this->performAjaxValidation($model);  
        
        if(isset($_POST['PeripheralAssignments']))
        {
                $model->attributes=$_POST['PeripheralAssignments'];
				$model->date_assigned = date('Y-m-d H:i:s');
				$model->assigned_by = Yii::app()->user->id;
                if($model->validate()){
						$model->save();
						$this->redirect(array('../profiles/view','id'=>$model->user_id,'component'=>$model->id,'_x101'=>'hardware'));
					
                }
               
       }
	}
	/**
	 * Performs the AJAX validation.
	 * @param Kudos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && ($_POST['ajax']==='hardware-form' || $_POST['ajax']==='hardwareupdate-form'))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
