<?php
class CustomImage{
	
	public static function customUnlink($oldfilename,$group)
	{
		if($group == 'users'){
			$usersDir = (Yii::app()->getComponent('widgetFactory')->widgets['SAImageDisplayer']['groups']['users']);
			foreach($usersDir as $folder =>$contain)
			{
				$file = Yii::getPathOfAlias('webroot.uploads.images/users/'.$folder).DIRECTORY_SEPARATOR.$oldfilename;
				if(file_exists($file))
					unlink($file);
			}
		}elseif($group == 'news'){
			$newsDir = (Yii::app()->getComponent('widgetFactory')->widgets['SAImageDisplayer']['groups']['news']);
			foreach($newsDir as $folder =>$contain)
			{
				$file = Yii::getPathOfAlias('webroot.uploads.images/news/'.$folder).DIRECTORY_SEPARATOR.$oldfilename;
				if(file_exists($file))
					unlink($file);
			}
		}
		elseif($group == 'business'){
			$businessDir = (Yii::app()->getComponent('widgetFactory')->widgets['SAImageDisplayer']['groups']['business']);
			foreach($businessDir as $folder =>$contain)
			{
				$file = Yii::getPathOfAlias('webroot.uploads.images/business/'.$folder).DIRECTORY_SEPARATOR.$oldfilename;
				if(file_exists($file))
					unlink($file);
			}
		}
	}
	
	public static function chkAndCreateDir($dir)
	{
		if(!file_exists($dir) && !is_dir($dir)){
		    mkdir($dir,0777);
		}
	}
	
}
