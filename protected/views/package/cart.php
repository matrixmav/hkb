<div class="container">
<div id="maincontent" class="pageWrp checkout abtest">
<div class="sectionWrp summary open">
    <p class="title"><span class="check">1.</span> <span class="txt">Your Order Summary</span><a onclick="OpenDiv();" id="editIcon" style="display:none;">Edit</a></p>
<div class="contentBlock CartSection" id="cartDiv">
<form name="purchase" method="POST" action="./Your Shopping Cart_files/Your Shopping Cart.html" class="form">
<input type="hidden" name="action" value="complete_order">
<input type="hidden" name="payment_type" value="">
<input type="hidden" name="gateway_id" value="">
<input type="hidden" name="card_cvv" value="">
<input type="hidden" name="country" value="">
<input type="hidden" name="ccavenue_option" value="">
<input type="hidden" name="gateway_params" value="">
<input type="hidden" name="selected_bank" value="">
<input type="hidden" name="show_signup" value="false">
<input type="hidden" id="pp_price" name="pp_price" value="299">
<table class="cartItemsWrp" cellspacing="0" cellpadding="0">
<tbody><tr class="cartItemHeader">
<th>Product</th>
<th>Description</th>
<th>Duration</th>
<th>Price</th>
</tr>

<tr class="productBlock CartItemRow domain" id="" name="product_items[]">
<td class="pName">
<div class="name itemblock topRow vCenter">
<?php echo $packageObject->name;?>
   
 
</div>
     <br/>Domain : <?php echo Yii::app()->session['domain'];?>  
</td>
<td class="pDescription">
<p class="description itemblock topRow vCenter"><?php echo substr($packageObject->Description,0,100);?></p>
</td>
<td class="pDuration">
<div class="itemblock topRow">
<p class="selectWrp">
 <b>1 Year at $<?php echo $packageObject->amount;?>/yr</b>
 
</p>
 </div>
</td>
<td class="pPrice CartSubTotal tbl-pd">
<div class="pos_hlp itemblock topRow">
<p class="price ItemSubTotal">
<span class="WebRupee">$</span> <span id=""><?php echo $packageObject->amount;?> <?php if(Yii::app()->session['amount']!=''){ ?> + $ <?php echo Yii::app()->session['amount'];?>(Domain Price Included)<?php }?></span>
</p>
</div>
 </td>
</tr>
 

</tbody></table>
</form>
<div class="cartfooter">
<form id="couponCodeContainer" class="couponWrp lfloat" method="post">
<input type="text" name="coupon_code" id="coupon_code" placeholder="Please Enter Coupon Code">
<input type="button" class="btn-flat-green ui-btn-grey" value="Apply" onclick="Couponapply();">

<span class="couponWarning" style="display: none;" id="coupon_success"></span>
<div class="couponError" style="display: none;" id="coupon_error"></div>
 

<div style="font-size: 12px; padding-top: 8px">*Discounts not applicable on .BIZ &amp; .ASIA domains</div>
<div class="offerBlurb" style="display: none;">
<div class="blurbTop"></div>
<div class="blurbBody"></div>
<div class="blurbBottom"></div>
</div>
</form>
<div class="socialBtnWrp lfloat">
<div class="fbConnect">
<span id="fbButton" class="fbbtn"></span>
<span id="followBigRock"></span> <span class="txt">Share on Facebook to get 10% off*</span>
</div>
</div>
<table class="cartTotalWrp rfloat tbl-2" cellpadding="0" cellspacing="0" border="0">
<tbody><tr class="ItemConvertedSubtotal">
<td class="itemText">
<p>Subtotal:</p>
</td>
<td class="itemAmount">
<p id="CartTotal"><span class="WebRupee">$</span> <span id="total"><?php echo $packageObject->amount + Yii::app()->session['amount'];?></span></p>
</td>
</tr>
 
 
<tr class="ItemTotalAfterDiscount">
   
<td class="itemText">
<p>Total Amount:</p>
</td>
<td class="itemAmount">
<p id="TotalAmount"><span class="WebRupee">$</span> <span id="totalpayable"><?php echo $packageObject->amount + Yii::app()->session['amount'];?></span></p>
</td>
</tr>
</tbody></table>
</div>
<div class="btnWrp">
    <a id="summary-btn" class="btn-flat-green xxl" onclick="proceedPayment();">Proceed to Payment</a>
</div>
</div>

<div class="sectionWrp paymentOptions">
<p class="title"><span class="check">2.</span> <span class="txt">Payment Options</span> <span class="edit">edit</span></p>
<div id="paymentOption">
    
</div>
</div>
</div>
</div>
</div>
<input type="hidden" id="totalAmount" value="<?php echo $packageObject->amount + Yii::app()->session['amount'];?>">
 
<script type="text/javascript">
    
function Couponapply(){
var coupon_code = $('#coupon_code').val(); 
if(coupon_code=='')
{
document.getElementById("coupon_error").style.display="block";
document.getElementById("coupon_error").innerHTML = "Please enter a domain name.";
document.getElementById("coupon_error").focus();
}else{
var dataString = 'coupon_code='+coupon_code;  
var url = $('#URL').val();
$.ajax({
type: "GET",
url: "couponapply",
data: dataString,
cache: false,
success: function(html){
 if(html==0)
{
 document.getElementById("coupon_error").style.display="block";   
 document.getElementById("coupon_error").innerHTML = "Incorrect coupon code";
 $("#coupon_error").fadeOut(5000);
 }else{
 $('#coupon_code').val('');
 document.getElementById("coupon_success").style.display="block";
 document.getElementById("coupon_success").innerHTML = "Coupon code applied";
 document.getElementById("totalpayable").innerHTML = html;
 document.getElementById("totalAmount").value=html;
 $("#coupon_success").fadeOut(5000);
 }  
 }

});//@ sourceURL=pen.js

}
}
function proceedPayment()
{
var totalAmount = $('#totalAmount').val(); 
var dataString = 'datasave=yes&totalAmount='+totalAmount;    
$.ajax({
type: "GET",
url: "orderadd",
data: dataString,
cache: false,
success: function(html){
 if(html==1)
{
  $('#cartDiv').fadeOut();
  $('#editIcon').fadeIn();
  $('#paymentOption').fadeIN();  
  
}
}  
});
}
  
function OpenDiv()
{
  $('#cartDiv').fadeIn();
  $('#paymentOption').fadeOut();
}
</script>    
    