<?php

/**
 * This is the model class for table "businessprofile".
 *
 * The followings are the available columns in table 'businessprofile':
 * @property string $business_id
 * @property string $website
 * @property string $openschedule
 * @property string $foundeddate
 * @property string $facebook_page
 * @property string $twitter_page
 * @property string $gplus_page
 * @property string $latitude
 * @property string $longitude
 * @property string $dti_number
 */
class Businessprofile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'businessprofile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('business_id', 'required'),
			array('business_id', 'length', 'max'=>20),
			array('website, facebook_page, twitter_page, gplus_page, dti_number, latitude, longitude', 'length', 'max'=>50),
			array('openschedule', 'length', 'max'=>100),
			array('foundeddate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('business_id, website, openschedule, foundeddate, facebook_page, twitter_page, gplus_page, latitude, longitude, dti_number', 'safe', 'on'=>'search'),
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
			'business'=>array(self::BELONGS_TO, 'Business', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'business_id' => 'Business',
			'website' => 'Website',
			'openschedule' => 'Openschedule',
			'foundeddate' => 'Foundeddate',
			'facebook_page' => 'Facebook Page',
			'twitter_page' => 'Twitter Page',
			'gplus_page' => 'Gplus Page',
			'gplus_page' => 'Gplus Page',
			'latitude' => 'Latitude (for your business map)',
			'longitude' => 'Longitude (for your business map)',
			'dti_number' => 'Dti Number',
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

		$criteria->compare('business_id',$this->business_id,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('openschedule',$this->openschedule,true);
		$criteria->compare('foundeddate',$this->foundeddate,true);
		$criteria->compare('facebook_page',$this->facebook_page,true);
		$criteria->compare('twitter_page',$this->twitter_page,true);
		$criteria->compare('gplus_page',$this->gplus_page,true);
		$criteria->compare('dti_number',$this->dti_number,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Businessprofile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
