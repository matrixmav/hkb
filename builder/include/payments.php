<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick-subscriptions">
<input type="hidden" name="business" value="me@mybusiness.com">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="no_shipping" value="1">
<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but20.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
<input type="hidden" name="a3" value="5.00">
<input type="hidden" name="p3" value="1">
<input type="hidden" name="t3" value="M">
<input type="hidden" name="src" value="1">
<input type="hidden" name="sra" value="1">
</form>

    * a3 - amount to billed each recurrence
    * t3 - time period (D=days, W=weeks, M=months, Y=years)
    * p3 - number of time periods between each recurrence

For the example above, the variables would are:

$5.00 USD (a3) every 1 (p3) month (t3)

For more information about using Subscriptions and Recurring Payments on your website, including adding automatic trial periods for the subscription, see the

<!--
<FORM ACTION="https://www.paypal.com/cgi-bin/webscr" METHOD="POST">
<INPUT TYPE="hidden" NAME="cmd" VALUE="_ext-enter">
<INPUT TYPE="hidden" NAME="redirect_cmd" VALUE="_xclick">
<INPUT TYPE="hidden" NAME="business" VALUE="recipient@paypal.com">
<INPUT TYPE="hidden" NAME="undefined_quantity" VALUE="1">
<INPUT TYPE="hidden" NAME="item_name" VALUE="hat">
<INPUT TYPE="hidden" NAME="item_number" VALUE="123">
<INPUT TYPE="hidden" NAME="amount" VALUE="15.00">
<INPUT TYPE="hidden" NAME="shipping" VALUE="1.00">
<INPUT TYPE="hidden" NAME="shipping2" VALUE="0.50">
<INPUT TYPE="hidden" NAME="currency_code" VALUE="USD">
<INPUT TYPE="hidden" NAME="first_name" VALUE="John">
<INPUT TYPE="hidden" NAME="last_name" VALUE="Doe">
<INPUT TYPE="hidden" NAME="address1" VALUE="9 Elm Street">
<INPUT TYPE="hidden" NAME="address2" VALUE="Apt 5">
<INPUT TYPE="hidden" NAME="city" VALUE="Berwyn">
<INPUT TYPE="hidden" NAME="state" VALUE="PA">
<INPUT TYPE="hidden" NAME="zip" VALUE="19312">
<INPUT TYPE="hidden" NAME="lc" VALUE="US">
<INPUT TYPE="hidden" NAME="email" VALUE="buyer@domain.com">
<INPUT TYPE="hidden" NAME="night_phone_a" VALUE="610">
<INPUT TYPE="hidden" NAME="night_phone_b" VALUE="555">
<INPUT TYPE="hidden" NAME="night_phone_c" VALUE="1234">
<INPUT TYPE="image" SRC="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" BORDER="0" NAME="submit" ALT=Make payments with PayPal - it's fast, free and secure!>
</FORM>
-->


<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but20.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
 <input type="hidden" name="cmd" value="_xclick-subscriptions">
<input type="hidden" name="business" value="john.doe@johndoe.com"> 
<input type="hidden" name="item_name" value="My Special Service"> 
<input type="hidden" name="item_number" value="SS-001"> 
<input type="hidden" name="no_note" value="1"> 
<input type="hidden" name="currency_code" value="USD"> 
<input type="hidden" name="a3" value="10.00"> 
<input type="hidden" name="p3" value="1"> 
<input type="hidden" name="t3" value="M"> 
<input type="hidden" name="src" value="1"> 
<input type="hidden" name="sra" value="1"> 
<input type="hidden" name="custom" value="<?php echo $_SESSION['username']; ?>"> 
</form>