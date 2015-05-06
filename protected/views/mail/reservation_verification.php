<?php $baseUrl = $_SERVER['HTTP_HOST'];?>
<!DOCTYPE HTML> 
<html class="no-js">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>validation</title>
    </head>
    <body>
        <table width="980" align="center" cellpadding="0" cellspacing="0" style="border: 12px solid #eeeeee; font-family:arial;font-size: 14px;line-height: 18px;">
            <tr>
                <td align="center"><table width="587" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="35">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center"><img src="<?php echo $baseurl; ?>/images/logo_header.png" border="none" alt="dayuse" /></td>
                        </tr>
                        <tr>
                            <td height="5"></tdfirst_name>
                        </tr>
                        <tr>
                            <td><img src="<?php echo $baseurl; ?>/images/mailer-divider.png" width="100%" border="none" alt="" height="9" /></td>
                        </tr>
                        <tr>
                            <td height="12"></td>
                        </tr>
                        <tr>
                            <td align="center"><table width="190" height="30" style="background-image:url('<?php echo $baseurl; ?>/images/mailer-phoneBlock.jpg'); background-repeat:no-repeat;" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                        <td width="45">&nbsp;</td>
                                        <td width="141" style="font-size:19px; font-family:arial; font-weight:bold;">855 378 5969</td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td align="center" height="11"></td>
                        </tr>
                        <tr>
                            <td align="center"><a href="#" class="social"><img src="<?php echo $baseurl; ?>/images/header_fb.png" border="none" alt="facebook"></a>&nbsp; <a href="#" class="social"><img src="<?php echo $baseurl; ?>/images/header_google.png" border="none" alt="google"></a>&nbsp; <a href="#" class="social"><img src="<?php echo $baseurl; ?>/images/header_tweet.png" border="none" alt="twitter"></a></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td><table width="770" align="center" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="45"></td>
                        </tr>
                        <tr>
                            <td><p style="font-size: 14px;"><span style="font-size: 18px;line-height: 25px;font-family: arial;font-weight:bold;">Dear <?php echo $customerName; ?>,</span><br/>
                                    Your Verification Link is: <strong><a href="<?php echo $baseUrl. $varificationLink; ?>" />click to verify</a></strong><br>
                                    <br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="14"></td>
                                    </tr>
                                    <tr>
                                        <td height="27px"></td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 23px; font-size:14px;font-family:arial;">We remain at your disposal for more information. </td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 23px; font-size:14px;font-family:arial;">Best regards,</td>
                                    </tr>
                                    <tr>
                                        <td height="34px"></td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 23px; font-size:14px;font-family:arial;">Dayuse-hotels team</td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 23px; font-size:14px;font-family:arial;">contact@dayuse-hotels.com</td>
                                    </tr>
                                    <tr>
                                        <td height="34px"></td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 23px; font-size:14px;font-family:arial;font-weight:bold;">Hope to see you again soon on <a href="#" style="text-decoration:underline;color:#000000;">www.dayuse-hotels.com</a></td>
                                    </tr>
                                    <tr>
                                        <td height="48"></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><img src="<?php echo $baseurl; ?>/images/mailingAd.png" alt="ad-banner"/></td>
                                    </tr>
                                    <tr>
                                        <td height="40"></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
    </body>
</html>