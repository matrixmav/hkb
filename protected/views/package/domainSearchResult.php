<?php

/* @var $this PackageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Packages',
);

$this->menu = array(
    array('label' => 'Create Package', 'url' => array('create')),
    array('label' => 'Manage Package', 'url' => array('admin')),
);
$UserDomainPart = explode('.', $userEnteredDomain);
if (in_array($userEnteredDomain, $domainTakenArray)) {
    $pos = array_search($UserDomainPart[1], $AllDomainArray);
    unset($AllDomainArray[$pos]);
    //$SuggestedDomain = "<div>Oops!Domain you entered not available.Please choose some other.</div><br/>";
    $SuggestedDomain = '<div class="secondary-result">
                            <div class="secondaryDomain resultDomain-wrapper">
                                <div class="domain-wrapper ">
                                    <div class="domainName">' . $UserDomainPart[0] . '.com</div>
                                    <div class="website-promo orange">Get a free DIY for 6 months.<br>Use Coupon: WEBSITE199</div>
                                 </div>
                                 <span class="pricing-wrp">
                                   <strong><span class="WebRupee">Rs.</span> 199</strong>/YR<br>
                                    <s class="slashprice"><span class="WebRupee">Rs.</span> 819</s>
                                   </span>
                                   <span class="select-domain btn-flat-green">N/A</span>
                              </div>
                        </div>';
    foreach ($AllDomainArray as $alldomain) {
        $SuggestedDomain .= '<div class="secondary-result">
                            <div class="secondaryDomain resultDomain-wrapper">
                                 <div class="domain-wrapper cart2">
                                    <p class="domainName">' . $UserDomainPart[0] . "." . $alldomain . '</p>
                                    <div class="website-promo orange">Get a free DIY for 6 months.<br>Use Coupon: WEBSITE199</div>
                                 </div>
                                 <span class="pricing-wrp">
                                   <strong><span class="WebRupee">Rs.</span> 199</strong>/YR<br>
                                    <div class="slashprice cart1"><span class="WebRupee">Rs.</span> 819</div>
                                   </span>
                                   <input type="hidden" name="domain" id="domain" value="' . $UserDomainPart[0] . "." . $alldomain . '">
                                       <input type="hidden" name="amount" id="amount" value="5">
                                    <button class="add-to-cart select-domain btn-flat-green" id="test"  onclick="DomainAdd(' . $UserDomainPart[0] . "." . $alldomain . ');"  type="button">Add</button>
                              </div>
                        </div>';


        //$SuggestedDomain .= "<a href='".Yii::app()->baseUrl."checkout?domain_id=1'>" . $UserDomainPart[0] . "." . $alldomain . "</a><br/>";
    }
} else {
    $SuggestedDomain = '<div class="secondary-result cart2">
                            <div class="secondaryDomain resultDomain-wrapper">
                                <div class="domain-wrapper cart2">
                                    <p class="domainName">' . $UserDomainPart[0] . '.com</p>
                                    <div class="website-promo orange">Get a free DIY for 6 months.<br>Use Coupon: WEBSITE199</div>
                                 </div>
                                 <span class="pricing-wrp">
                                   <strong><span class="WebRupee">Rs.</span> 199</strong>/YR<br>
                                    <div class="slashprice cart1"><span class="WebRupee">Rs.</span> 819</div>
                                   </span>
                                   <input type="hidden" name="domain" id="domain1" value="' . $UserDomainPart[0] . '.com">
                                   <input type="hidden" name="amount" id="amount" value="15">
                                   <button class="add-to-cart select-domain btn-flat-green" onclick="test();"  type="button">Add</button>
                                    
                              </div>
                        </div> ';
    foreach ($AllDomainArray as $alldomain) {
        //$SuggestedDomain .= "<a href='".Yii::app()->baseUrl."checkout?domain_id=1'>" . $UserDomainPart[0] . "." . $alldomain . "</a><br/>";
    }
}
echo $SuggestedDomain;
?>
