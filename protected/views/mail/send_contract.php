<?php $baseUrl = $_SERVER['HTTP_HOST'];?>
<!DOCTYPE HTML>
<html class="no-js">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Hotel Contract</title>
    </head>
    <body>
        <table width="980" align="center" cellpadding="0" cellspacing="0" style="border: 12px solid #eeeeee; font-family:arial;font-size: 14px;line-height: 18px;">
            <tr>
                <td align="center"><table width="587" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="35">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center"><img src="<?php echo $baseUrl; ?>/images/logo_header.png" border="none" alt="dayuse" /></td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <tr>
                            <td><img src="<?php echo $baseUrl; ?>/images/mailer-divider.png" width="100%" border="none" alt="" height="9" /></td>
                        </tr>
                        <tr>
                            <td height="12"></td>
                        </tr>
                        <tr>
                            <td align="center"><table width="190" height="30" style="background-image:url('<?php echo $baseUrl; ?>/images/mailer-phoneBlock.jpg'); background-repeat:no-repeat;" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="45">&nbsp;</td>
                                        <td width="141" style="font-size:19px; font-family:arial; font-weight:bold;"><?php echo Yii::app()->params['dayuseContactNumber']; ?></td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td align="center" height="11"></td>
                        </tr>
                        <tr>
                            <td align="center">
                                <a href="https://www.facebook.com/dayusehotelsfr" class="social"><img src="<?php echo $baseUrl; ?>/images/header_fb.png" border="none" alt="facebook"></a>&nbsp;
                                <a href="https://plus.google.com/104772772100040614060/posts" class="social"><img src="<?php echo $baseUrl; ?>/images/header_google.png" border="none" alt="google"></a>&nbsp;
                                <a href="https://twitter.com/dayuseen" class="social"><img src="<?php echo $baseUrl; ?>/images/header_tweet.png" border="none" alt="twitter"></a>
                            </td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td><table width="770" align="center" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="45"></td>
                        </tr>
                        <tr>
                            <td><p style="font-size: 14px;"><span style="font-size: 18px;line-height: 25px;font-family: arial;">Hotel Contract Added</span>
                                    <br>
                                </p>
                                <p style="font-family: arial;font-size: 18px;margin-bottom:5px;padding-top:12px;">Hotel Detail</p>
                                <p style="margin-top:0px;font-size:14px;line-height: 23px;">
                                    Name : <strong><?php echo $HotelName; ?></strong><br>
                                    <a href="<?php echo $baseUrl; ?>">Click here to go to Admin.</a><br>
                                </p>
                        </tr>                        
                    </table></td>
            </tr>
        </table>
    </body>
</html>
