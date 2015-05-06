<?php

class ContactController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    // Uncomment the following methods and override them if needed

    /**
     * send contact details ot admin
     */
    public function actionSendContactDetails() {
        if ($_POST) {
            $bodyContent = '';

            $baseUrl = Yii::app()->getBaseUrl(true);
            $customerName = $_POST['gender'] . ", " . $_POST['first_name'] . " " . $_POST['last_name'];
            $emailId = Yii::app()->params['dayuseInfoEmail'];
            $contactMail['from'] = $_POST['email'];
            $contactMail['to'] = $emailId;
            $contactMail['subject'] = 'Dayuse- Contact Information!';

            $contactMail['body'] = $this->renderPartial('/mail/contact', array('customerName' => $customerName,
                'baseUrl' => $baseUrl,
                'message' => $_POST), true);
            $result = CommonHelper::sendMail($contactMail);
            
            $contactMail['to'] = 'arnaud.daniel@gmail.com';
            $result = CommonHelper::sendMail($contactMail);
                        
            if ($result) {
                echo "1";exit;
            }
        }
    }

}
