<?php
$ADMINDIR = (stristr( $_SERVER['REQUEST_URI'], 'adminfr')) ? 'adminfr' : 'admin' ;
return array(
    'AdminDir'=> (stristr( $_SERVER['REQUEST_URI'], 'adminfr'))? 'adminfr' : 'admin',
    'baseUrl' => ($_SERVER['SERVER_PORT'] == 443) ? "https://{$_SERVER['HTTP_HOST']}" : "http://{$_SERVER['HTTP_HOST']}",
    'imagePath' => array(
        'homePageSlider' => '/upload/homepageSlider/',
        'upload' => 'upload/',
        'hotel' => '/upload/hotel/',
    	'hoteldropzone' => 'upload/hotel/',
    	'homeBanner' => '/upload/homepageSlider/',
    	'homeAdBanner' => '/upload/ads/',
    	'homepageSliderPath'=>array("city","state","country","general"),
    	'city'=>'upload/city/',
    	'state'=>'upload/state/',
    	'imageNotFound'=>'/images/image_not_found.jpg',
    ),
    'photo_type' => array('jpg','jpeg','gif','png'),
    'contactNumber' => '123456789',
    'facebookPageUrl' => "",
    'googlePageUrl' => "",
    'twitterPageUrl' => "",
    'instagramPageUrl' => "",
    'linkedinPageUrl' => "",
            
    'blogUrl' => '/blog/',
    'thumbnails' => array(
            'homepageSlider'=>array("1280_646"=>"1280_646"),
            'homepageAds'=>array("960_133"=>"960_133","277_700"=>"277_700"),
    ),

    'defaultPageSize' => 10,
    'clientInvoicePercentage'=>5,
    'pageSizeOptions'=>array(10=>10,20=>20,50=>50,100=>100),
    'timeZone' => array(
    		'America/Adak' => "America/Adak",
    		'America/Barbados'=>'America/Barbados',
    		'America/Belem'=>'America/Belem',
    		'America/Belize'=>'America/Belize',
    		'America/Blanc-Sablon'=>'America/Blanc-Sablon'    		
    ),
    'commissionType' => array(
    		'description'=>'Description', 'offer'=>'Offer', 'guide'=>'Guide', 'nearby'=>'Nearby','transportation'=>'Transportation','howto'=>'How to get there?','parking'=>'Closed parking lot & Fee'
    ),
    'homeUrl' => '/'.$ADMINDIR.'/users',
    'logoutUrl'=>'/'.$ADMINDIR.'/default/login',
    
    'hkbAdminEmail' =>'ramhemareddy@gmail.com',
    'adminId' =>'1',
    'adminSpnId' =>'12345',
    'paymentGateway' => array( 
        'paypal' => array(
            'target_url'      => '',
            'call_back_url'   => '/controller name/callback',
            )
    ),
    'default' => array(
    		'countryId'     => 2,
    		'cityId' => 13,
    		'portalId'      => 1,
                'language_id'=>1,
                'invoice_payment_duration'=>18
    ),
    'smsConfig' => array(
        'api_key' => "",
        'api_secret' => "",
        'from' => '',
        'apiUrl' => ''
    ),
    'sms_verification_text' => 'Dayuse Reservation Verification Code: ',
    'months' => array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'),
    'monthWithInt' => array(
            1 => '01',
            2 => '02',
            3 => '03',
            4 => '04',
            5 => '05',
            6 => '06',
            7 => '07',
            8 => '08',
            9 => '09',
            10 => '10',
            11 => '11',
            12 => '12'
    ),
   'countrycode' => array("1"=>"US", "2"=>"can", "3"=>"in", "4"=>"FR"),
   'accountno'=>'4444',
   'sitename'=>'HK-Base',
);
