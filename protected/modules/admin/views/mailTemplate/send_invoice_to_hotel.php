<style type="text/css">
.mainWrapperPane{width:100%; padding:10px;}
.mainWrapper{width:700px; overflow: hidden;}
.content{font-size: 12px;}
td{vertical-align:top;font-size: 13.4px; line-height: 17px;}
.chart{border:0.03px solid #000000; padding:5px 0px;width:700px; font-size: 12px;}
.greyblock{background:#dfdfdf;padding:2px 5px; font-size: 11px; font-weight: bold;margin-bottom: 10px;}
</style>
<!-- duplicate.jpg,proforma.jpg-->
<?php
if($type!=1)
{
    $imagename = ($type==2)? 'duplicate.jpg':'proforma.jpg';
    $backimg='backimg="'.$baseUrl.'/images/'.$imagename.'" backimgx="center" backimgy="middle" backimgw="100%"';
}
else 
    $backimg='';
?>
<!--backimg="<?php echo $baseUrl; ?>/images/proforma.jpg" backimgx="center" backimgy="middle" backimgw="100%"-->
<page backtop="3.2mm" backbottom="3mm" backleft="3.5mm" backright="3mm" <?php echo $backimg;?>> 
  <div class="mainWrapperPane">
    <table class="mainWrapper" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="width: 62%; text-align: left" align="left" valign="top">www.dayuse-hotels.com<br><?php echo Yii::app()->params['dayuseInfoEmail']; ?><br />
          <br />
          <b>DAY USE SAS</b><br />
          5 rue Rochechouart, 75009 Paris France<br />
          <br />
          Téléphone : <?php echo Yii::app()->params['dayuseContactNumber']; ?><br/></td>
          <td style="width: 38%; text-align: left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="top"><b><?php echo $invoiceObject->hotel->name; ?></b><br />
            <?php echo $invoiceObject->hotel->address; ?><br />
            <?php echo $invoiceObject->hotel->postal_code . " " .$invoiceObject->hotel->city->name; ?></td>
            
            <td align="left" valign="top"><b>Le Quartier Bercy Square</b><br />
              33, boulevard de Reuilly<br/>
              75012 Paris<br/>
              France<br />
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">Date : <b><?php echo date('d/m/Y');?></b><br />
              Facture n°&nbsp; &nbsp;&nbsp; <b><?php echo $invoiceObject->inv_no; ?></b><br />
              Date limite de paiement :&nbsp; <b><?php echo $invoiceObject->inv_due_date; ?></b></td>
              <td align="right" valign="bottom"><?php echo ($invoiceObject->inv_due_date)? "V/TVA : ".$invoiceObject->inv_due_date:""; ?><br />
          <?php echo ($administrativeObject->account_no)? "N° Client : ".$administrativeObject->account_no:""; ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">
                  <table class="chart" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="width: 15%;text-align:left;font-size:11px;">DATE</td>
                      <td style="width: 15%;text-align:left;font-size:11px;">N° RESA</td>
                      <td style="width: 34%;text-align:left;font-size:11px;">DESIGNATION</td>
                      <td style="width: 14%;text-align:left;font-size:11px;">PRIX BASE</td>
                      <td style="width: 10%;text-align:left;font-size:11px;">COMM.</td>
                      <td style="width:  6%;text-align:left;font-size:11px;">TVA</td>
                      <td style="width:  6%;text-align:left;font-size:11px;">HT</td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
               <td colspan="2">
                 <table style="width:700px" cellpadding="0" cellspacing="0">
                  <?php 
                    $totalAmount = 0;
                    $totalVatAmount = 0;
                    foreach($invReservationObject as $hotelAdministrative){ 
                        $totalAmount+=$hotelAdministrative->total_comm_amt; 
                        $totalVatAmount+=$hotelAdministrative->vat_amt;
                        if($hotelAdministrative->opt_type != 'room'){
                            continue;
                        }
                        ?>
                        <tr>
                          <td style="width: 15%;font-size: 10px;"><?php echo $hotelAdministrative->res_date; ?></td>
                          <td style="width: 15%;font-size: 10px;"><?php echo $hotelAdministrative->nb_reservation; ?></td>
                          <td style="width: 34%;font-size: 10px;"><?php echo $hotelAdministrative->opt_title; ?></td>
                          <td style="width: 14%;font-size: 10px;"><?php echo $hotelAdministrative->total_comm_amt; ?> USD</td>
                          <td style="width: 10%;font-size: 10px;"><?php echo $hotelAdministrative->comm_perc; ?> %</td>
                          <td style="width: 6%;font-size: 10px;"><?php echo $hotelAdministrative->vat_perc; ?> %</td>
                          <td style="width: 6%;font-size: 10px;"><?php echo $hotelAdministrative->comm_amt; ?></td>
                        </tr>
                    <?php
                    } ?>
                </table>
              </td>
            </tr> 
            <tr>
              <td height="200" colspan="2" align="right">&nbsp;</td>
            </tr>

            <tr>
              <td colspan="2">
                <table style="width: 100%;" font-size: 12px; border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="width:54%;"></td>
                    <td style="width:46%;">
                      <table width="390" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;color:#000;border-collapse:collapse;">
                        <tr>
                          <td style="border-right:0.03px solid #000;widgets-right:95px;">&nbsp;</td>
                          <td style="border:0.03px solid #000; padding:1px; width:65px;font-size:11px;text-align:right;"><b>HT</b></td>
                          <td style="border:0.03px solid #000; padding:1px; width:70px;font-size:11px;text-align:right;"><b>TVA</b></td>
                          <td style="border:0.03px solid #000; padding:1px; width:70px;font-size:11px;text-align:right;"><b>TTC</b></td>
                        </tr>
                        <tr>
                          <td align="right" style="padding-right:3px;font-size:11px;border-right:0.03px solid #000;">Sous-total TVA 20%</td>
                          <td style="border:0.03px solid #000; padding:1px;font-size:11px;text-align:right;"><?php echo $totalAmount;?> $ </td>
                          <td style="border:0.03px solid #000; padding:1px;font-size:11px;text-align:right;"><?php echo $totalVatAmount;?> $</td>
                          <td style="border:0.03px solid #000; padding:1px;font-size:11px;text-align:right;"><?php echo ($totalAmount+$totalVatAmount);?> $</td>
                        </tr>
                        <tr>
                          <td align="right" style="padding-right:3px;font-size:11px;border-right:0.03px solid #000;"><b>Total</b></td>
                          <td style="border:0.03px solid #000; padding:1px;font-size:11px;text-align:right;"><?php echo $totalAmount;?>$</td>
                          <td style="border:0.03px solid #000; padding:1px;font-size:11px;text-align:right;"><?php echo $totalVatAmount;?> $</td>
                          <td style="border:0.03px solid #000; padding:1px;font-size:11px;text-align:right;"><?php echo ($totalAmount+$totalVatAmount);?> $</td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                </td>
              </tr>

              <tr>
                <td style="font-size:12px;color:#000;" colspan="2">Facture nette d'escompte, même en cas de réglement anticipé. Pénalités de retard de paiement : <span style="color:#f00">+ 12%.</span><br />
                  Tout retard de paiement donne lieu de plein droit à une indemnité de <span style="color:#f00">40â‚¬</span> pour frais de recouvrement,<br />
                  en sus des indemnités de retard. Belgique et Luxembourg : TVA due par le preneur (art 194-1 de la directive 2006/112/CE)<br />
                  <br />
                  CHEQUE BANCAIRE (tiré sur une banque française), à ordre de DAY USE SAS, 5 rue Rochechouart, 75009 Paris France<br/>
                  VIREMENT BANCAIRE : BRED PARIS TRUDAINE, 52 rue des Martyrs, 75009 Paris France</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>

                <tr>
                  <td colspan="2">
                    <table width="100%" border="0" style="border-collapse:collapse;font-size:11px; color:#000;" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="border:0.03px solid #000; padding:3px;font-size:11px; text-align:center;">BANQUE : 10107</td>
                        <td style="border:0.03px solid #000; padding:3px;font-size:11px; text-align:center;">GUICHET : 00601</td>
                        <td style="border:0.03px solid #000; padding:3px;font-size:11px; text-align:center;">COMPTE : 00815038359</td>
                        <td style="border:0.03px solid #000; padding:3px;font-size:11px; text-align:center;">CLÉ : 68</td>
                        <td style="border:0.03px solid #000; padding:3px;font-size:11px; text-align:center;">IBAN : FR7610107006010081503835968</td>
                        <td style="border:0.03px solid #000; padding:3px;font-size:11px; text-align:center;">BIC : BREDFRPPXXX</td>           
                      </tr>
                    </table>
                  </td>
                </tr>


                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </div>
            </page>