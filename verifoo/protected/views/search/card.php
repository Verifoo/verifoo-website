<?php

if(isset($profile->latitude) && $profile->latitude!='')
	$lat = $profile->latitude;
else
	$lat = '';
if(isset($profile->longitude) && $profile->longitude!='')
	$long = $profile->longitude;
else
	$long = '';
?>
<div id="searchLCol">

<?php if(sizeof($b_list)>0):?>

<div class="searchBlist">
		<?php if(sizeof($b_list)>0):?>
					
						<?php $this->widget('zii.widgets.CListView', array(
							'dataProvider'=>$b_list,
							'itemView'=>'_searchBlist',
							'template'=>'{pager}{items}{pager}',
							'enablePagination'=>true,
							'pager' => array('class' => 'CLinkPager', 'header' => '','maxButtonCount' => 3),
						)); 
					
						?>
				<?php endif;?>
</div>
<script type="text/javascript">
	$(document).ready(function()
		{
			jQuery(function($) {
				jQuery('body').on('click','.businesslist',function(){
					 var data_id = $(this).attr("business-data");
					 var viewed_card = $('#bsearchSpan').attr("business-data");
					 displayCard(data_id,viewed_card);
				});
			});
			
			
		});
	

function displayCard(data_id,viewed_card){
   var siteDomain = document.domain;
   var siteUrl = 'http://'+siteDomain;
   var urllink = siteUrl+'/search/processcard'; 
   var params = "data_id="+data_id+"viewed_id="+viewed_card;
   
   $.ajax({
            	type: "GET",
                url: urllink,
                async: true,
                timeout: 50000,
                data: params,
                success: function(data) {	
            		$("#businessRCol").html(data);
            		var newLat = $('#map'+data_id).attr("business-map-lat");
            		var newLong = $('#map'+data_id).attr("business-map-long");
            		var bname = $('#bsearchSpan').attr("business-name");
            		function initialize(){
					        var mapOptions = {
					            zoom: 16,
					            center: new google.maps.LatLng(newLat, newLong),
					            mapTypeId: google.maps.MapTypeId.ROADMAP};
					        map = new google.maps.Map(document.getElementById('mapCanvas'),mapOptions);
					        var marker = new google.maps.Marker({
							    position: map.getCenter(),
							    map: map,
							    title: bname
							  });
					    }
					    if(newLat!='' || newLong !=''){
						    $(window).bind('gMapsLoaded', initialize);
						    window.loadGoogleMaps();
					    }else{
					    	$("#mapCanvas").css("display","none");
					    }
            		return false;			
            	}
            });
   
   return false;
}

var gMapsLoaded = false;
window.gMapsCallback = function(){
    gMapsLoaded = true;
    $(window).trigger('gMapsLoaded');
}
window.loadGoogleMaps = function(){
    if(gMapsLoaded) return window.gMapsCallback();
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src","http://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback");
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
}

</script>	
<?php else:
	echo 'No keyword searched';	
endif;?>	
</div>
<script type="text/javascript">
		function initialize() {
  var myLatlng = new google.maps.LatLng(<?php echo $lat;?>, <?php echo $long;?>);
  var mapOptions = {
    zoom: 15,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('mapCanvas'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: '<?php echo $model->businessname;?>'
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>   
<div class="rColWrapper">
<div id="businessRCol">		
 	

<h2 id="bsearchSpan" business-data="<?php  echo $model->id;?>" business-name="<?php  echo $model->businessname;?>"><?php echo $model->businessname;?>
<div class="bStars">
	<div class="star" style="width:<?php echo (16*round($model->reviewAve));?>px"></div>
</div>
<div class="socialsites">
	<?php if(isset($profile->facebook_page) && $profile->facebook_page!=''):?>
				<a href="https://www.facebook.com/<?php echo $profile->facebook_page;?>" target="_blank"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/facebook_icon.png' ?>"></a>
	<?php endif;
		  if(isset($profile->twitter_page) && $profile->twitter_page!=''):?>
			<a href="https://twitter.com/<?php echo $profile->twitter_page;?>" target="_blank"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/twitter_icon.png' ?>"></a>
	<?php endif;
		  if(isset($profile->gplus_page) && $profile->gplus_page!=''):?>
			<a href="https://plus.google.com/<?php echo $profile->gplus_page;?>" target="_blank"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/google_icon.png' ?>"></a>
	<?php endif;?>
</div>	
</h2>
<div>
	<div class="cvBprofile">
					<?php $this->widget('ext.SAImageDisplayer', array(
					    'image' => $model->logo,
					    'size' => 'p240',
					    'group' => 'business',
					    'defaultImage' => 'default.jpg',
					)); ?>
		</div>
	<div class="cvBdesc">
		<?php if($profile->dti_number!=''):?>
		<p class="businessfield">DTI No.: <span class="lightblue" id="dti_number"><?php echo ucwords($profile->dti_number);?></span></p>
		<?php endif;?>
		<p class="businessfield">Open Schedule: <span class="lightblue" id="openschedule"><?php echo ucwords($profile->openschedule);?></span></p>
		<?php if($profile->website!=''):?>
		<p class="businessfield">Website: <span class="lightblue" id="website"><?php echo ucwords($profile->website);?></span></p>
		<?php endif;?>
		<p class="businessfield">Contact #: <span class="lightblue" id="phonenumber"><?php echo $model->phonenumber;?></span></p>
		<p class="businessfieldBlock">Address: <span class="lightblue" id="address"><?php echo ucwords($model->address);?></span></p>
		
	</div>
	<div class="cvbD">
			<div id="business<?php  echo $model->id;?>" business-map-lat="<?php  echo $profile->latitude;?>" business-map-long="<?php  echo $profile->longitude;?>"></div>
			<a href="<?php echo Yii::app()->createUrl('business/photos', array('id' => $model->id));?>"><div id="business<?php  echo $model->id;?>" business-data="<?php  echo $model->id;?>" business-toggle="0" class="cvBButtons">Photos</div></a>
			<a href="<?php echo Yii::app()->createUrl('business/view', array('id' => $model->id, '#' => "reviews"));?>"><div id="business<?php  echo $model->id;?>" business-data="<?php  echo $model->id;?>" business-toggle="0" class="cvBButtons">Reviews</div></a>
	</div>
	<div class="cvBDescription">
			<?php echo $model->description;?>
	</div>
	
	<?php if($model->category!=''):
			$category = explode(":", $model->category);
	?>
	<?php if($lat!='' || $long!=''):?>
	<div id="mapCanvas"></div>
	<?php endif;?>
		<h4>Related to <?php echo ucfirst($model->businessname);?></h4>
		<ul class="related">
			<?php foreach($category as $cat):?>
			<li><a href="<?php echo Yii::app()->createUrl('search/index', array('searchname'=>strtolower($cat), 'except'=>$model->id))?>"><?php echo $cat;?></a></li>
			<?php endforeach;?>
		</ul>
	<?php endif;?>
</div>

</div>
<div id="businessRColBottom" style="display:block;">
		<h2 id="prevView">Previous Views</h2>
		<div class="prevCards">
			
		</div>	
</div>
</div>
