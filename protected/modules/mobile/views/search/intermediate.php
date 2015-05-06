<section class="searchBox">
    <div class="searchCont">
			<?php $this->widget('application.widgets.SearchWidget',array('type'=>4)); ?>        
	</div>
</section>
<section class="intern">
  <div class="headingPart">
      <?php if($term != "Hotel, City, District") {?>
    <p class="heading">Search results for &laquo; <?php echo $term;?> &raquo;</p>
      <?php } else { ?>
    <p class="heading">No Results Found!. &raquo;</p>
      <?php } ?>
    <p class="normal"><?php echo Yii::t('mobile', 'search_comment'); ?></p>
  </div>
  <?php 
  // List down the hotel matching information
  foreach ($hotels as $id=>$ky):
  	?>
  	<a href="<?php echo $ky['url'];?>" class="list"><?php echo $ky['value'];?><span>(Hotel)</span></a>
  	<?php 
  endforeach;
  
  // List down the hotel matching information
  foreach ($cities as $id=>$ky):
	  $url = "/mobile/search/index?search_widget_type=4&SearchForm[search_keyword]=".$ky['value']."&SearchForm[search_id]=".$ky['id']."&SearchForm[search_type]=2";
  ?>
    <a href="<?php echo $url;?>" class="list"><?php echo $ky['value'];?><span>(City)</span></a>
  <?php 
  endforeach;
  
  // List down the state matching information
  foreach ($states as $id=>$ky):
  	$url = "/mobile/search/index?search_widget_type=4&SearchForm[search_keyword]=".$ky['value']."&SearchForm[search_id]=".$ky['id']."&SearchForm[search_type]=3";
  ?>
  	<a href="<?php echo $url;?>" class="list"><?php echo $ky['value'];?><span>(State)</span></a>
  <?php 
  endforeach;
  ?>
  <!-- <a href="#" class="list">Paris<span>(Ile-de France, France)</span></a> -->
 </section>
<section class="threeBox">
	<div class="box">
    	<div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i1.png" alt=""></div>
        <div class="textPart">
        	<p class="heading">best rates guaranteed</p>
			<p class="normal">Negociated rates (30 to 70% off)</p>
        </div>
    </div>
    <div class="box">
    	<div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i2.png" alt=""></div>
        <div class="textPart">
        	<p class="heading">no credit card required</p>
			<p class="normal">Privacy guarantee</p>
        </div>
    </div>
    <div class="box last">
    	<div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i3.png" alt=""></div>
        <div class="textPart">
        	<p class="heading">cancellation without charge</p>
			<p class="normal">Easy until the last minute</p>
        </div>
    </div>
</section>
<?php 
//[url] => /hotel/detail?slug=the-sohotel&name=The+Sohotel
//[url] => /search/index?term=Jemison&uniId=78&type=2
/* echo "<pre>";
print_r($cities);
echo "</pre>"; */
/*
[id] => 258
[value] => New Market (AL)
[lavel] => New Market
[category] => City
[url] => /search/index?term=New+Market&uniId=258&type=2
city
search/index?search_widget_type=4&SearchForm[search_keyword]=Los+Angeles+(CA)&SearchForm[search_id]=13&SearchForm[search_type]=2
*/

?>