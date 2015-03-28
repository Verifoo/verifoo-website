<?php
Yii::import('zii.widgets.CMenu', true);

class BusinessMenu extends CMenu
{
    public function init()
    {
        // Here we define query conditions.
        $criteria = new CDbCriteria;
        $items = Business::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
       	if(sizeof($items)>0){
	        foreach ($items as $item)
	            $this->items[] = array('label'=>$item->businessname, 'url'=>"../../business/".$item->id);
		}else{
			$this->items[] = array('label'=>'Create Business', 'url'=>"../../business/create");
		}
		parent::init();
    }
}

?>