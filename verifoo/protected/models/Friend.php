<?php

/**
 * This is the model class for table "friend".
 *
 * The followings are the available columns in table 'friend':
 * @property string $id
 * @property string $inviteby
 * @property string $user_id
 * @property string $friend_id
 * @property integer $confirm
 * @property string $dateadded
 */
class Friend extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'friend';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inviteby, user_id, friend_id, dateadded', 'required'),
			array('confirm', 'numerical', 'integerOnly'=>true),
			array('inviteby, user_id, friend_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, inviteby, user_id, friend_id, confirm, dateadded', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'inviteby' => 'Inviteby',
			'user_id' => 'User',
			'friend_id' => 'Friend',
			'confirm' => 'Confirm',
			'dateadded' => 'Dateadded',
		);
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
		$criteria->compare('inviteby',$this->inviteby,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('friend_id',$this->friend_id,true);
		$criteria->compare('confirm',$this->confirm);
		$criteria->compare('dateadded',$this->dateadded,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Friend the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
