<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div class="container">
<div class="content-wrapper dca-result-page dca-page-wrapper revamped">
<div class="left-column lfloat">
<div style="width: 90%;display: none;" class="error" id="error_msg"></div>
<div class="search-again-wrapper" style="">
<form action="" method="post">
    <input type="hidden" id="package_id" value="<?php echo Yii::app()->session['package_id'];?>">
 <div class="domain-select-wrapper">
<input placeholder="Enter Your Domain Name" type="text" name="domain" class="domains-input" data-id="field_domains-input" id="domain" maxlength="65">
</div>
<input type="button" class="btn-flat-green" id="search" value="Search Here"> 
<div class="clear"></div>
</form>
</div>
<div id="suggestedDomain" style="display:<?php if(Yii::app()->session['domain']){ echo "block"; }else{ echo "none"; }?>">
<div class="results-wrapper">
<div class="section-wrap secondary-section">
 <div class="titleFiltersWrp filters">
<div class="title">
</div>
            <div class="title">More domains to consider: </div>
            <!--<ul class="filterWrp">
            <li class="title first">FILTER BY:</li>
            <li id="dca-price-filter" class="priceFilter filterContent second">
            <div class="title">PRICE</div>
            <div class="filterContainer price">
            <div class="slider" id="max-price-slider" style="position: relative; -webkit-user-select: none; box-sizing: border-box; min-height: 25px; margin-left: 12.5px; margin-right: 12.5px;"><div class="track" style="position: absolute; top: 50%; -webkit-user-select: none; cursor: pointer; width: 100%; margin-top: -5.5px;"></div><div class="highlight-track" style="position: absolute; top: 50%; -webkit-user-select: none; cursor: pointer; width: 216px; margin-top: -5.5px;"></div><div class="dragger" style="position: absolute; top: 50%; -webkit-user-select: none; cursor: pointer; margin-top: -12.5px; margin-left: -12.5px; left: 216px;"></div></div><input id="max-price" name="max-price" type="text" style="display: none;">
            <p class="data price-range-container">
            <span class="lfloat minPrice"><span class="WebRupee">Rs.</span> 469</span>
            <span class="rfloat maxPrice"><span class="WebRupee">Rs.</span> 2546580</span>                            
            </p>
            </div>
            </li>
            <li id="dca-match-filter" class="exactfilter filterContent third">
            <div class="title">EXACT MATCHES</div>
            <div class="filterContainer exact">
            <p>
            <input type="checkbox" id="exact-match" name="exact-match">
            <label for="exact-match">Only show results that exactly match your typed domain name</label>
            </p>
            <p class="exactNote">Domain names that are unavailable will not be shown.</p>
            </div>
            </li>
            </ul>-->
            <div class="clear"></div>
 </div>
    <div class="clear"></div>
            <div class="domainSearchResult">
            <div id="secondaryDomainResults" class="secondary-result-section">
                
           <?php echo $suggestedDomain;?> 
                
</div>  
</div>
</div>
</div>
</div>
</div>
<div class="sidebar rfloat cart">
<div id="scrollable-content" class="scrollable mySideCart">
<?php echo $rightbar;?>
</div>
</div>
</div>  
</div>  
<input type="hidden" name="domainset" id="domainset" value="<?php echo Yii::app()->session['domain'];?>">
  <script>
$('#search').click(function(){
    
var package_id = $('#package_id').val(); 
var domain = $('#domain').val();
if(domain=='')
{
document.getElementById("error_msg").style.display="block";
document.getElementById("error_msg").innerHTML = "Please enter a domain name.";
document.getElementById("error_msg").focus();
}else{
var dataString = 'domain='+domain+'.com'+'&package_id='+package_id;  
var url = $('#URL').val();
$.ajax({
type: "GET",
url: "availabledomain",
data: dataString,
cache: false,
success: function(html){
document.getElementById("secondaryDomainResults").innerHTML = html;
document.getElementById("suggestedDomain").style.display="block";
}

});
}
});

function DomainAdd(valz){
var package_id = $('#package_id').val();  
var domain1 = valz;
$('#domainset').val(domain1);
var amount = $('#amount').val();
var dataString = 'ajax=yes&domain='+domain1+'&package_id='+package_id+'&amount='+amount;  
var url = $('#URL').val();
$.ajax({
type: "GET",
url: "domainadd",
data: dataString,
cache: false,
success: function(html){
 var res = html.split("_");
 document.getElementById("domainTaken").innerHTML = res[0];
 document.getElementById("tottal").innerHTML = res[1];
}

});//@ sourceURL=pen.js
}
	
function RedirectCart()
{
var domainSet  = $('#domainset').val();
if(domainSet=='')
{
 alert("Please choose any domain first.");return false;  
}else{
 location.href = '/package/productcart'; 
}
}
  </script>