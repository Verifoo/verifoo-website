<?php

class SearchController extends Controller
{
	public $layout='//layouts/searchlayout';
	
	public function actionIndex()
	{
		
		$businesses = null;
		$biscuit = null;
		$searchkeywords = null;
		$except = 0;
		$recommend = '';
		if(isset($_GET['searchname']) && $_GET['searchname']!='')
		{
			
				$biscuit = $_GET['searchname'];
				CustomCookie::putInAJar($biscuit,5);//5 = number of key search stored
				
			  	$businesses = CustomSearch::searchControl($biscuit);
				if(sizeof($businesses)==0 || $businesses->getTotalItemCount() ==0){
					$recommend = 'No result found but we recommend some businesses';
					$businesses=new CActiveDataProvider('Business', array(
					    'criteria'=>array(
					    		'alias'=>'business',
					    		'condition'=>'status>=0',
					    		'order' => 'business.datecreated DESC',
					    ),
					    'pagination'=>array('pageSize'=>'2'),
					));	
				}
		}else{
			$recommend = 'We recommend some businesses';
			$businesses=new CActiveDataProvider('Business', array(
				    'criteria'=>array(
				    		'alias'=>'business',
				    		'condition'=>'status>=0',
				    		'order' => 'business.datecreated DESC',
				    ),
				    'pagination'=>array('pageSize'=>'2'),
				));
		}
		$this->render('index',array('b_list'=>$businesses,'keyword'=>$biscuit,'recommend'=>$recommend));
	}
	public function actionCard()
	{
		if(!isset($_GET['id']))
			 $this->redirect(Yii::app()->homeUrl);
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile('http://maps.google.com/maps/api/js?sensor=false');//use for google map API
		
		$model = Business::model()->with('businessprofile')->findByPK($_GET['id']);
		CustomCookie::putInDeck($model->id);
		$businesses = array();
		$biscuit = null;	
		
		if(isset($_GET['search']) && $_GET['search']!=''){
			
				$biscuit = $_GET['search'];
			  	$businesses = CustomSearch::searchControl($biscuit,$model->id);
		}
		$this->render('card',array('b_list'=>$businesses,'keyword'=>$biscuit,'model'=>$model,'profile'=>$model->businessprofile));
	}
	public function actionProcesscard(){
		if(isset($_GET['data_id']) && $_GET['data_id']!='')
		{	
			$pID = trim($_GET['data_id']);
		  	$model=Business::model()->with('businessprofile')->findByPk($pID);
			if(is_object($model) && sizeof($model)>0)
			{	$lat = $long = '';
				if(isset($model->businessprofile->latitude))
					$lat = $model->businessprofile->latitude;
				if(isset($model->businessprofile->longitude))
					$long = $model->businessprofile->longitude;
				
				echo '<h2 id="bsearchSpan" business-data="'.$model->id.'" business-name="'.$model->businessname.'">'.$model->businessname.'<div class="bStars">
						<div class="star" style="width:'.(16*round($model->reviewAve)).'px"></div>
					</div><div class="socialsites">';
				
				if(isset($model->businessprofile->facebook_page) && $model->businessprofile->facebook_page!=''):
				  echo '<a href="https://www.facebook.com/'.$model->businessprofile->facebook_page.'" target="_blank"><img src="'.Yii::app()->getBaseUrl(true).'/images/facebook_icon.png"></a>';
				endif;
				if(isset($model->businessprofile->twitter_page) && $model->businessprofile->twitter_page!=''):
				 echo '<a href="https://twitter.com/'.$model->businessprofile->twitter_page.'" target="_blank"><img src="'.Yii::app()->getBaseUrl(true).'/images/twitter_icon.png"></a>';
				endif;
				if(isset($model->businessprofile->gplus_page) && $model->businessprofile->gplus_page!=''):
				  echo '<a href="https://plus.google.com/'.$model->businessprofile->gplus_page.'" target="_blank"><img src="'.Yii::app()->getBaseUrl(true).'/images/google_icon.png"></a>';
				endif;
				echo "</div>	
				</h2>
				<div>
					<div class='cvBprofile'>";
						$this->widget('ext.SAImageDisplayer', array(
									    'image' => $model->logo,
									    'size' => 'p240',
									    'group' => 'business',
									    'defaultImage' => 'default.jpg',
									));
					
				echo "
					</div>
				<div class='cvBdesc'>";
				if($model->businessprofile->dti_number!=''):
					echo '<p class="businessfield">DTI No.: <span class="lightblue" id="dti_number">'.ucwords($model->businessprofile->dti_number).'</span></p>';
				endif;
				echo '<p class="businessfield">Open Schedule: <span class="lightblue" id="openschedule">'.ucwords($model->businessprofile->openschedule).'</span></p>';
				if($model->businessprofile->website!=''):
					echo '<p class="businessfield">Website: <span class="lightblue" id="website">'.ucwords($model->businessprofile->website).'</span></p>';
				endif;
					echo '<p class="businessfield">Contact #: <span class="lightblue" id="phonenumber">'.$model->phonenumber.'</span></p>';
					echo '<p class="businessfieldBlock">Address: <span class="lightblue" id="address">'.ucwords($model->address).'</span></p>';
						
				echo '</div>
					<div class="cvbD">
							<div id="map'.$model->id.'" business-map-lat="'.$lat.'" business-map-long="'.$long.'"></div>
							<a href="'.Yii::app()->createUrl('business/photos', array('id' => $model->id)).'"><div id="business'.$model->id.'" business-data="'.$model->id.'" business-toggle="0" class="cvBButtons">Photos</div></a>
							<a href="'.Yii::app()->createUrl('business/view', array('id' => $model->id, '#' => "reviews")).'"><div id="business'.$model->id.'" business-data="'.$model->id.'>" business-toggle="0" class="cvBButtons">Reviews</div></a>
					</div>
					<div class="cvBDescription">'.$model->description.'
					</div>
					';
					if($model->category!=''):
							$category = explode(":", $model->category);
					echo '<div id="mapCanvas"></div>';
						echo  '<h4>Related to '.ucfirst($model->businessname).'</h4>
						<ul class="related">';
							foreach($category as $cat):
								echo '<li><a href="'.Yii::app()->createUrl('search/index', array('searchname'=>strtolower($cat), 'except'=>$model->id)).'">'.$cat.'</a></li>';
							endforeach;
						echo '</ul>';
					endif;
				echo '</div>';
			}
			
		}
		else{
			echo 'false';
		}
	}
	
}