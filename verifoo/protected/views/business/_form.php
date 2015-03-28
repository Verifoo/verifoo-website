<?php

if(isset($profile->latitude) && $profile->latitude!='')
	$lat = $profile->latitude;
else {
	$lat = 10.3156992;
}

if(isset($profile->longitude) && $profile->longitude!='')
	$long = $profile->longitude;
else {
	$long = 123.88543660000005;
}
?>

<script type="text/javascript">
		var geocoder = new google.maps.Geocoder();
		
		function geocodePosition(pos) {
		  geocoder.geocode({
		    latLng: pos
		  }, function(responses) {
		    if (responses && responses.length > 0) {
		      updateMarkerAddress(responses[0].formatted_address);
		    } else {
		      updateMarkerAddress('Cannot determine address at this location.');
		    }
		  });
		}
		
		function updateMarkerStatus(str) {
		 // document.getElementById('markerStatus').innerHTML = str;
		  
		}
		
		function updateMarkerPosition(latLng) {
		 /* document.getElementById('info').innerHTML = [
		    latLng.lat(),
		    latLng.lng()
		  ].join(', ');*/
		  document.getElementById('Businessprofile_latitude').value =latLng.lat();
		  document.getElementById('Businessprofile_longitude').value =latLng.lng();
		}
		
		function updateMarkerAddress(str) {
		 // document.getElementById('address').innerHTML = str;
		  document.getElementById('Business_address').value =str;
		}
		
		function initialize() {
		  var latLng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $long;?>);
		  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
		    zoom: 8,
		    center: latLng,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		  });
		  var marker = new google.maps.Marker({
		    position: latLng,
		    title: 'Your Address Point',
		    map: map,
		    draggable: true
		  });
		  
		  // Update current position info.
		  updateMarkerPosition(latLng);
		  geocodePosition(latLng);
		  
		  // Add dragging event listeners.
		  google.maps.event.addListener(marker, 'dragstart', function() {
		    //updateMarkerAddress('Dragging...');
		  });
		  
		  google.maps.event.addListener(marker, 'drag', function() {
		    //updateMarkerStatus('Dragging...');
		    updateMarkerPosition(marker.getPosition());
		  });
		  
		  google.maps.event.addListener(marker, 'dragend', function() {
		   // updateMarkerStatus('Drag ended');
		    geocodePosition(marker.getPosition());
		  });
		}
		
		// Onload handler to fire off the app.
		google.maps.event.addDomListener(window, 'load', initialize);

</script>    

<style>
  #mapCanvas {
    width: 500px;
    height: 400px;
  }
  </style>
<div class="form">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'business-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php if(isset($model->logo) && $model->logo!=''){ ?>
	<div class="row">
		<?php
			$this->widget('ext.SAImageDisplayer', array(
					    'image' => $model->logo,
					    'size' => 'p240',
					    'group' => 'business',
					    'defaultImage' => 'default.png',
					    'title'=>ucwords($model->businessname),
					)); 
		?>
    </div>
    <?php  } ?>
    
	<div class="row">
        <?php echo $form->labelEx($model,'logo'); ?>
        <?php echo CHtml::activeFileField($model, 'logo'); ?>  
        <?php echo $form->error($model,'logo'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'businessname'); ?>
		<?php echo $form->textField($model,'businessname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'businessname'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'zipcode'); ?>
		<?php echo $form->textField($model,'zipcode',array('size'=>120,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'zipcode'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'phonenumber'); ?>
		<?php echo $form->textField($model,'phonenumber',array('size'=>120,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phonenumber'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($profile,'website'); ?>
		<?php echo $form->textField($profile,'website',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($profile,'website'); ?>
	</div>
	<div class="row">
		
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model, 'description', array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($profile,'openschedule'); ?>
		<?php echo $form->textField($profile,'openschedule',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($profile,'openschedule'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($profile,'foundeddate'); ?>
		
		<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
			    'name'=>'Businessprofile[foundeddate]',
			    // additional javascript options for the date picker plugin
			     'value'=>$profile->foundeddate,
			    'options'=>array(
			    	'changeMonth'=>true,
        			'changeYear'=>true,
			        'showAnim'=>'fold',
			         'dateFormat' => 'yy-mm-dd',
			         'maxDate' => date("Y-m-d"),
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;'
			    ),
			));
		?>
		<?php echo $form->error($profile,'foundeddate'); ?>
	</div>
	<div class="row">
		<label>Drag the red marker to locate your business address</label>
	</div>
	<div id="mapCanvas"></div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>120,'maxlength'=>255,'readOnly'=>true)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div> 
	<div class="row">
		<?php echo $form->labelEx($profile,'latitude'); ?>
		<?php echo $form->textField($profile,'latitude',array('size'=>60,'maxlength'=>255,'readOnly'=>true)); ?>
		<?php echo $form->error($profile,'latitude'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($profile,'longitude'); ?>
		<?php echo $form->textField($profile,'longitude',array('size'=>60,'maxlength'=>255,'readOnly'=>true)); ?>
		<?php echo $form->error($profile,'longitude'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($profile,'facebook_page'); ?>
		<?php //echo $form->textField($model,'facebook_page',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::textField('Businessprofile[facebook_page]',  $profile->facebook_page,
    		array('prepend' => 'https://www.facebook.com/',  'span' => 2)); ?>
		<?php echo $form->error($profile,'facebook_page'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'twitter_page'); ?>
		<?php //echo $form->textField($model,'twitter_page',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::textField('Businessprofile[twitter_page]', $profile->twitter_page,
    		array('prepend' => 'https://twitter.com/',  'span' => 2)); ?>
		<?php echo $form->error($profile,'twitter_page'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($profile,'gplus_page'); ?>
		<?php //echo $form->textField($model,'gplus_page',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::textField('Businessprofile[gplus_page]', $profile->gplus_page,
    		array('prepend' => 'https://plus.google.com/',  'span' => 2)); ?>
		<?php echo $form->error($profile,'gplus_page'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
	</div>
	<div class="rowCategory">
	
	<?php
		//$model->category= array("Apparel & Jewelry","Automotive");
		echo $form->checkBoxList($model, 'category', $category);
		/*foreach($category as $cat)
		{
			 echo TbHtml::checkBox('category[]', false, array('label' => $cat));
		}*/
	?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->