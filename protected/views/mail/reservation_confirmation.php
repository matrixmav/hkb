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
                            <td><p style="font-size: 14px;">
                                        <?php 
                                        if($reservationObject->reservation_status == 2)
                                            $msg = Yii::t('front_end', 'mail_your_reservation_is_pending');
                                        else
                                            $msg = Yii::t('front_end', 'mail_your_reservation_is_confirmed');
                                        
                                        echo $msg;
                                        ?>         
                                </p>
                                <p style="font-family: arial;font-size: 18px;margin-bottom:5px;padding-top:12px;">RESERVATION DETAILS</p>
                                <p style="margin-top:0px;font-size:14px;line-height: 23px;">Reservation number : <strong><?php echo $reservationObject->nb_reservation; ?></strong><br>
                                    Date : <strong><?php echo $reservationObject->res_date; ?></strong><br>
                                    </p></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:15px; font-style:italic; font-weight:bold;">Room:</td>
                                    </tr>
                                    <tr>
                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="335" align="left" valign="top" style="font-size:14px;"><span style="font-size: 15px;"><?php echo $roomObject->name; ?></span><br/>
                                                                    <em>From <?php 
                                                                            $timefrom = new DateTime($roomObject->available_from);
                                                                               echo $timefrom->format('h:i A'); ?> to <?php 
                                                                                $timetill = new DateTime($roomObject->available_till);
                                                                               echo $timetill->format('h:i A'); ?></em></td>
                                                                <td width="436" align="left" valign="top" style="font-size:14px;">$&nbsp; <?php echo  number_format($reservationObject->room_price,2);?></td>
                                                            </tr>
                                                        </table></td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:15px; font-style:italic; font-weight:bold;">Options:</td>
                                    </tr>
                                    <tr>
                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <?php 
                                                $total = 0;
                                                foreach($reservationOptionObject as $reservationOption){ $total+=$reservationOption->equipment_price; ?>
                                                <tr>
                                                    <td width="335" align="left" valign="top" style="font-size:14px;font-family:arial;"><?php echo $reservationOption->equipment()->name; ?></td>
                                                    <td width="436" align="left" valign="top" style="font-size:14px;font-family:arial;">$&nbsp; <?php echo  number_format($reservationOption->equipment_price,2); ?></td>
                                                </tr>
                                                <?php } ?>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="335" align="left" valign="top" style="font-size:15px; font-weight:bold;font-family:Arial;">TOTAL AMOUNT</td>
                                                    <td width="436" align="left" valign="top" style="font-size:14px;font-family:arial;"><strong>$ <?php echo  number_format(($total+ $reservationObject->room_price),2)?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" style="font-size:12px;font-family:arial;">Payment will be processed at checkin</td>
                                                    <td align="left" valign="top">&nbsp;</td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><a href="<?php echo $baseUrl.'/reservation/edit?hotelId='.$hotelObject->id .'&roomId='. $roomObject->id . '&date='. $reservationObject->res_date .'&resnb='. base64_encode($reservationObject->id).'&orf='.$reservationObject->reservation_status; ?>" style="border: 1px solid #000;background: #fff;color:#000;padding-top:2px;padding-bottom:2px; text-decoration:none; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;MODIFY&nbsp;&nbsp;&nbsp;&nbsp;</a>&nbsp;
                                            <a href="<?php echo $baseUrl.'/customer/cancelreservation?rid='. base64_encode($reservationObject->id) . '&uid='. base64_encode($customerObjecct->id); ?>" style="border: 1px solid #000;padding-top:2px;padding-bottom:2px; background: #fff;color:#000;text-decoration:none; display: inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;CANCEL&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: arial;font-size: 18px;line-height:30px">HOTEL DETAILS</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:14px;font-family:arial;line-height: 23px;"><strong><?php echo $hotelObject->name?><br/>
                                                <?php echo $hotelObject->address ?> - <?php echo $hotelObject->postal_code . " " . $hotelObject->city()->slug?><br/>
                                                <?php echo Yii::app()->params['dayuseContactNumber']; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <?php $hotelDetailUrl = $baseUrl."/hotel/detail?slug=".$hotelObject->slug; ?>
                                        <td style="font-size:14px;font-family:arial;"><a href="<?php echo $hotelDetailUrl; ?>" style="color:#000000;">More information</a> - <a style="color:#000000;" href="<?php echo $hotelDetailUrl; ?>">Map</a></td>
                                    </tr>
                                    <tr>
                                        <td height="37"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: arial;font-size: 18px;line-height:34px">BOOKING POLICIES</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:14px;font-family:arial;">The time slot cannot be amended. All rooms are for 1 or 2 people. Any cancellation must be done via our website.</td>
                                    </tr>
                                    <tr>
                                        <td height="37"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: arial;font-size: 18px;line-height:34px;">YOUR CONTACT DETAILS</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: arial;font-size: 14px;line-height: 21px;">Name : <span style="font-size:13px;font-weight:bold; font-family:arial;"><?php echo $customerObjecct->first_name; ?> <?php echo $customerObjecct->last_name; ?></span><br/>
                                            Telephone : <span style="font-size:13px;font-weight:bold;font-family:arial;"><?php echo $customerObjecct->telephone; ?></span><br>
                                            Email : <span style="font-size:13px;font-weight:bold; font-family:arial;"><?php echo $customerObjecct->email_address; ?></span> </td>
                                    </tr>
                                    <tr>
                                        <td height="37"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: arial;font-size: 18px;line-height:34px;">CONTACT US</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:14px;font-family:arial;">Help : <?php echo Yii::app()->params['dayuseContactNumber']; ?> or click <a href="<?php echo  $baseUrl."/contact"; ?>" style="color:#000;">here</a></td>
                                    </tr>
                                    <tr>
                                        <td height="37"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: arial;font-size: 18px;line-height:31px;">IMPORTANT INFORMATION</td>
                                    </tr>
                                    <tr>
                                        <td style="line-height: 23px; font-size:14px;font-family:arial;">You can cancel your booking by clicking this <a href="#" style="color:#000;">link</a>. 
                                            You will have to inform your booking number and your email address. 
                                            Your booking cancellations cannot be made by e-mail either with the hotel..
                                            Kindly note that you will be requested to stick to the day use times slot indicated or you risk to be extra charged. 
                                            All payments will be made direct at the hotel. Your ID and credit card will be request at the check-in time as
                                            guarantee you can pay by the method you like. Ask at the hotel on arrival for the facilities (parking, internet, etc). 
                                            All prices are NOT including local taxes.<br>
                                            NEVER GIVE YOUR BANKING INFORMATION BY EMAIL</td>
                                    </tr>
                                    <tr>
                                        <td height="50"></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><img src="<?php echo $baseUrl; ?>/images/mailingAd.png" alt="ad-banner"/></td>
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
