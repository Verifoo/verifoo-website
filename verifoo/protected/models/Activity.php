<?php

/**
 * This is the model class for table "activity".
 *
 * The followings are the available columns in table 'activity':
 * @property string $id
 * @property string $creator
 * @property integer $action_no
 * @property string $datecreated
 * @property integer $creatortype
 * @property integer $viewedby
 */
class Activity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'activity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creator, action_no, datecreated, creatortype', 'required'),
			array('action_no, creatortype, viewedby', 'numerical', 'integerOnly'=>true),
			array('creator', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, creator, action_no, datecreated, creatortype, viewedby', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'creator' => 'Creator',
			'action_no' => 'Action No',
			'datecreated' => 'Datecreated',
			'creatortype' => 'Creatortype',
			'viewedby' => 'Viewedby',
		);
	}
	public function getAllactivities($actorId, $offset = 0)
	{
		$result = Yii::app()->db->createCommand()
			    ->select("a.created_date, a.id,  a.subject_id, nf.actor_id, nf.object_id, nf.type_id, pr.firstname AS actor_name, pr.lastname AS last_name, actor.image")
				->FROM ('activity a')
				->leftJoin('users actor','nf.actor_id = actor.id')
				->leftJoin('profiles pr','actor.id = pr.user_id')
				->where('actor_id = :actor_id', array(':actor_id'=>$actorId))
				->group('created_date')
				->order('nf.id DESC')
				->queryAll();
		$rows = array();
		$activities = array();
		if(sizeof($result)>0){
			foreach($result as $res){
				$model = Notification::model()->findByPk($res['id']);
				$res['lastname'] = $res['last_name'];
				$res['image'] = $res['image'];
				if($res['image']!=null && file_exists(Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads/images/users/thumbs/60x90/'.$res['image']))
					$res['image'] = Yii::app()->baseUrl.'/uploads/images/users/thumbs/60x90/'.$res['image'];
				else
					$res['image'] = Yii::app()->baseUrl.'/uploads/images/users/thumbs/60x90/no-image.jpg';
				
				$res['object'] = $model->getObjectRow($res['type_id'], $res['object_id']);
				
				$activity = array('message' => $model->getNotificationMessage($res).'<span class="smallestText">'.date('h:i a' ,strtotime($res['created_date'])).'</span>',
					'actor_id' => $res['actor_id'],
					'subject_id' => $res['subject_id'],
					'object' => $res['object_id'],
					'created_date' => date('F d, Y' ,strtotime($res['created_date'])),
					'image' => $res['image']);
				
				if(date("Y-m-d",strtotime($res['created_date'])) == date("Y-m-d")){
					$activities['today'][] = $activity;
				}elseif(date("Y-m-d",strtotime($res['created_date']))==date("Y-m-d", strtotime("-1 day"))){
					$activities['yesterday'][] = $activity;
				}else
					$activities[date("F d",strtotime($res['created_date']))][] = $activity;
				
			}
		}
		return $activities;
	}
	public static function saveActivity($actor, $action_no, $creatortype)
	{
		$activity = new Activity;
		$activity->creator = $actor;
		$activity->action_no = $action_no;
		$activity->creatortype = $creatortype;
		$activity->datecreated = date("Y-m-d H:i:s");
		$activity->save();
	}
	protected function getActivityMessage($row){
		switch($row['type_id']){
			
			case 1://1
				return "<span class='xsp001'> {$row['actor_name']} commented on {$row['subject_name']} status {$row['object']['status']}</span>";
			case self::NOTIFY_RECOVERY_PASSWORD://2
				return "<span class='xsp001'> {$row['actor_name']} {$row['lastname']}</span> <span>requested to recover his/her password.</span> "; 
			case self::NOTIFY_CREATE_ASSET://3
				$asset = Asset::model()->findByPk($row['object_id']);
				
				$createdFor = CustomTool::generateFullname($asset['user_owned']);
				return "<span style='font-weight:bold;color:#2898C0;'>{$row['actor_name']} {$row['lastname']}</span> <span>created an asset for </span><span style='font-weight:bold;color:#2898C0;'> ".ucwords($createdFor).".</span> ";
			case self::NOTIFY_OWNED_ASSET://4
				return "<span class='xsp001'> {$row['actor_name']} {$row['lastname']}</span> <span>created an asset for you.</span></span> ";	
			case self::NOTIFY_UPDATE_ASSET://5
				$asset = Asset::model()->findByPk($row['object_id']);
				
				$createdFor = CustomTool::generateFullname($asset['user_owned']);
				return "<span class='xsp001'> {$row['actor_name']} {$row['lastname']}</span> <span>updated an asset for </span><span style='font-weight:bold;color:#2898C0;'> ".ucwords($createdFor).".</span> ";	
			case self::NOTIFY_UPDATEOWNED_ASSET://6
				return "<span class='xsp001'> {$row['actor_name']} {$row['lastname']}</span> <span>updated your asset.</span></span> ";
			/* case 7-3: password recovery and asset*/	
			case self::NOTIFY_CREATE_REPORT://7
				$networkincident = Networkincident::model()->findByPk($row['object_id']);
				$createdFor = CustomTool::generateFullname($networkincident['asset_owner']);
				return "<span class='xsp001'> {$row['actor_name']} {$row['lastname']}</span> <span>create an incident report for </span><span style='font-weight:bold;color:#2898C0;'> ".ucwords($createdFor).".</span> ";		
			case self::NOTIFY_RESOLVED_REPORT://8
				$networkincident = Networkincident::model()->findByPk($row['object_id']);
				
				$createdFor = CustomTool::generateFullname($networkincident['asset_owner']);
				return "<span class='xsp001'> {$row['actor_name']} {$row['lastname']}</span> <span>resolved an incident report for </span><span style='font-weight:bold;color:#2898C0;'> ".ucwords($createdFor).".</span> ";		
			case self::NOTIFY_CREATE_OWNERREPORT://9
				return "<span class='xsp001'> {$row['actor_name']} {$row['lastname']} </span> <span>created an incident report for your asset.</span> ";
			case self::NOTIFY_OWNER_FOR_RESOLVED_REPORT://10
				return "<span class='xsp001'> {$row['actor_name']} {$row['lastname']} </span><span>resolved incident report for you.</span> ";	
			case self::NOTIFY_SYSAD_FOR_NEW_INCIDENT: //11
				return "<span class='xsp001'> {$row['actor_name']} {$row['lastname']} </span> <span> created an incident report.</span> ";
		}
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('creator',$this->creator,true);
		$criteria->compare('action_no',$this->action_no);
		$criteria->compare('datecreated',$this->datecreated,true);
		$criteria->compare('creatortype',$this->creatortype);
		$criteria->compare('viewedby',$this->viewedby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Activity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
