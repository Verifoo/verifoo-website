<?php

/**
 * This is the model class for table "business".
 *
 * The followings are the available columns in table 'business':
 * @property string $id
 * @property integer $user_id
 * @property string $businessname
 * @property string $description
 * @property string $address
 * @property string $views
 * @property string $category
 * @property string $zipcode
 * @property integer $dti_verified
 * @property integer $status
 * @property string $phonenumber
 * @property string $logo
 * @property string $slug
 * @property string $datecreated
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Businessfollow[] $businessfollows
 * @property Businessphoto[] $businessphotos
 */
class Business extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'business';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, businessname, address, views, zipcode, dti_verified, datecreated', 'required'),
			array('user_id, dti_verified, status', 'numerical', 'integerOnly'=>true),
			array('businessname, phonenumber', 'length', 'max'=>50),
			array('address, category, slug', 'length', 'max'=>255),
			array('views', 'length', 'max'=>20),
			array('zipcode', 'length', 'max'=>10),
			array('logo', 'length', 'max'=>100),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, businessname, description, address, views, category, zipcode, dti_verified, status, phonenumber, logo, slug, datecreated', 'safe', 'on'=>'search'),
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
			'businessfollows' => array(self::HAS_MANY, 'Businessfollow', 'business_id'),
			'businessphotos' => array(self::HAS_MANY, 'Businessphoto', 'business_id'),
			'businessprofile' => array(self::HAS_ONE, 'Businessprofile', 'business_id'),
			'reviewAve'=>array(self::STAT, 'Review', 'business_id', 'select' => 'AVG(rate)'),
			'reviewCount'=>array(self::STAT, 'Review', 'business_id'),
		);
	}

	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),
           
        );
    }
	
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'businessname' => 'Businessname',
			'description' => 'Description',
			'address' => 'Address',
			'views' => 'Views',
			'category' => 'Category',
			'zipcode' => 'Zipcode',
			'dti_verified' => 'DTI Verified',
			'logo' => 'Logo',
			'slug' => 'Slug',
			'datecreated' => 'Date Created',
			'phonenumber' => 'Contact Number',
		);
	}
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'BusinessStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not Active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'DTIStatus' => array(
				'0' => UserModule::t('DTI Unverified'),
				'1' => UserModule::t('DTI Verified'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
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
		$criteria->with = array('user');
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('businessname',$this->businessname,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('t.address',$this->address,true);
		$criteria->compare('views',$this->views,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('t.zipcode',$this->zipcode,true);
		$criteria->compare('dti_verified',$this->dti_verified);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('datecreated',$this->datecreated,true);
		$criteria->compare('phonenumber',$this->phonenumber,true);
		$criteria->compare('user.username',$this->business_creator,true);
		$criteria->compare('user.email',$this->email,true);
		$criteria->compare('t.status',$this->status,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Business the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
