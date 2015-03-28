<?php

/**
 * RateForm class.
 * RateForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'BusinessController'.
 */
class RateForm extends CFormModel
{
	public $rate;
	public $comment;
	public $business_id;
	public $review_id;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('rate, comment, business_id, review_id', 'required'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'rate'=>'Roll over stars to rate',
			'comment'=>'Comment',
		);
	}
}