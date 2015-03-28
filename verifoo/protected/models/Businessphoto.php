<?php

/**
 * This is the model class for table "businessphoto".
 *
 * The followings are the available columns in table 'businessphoto':
 * @property string $id
 * @property string $business_id
 * @property integer $photo_owner
 * @property string $photoname
 * @property string $description
 * @property integer $status
 * @property string $dateuploaded
 *
 * The followings are the available model relations:
 * @property Users $photoOwner
 * @property Business $business
 */
class Businessphoto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'businessphoto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('business_id, photo_owner, photoname, dateuploaded', 'required'),
			array('photo_owner, status', 'numerical', 'integerOnly'=>true),
			array('business_id', 'length', 'max'=>20),
			array('photoname', 'length', 'max'=>100),
			array('description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, business_id, photo_owner, photoname, description, status, dateuploaded', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'photo_owner'),
			'business' => array(self::BELONGS_TO, 'Business', 'business_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'business_id' => 'Business',
			'photo_owner' => 'Photo Owner',
			'photoname' => 'Photoname',
			'description' => 'Description',
			'status' => 'Status',
			'dateuploaded' => 'Dateuploaded',
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
		$criteria->compare('business_id',$this->business_id,true);
		$criteria->compare('photo_owner',$this->photo_owner);
		$criteria->compare('photoname',$this->photoname,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('dateuploaded',$this->dateuploaded,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Businessphoto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
