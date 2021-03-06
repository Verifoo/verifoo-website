<?php
class CustomCookie{
	
	public static function putInAJar($keyword,$numofKeysearch){
					
				$cookieJar = Yii::app()->request->getCookies();
				if(CustomCookie::checkifExists($cookieJar, $keyword, $numofKeysearch)==false)
				{
						if(isset($cookieJar['keycounter'])){
							$keycount=($cookieJar['keycounter']->value)+1;
							if($keycount>=$numofKeysearch){
								$keycount = ($numofKeysearch-1);
								CustomCookie::reloop($cookieJar,$numofKeysearch);
							}
							
						}else{
							
							$keycount=0;
							$ctr_cookie = new CHttpCookie('keycounter',$keycount,array('expire'=>(time()+(365*86400)), 'path'=>'/'));
						}
						
						$ctr_cookie = new CHttpCookie('keycounter',$keycount,array('expire'=>(time()+(365*86400)), 'path'=>'/'));
						$cookiejar = Yii::app()->request->getCookies();//get all the cookies
						$cookiejar['mycounter'] = $ctr_cookie;
						$kstring = "keysearch[".$keycount."]";
						$cookie = new CHttpCookie($kstring,$keyword,array('expire'=>(time()+(365*86400)), 'path'=>'/'));
						$cookiejar = Yii::app()->request->getCookies();//get all the cookies
						$cookiejar[$kstring] = $cookie;
				}	
				
	}
	public static function reloop($cookieJar){
		if(isset($cookieJar['keysearch'])){
				//print_r($cookieJar['keysearch']->value);exit;
				foreach($cookieJar['keysearch']->value as $key =>$val)
				{
					if($key<(sizeof($cookieJar['keysearch']->value)-1)){
						$kstring = "keysearch[".$key."]";
						$keyword = $cookieJar['keysearch']->value[$key+1];
						$cookie = new CHttpCookie($kstring,$keyword,array('expire'=>(time()+(365*86400)), 'path'=>'/'));
						$cookiejar = Yii::app()->request->getCookies();//get all the cookies
						$cookiejar[$kstring] = $cookie;
					}
				}
		}
	}
	public static function getKeywords($numofKeysearch)
	{
		$cookieJar = Yii::app()->request->getCookies();
		$keys = array();
		if(isset($cookieJar['keysearch']))
			foreach($cookieJar['keysearch']->value as $val)
			{
				$keys[] = $val;
			}
		
		return $keys;
	}
	public static function checkifExists($cookieJar,$keyword,$numofKeysearch)
	{
			if(isset($cookieJar['keysearch']))
				foreach($cookieJar['keysearch']->value as $val)
				{
					if(strtolower($val) == strtolower($keyword)){
						return true;
					}
				}
		return false;
	}
}
