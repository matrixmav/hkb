<?php

class HotelController extends Controller {

    /**
     * 
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/hotel';
    public $layout = 'hotel';
    public $title, $metadescription;
    public $fbOgTags = array();
    public $print = 0;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('allow', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionDetail() {

        $slug = $_GET['slug'];
        if (isset($_REQUEST['slug'])) {
            $slug = $_REQUEST['slug'];
        } else {
            $this->redirect('/');
        }

        $detail = Hotel::model()->findByAttributes(array('slug' => $slug));
        $action = $this->getAction()->getId();
        $this->loadMetas($action, $detail);
        $this->pageTitle = $detail->name . "-" . $detail->city()->name;
        $this->render('detail', array('detail' => $detail));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Hotel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Hotel'])) {
            $model->attributes = $_POST['Hotel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Hotel'])) {
            $model->attributes = $_POST['Hotel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Hotel');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Hotel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Hotel']))
            $model->attributes = $_GET['Hotel'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionRoomavailability() {
        $hotelid = $_REQUEST['hotelid'];
        $date = $_REQUEST['date'];
        $arrtime = $_REQUEST['arrtime'];
       
        echo Room::model()->hotelRoomDetails($hotelid, $date, $arrtime);
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Hotel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Hotel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Hotel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'hotel-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionContract() {
        $this->layout = 'layout_contract';
        //flush();
        /* $html2pdf = Yii::app()->ePdf->HTML2PDF();
          $html2pdf->WriteHTML($this->renderPartial('contractpagetwo', array(), true));
          $html2pdf->Output('contract.pdf', 'D'); */
        //$sessionvalue = Yii::app()->getSession()->getSessionId();


        if ((Yii::app()->user->getstate('user_id')) && (Yii::app()->user->getstate('access') == 'manager')) {
            $con_hid = (Yii::app()->user->getstate('contract_hotel_id')) ? Yii::app()->user->getstate('contract_hotel_id') : 0;

            if ($con_hid) {
                //Came after post
                if (isset($_POST['Hotel'])) {
                    $hotel_id = $con_hid;
                    $htadmin = $_POST['HotelAdmin'];
                    $htdetail = $_POST['Hotel'];
                    $hcontact = $_POST['HotelContact'];
                    $hemail = $_POST['HotelDetail']['email_address'];
                    $htroom = $_POST['Room'];
                    $rmopts = $_POST['RoomOpt'];

                    //Update Hotel detail
                    $hotel = Hotel::model()->findByPk($hotel_id);
                    $hotel->name = $htdetail['name'];
                    $hotel->star_rating = $htdetail['star_rating'];
                    $hotel->address = $htdetail['address'];
                    $hotel->country_id = $htdetail['country_id'];
                    $hotel->state_id = $htdetail['state_id'];
                    $hotel->city_id = $htdetail['city_id'];
                    $hotel->district_id = $htdetail['district_id'];
                    $hotel->postal_code = $htdetail['postal_code'];
                    $hotel->telephone = $htdetail['telephone'];
                    $hotel->fax = $htdetail['fax'];
                    $hotel->day_commission = $htdetail['day_commission'];
                    $hotel->night_commission = $htdetail['night_commission'];
                    $hotel->addon_commission = $htdetail['addon_commission'];
                    $hotel->updated_at = date("Y-m-d H:i:s", strtotime("now"));
                    $hotel->save(FALSE);

                    //Hotel Admin Data update
                    $hadmin = HotelAdministrative::model()->find('hotel_id=' . $hotel_id);

                    if ($hadmin == NULL) {
                        $hadmin = new HotelAdministrative;
                        $hadmin->hotel_id = $hotel_id;
                    }
                    $hadmin->hotel_ownfirst_name = $htadmin['hotel_ownfirst_name'];
                    $hadmin->hotel_ownlast_name = $htadmin['hotel_ownlast_name'];
                    $hadmin->registration_no = $htadmin['registration_no'];
                    $hadmin->vat_no = $htadmin['vat_no'];
                    $hadmin->updated_at = date("Y-m-d H:i:s", strtotime("now"));
                    $hadmin->save(FALSE);

                    //Hotel Contact 
                    foreach (Yii::app()->params->hotel_contact_info as $cky => $cval):

                        $hotelcontact = HotelContact::model()->find('hotel_id=' . $hotel_id . ' and contact_type=' . $cky);
                        if ($hotelcontact == NULL)
                            $hotelcontact = new HotelContact;

                        $hotelcontact->hotel_id = $hotel_id;
                        $hotelcontact->contact_type = $cky;

                        $name = explode(" ", $hcontact[$cky]['name']);
                        $hotelcontact->first_name = trim($name[0]);

                        $lname = "";
                        foreach ($name as $nky => $nval):
                            if ($nky != 0)
                                $lname .= $nval . " ";
                        endforeach;
                        $lname = trim($lname);

                        $hotelcontact->last_name = $lname;
                        $hotelcontact->telephone = $hcontact[$cky]['telephone'];
                        $hotelcontact->email_address = $hcontact[$cky]['email_address'];
                        $hotelcontact->added_at = date("Y-m-d H:i:s", strtotime("now"));
                        $hotelcontact->updated_at = date("Y-m-d H:i:s", strtotime("now"));
                        $hotelcontact->save(FALSE);

                    endforeach;

                    // Hotel Email
                    HotelEmail::model()->deleteAll('hotel_id=' . $hotel_id);
                    if (isset($hemail)) {
                        foreach ($hemail as $multiEmail) {
                            $hEmail = new HotelEmail();
                            $hEmail->email_add = $multiEmail;
                            $hEmail->hotel_id = $hotel_id;
                            $hEmail->save();
                        }
                    }

                    $roomids = array();
                    // Hotel Room
                    if (isset($htroom)) {
                        if (count($htroom)) {
                            foreach ($htroom as $rmky => $rm) {
                                if ($rm['name'] != "" && $rm['price'] != "") {
                                    $room = NULL;
                                    if ($rm['id'] != 0)
                                        $room = Room::model()->find('id=' . $rm['id'] . ' and hotel_id=' . $hotel_id);

                                    if ($room == NULL)
                                        $room = new Room;

                                    $room->name = $rm['name'];
                                    $room->hotel_id = $hotel_id;
                                    $room->category = 'sun';
                                    $room->room_status = 'open';
                                    $room->quantity = 10;
                                    $room->currency_id = Yii::app()->params->default['currency_id'];
                                    $room->default_price = $rm['price'];
                                    $room->default_discount_price = $rm['rac'];
                                    $room->available_from = $rm['available_from'];
                                    $room->available_till = $rm['available_till'];
                                    $room->exhausted_status = 'closed';
                                    $room->added_at = date("Y-m-d H:i:s", strtotime("now"));
                                    $room->updated_at = date("Y-m-d H:i:s", strtotime("now"));
                                    $room->save(FALSE);

                                    array_push($roomids, $room->id);
                                }
                            }
                        }
                    }

                    if (count($roomids)) {
                        //delete all the equipments from the rooms
                        $rmids = implode(",", $roomids);
                        RoomOptions::model()->deleteAll("room_id in (" . $rmids . ")");

                        if (isset($rmopts)) {
                            if (count($rmopts)) {
                                foreach ($rmopts as $opky => $opts):

                                    if ($opts['name'] != "") {
                                        $equip = Equipment::model()->findByPk($opts['equip_id']);
                                        if ($equip == NULL)
                                            $equip = new Equipment;

                                        $equip->hotel_id = $hotel_id;
                                        $equip->name = $opts['name'];
                                        $equip->type = 'room';
                                        $equip->base_type = 1;
                                        $equip->option_type_id = $opts['type'];
                                        $equip->default_price = $opts['price'];
                                        $equip->currency_id = Yii::app()->params->default['currency_id'];
                                        $equip->added_at = date("Y-m-d H:i:s", strtotime("now"));
                                        $equip->updated_at = date("Y-m-d H:i:s", strtotime("now"));
                                        $equip->save(FALSE);

                                        $eqid = $equip->id;

                                        foreach ($roomids as $rky => $rid):
                                            $room_options = new RoomOptions;
                                            $room_options->room_id = $rid;
                                            $room_options->equipment_id = $eqid;
                                            $room_options->price = $opts['price'];
                                            $room_options->currency_id = Yii::app()->params->default['currency_id'];
                                            $room_options->added_at = date("Y-m-d H:i:s", strtotime("now"));
                                            $room_options->updated_at = date("Y-m-d H:i:s", strtotime("now"));
                                            $room_options->save(FALSE);
                                        endforeach;
                                    }
                                endforeach;
                            }
                        }
                    }
                    /*
                      Yii::app()->session['hotel'] = $_POST['Hotel'];
                      //print_r(Yii::app()->session['hotel']);
                      //echo "------------------------------------------------------------------";
                      if(isset($_POST['Room']))
                      {
                      Yii::app()->session['room'] = $_POST['Room'];
                      }
                      if(isset($_POST['Contacts']))
                      {
                      Yii::app()->session['contacts'] = $_POST['Contacts'];
                      }
                      if(isset($_POST['Service']))
                      {
                      Yii::app()->session['service'] = $_POST['Service'];
                      }
                      if(isset($_POST['Services']))
                      {
                      Yii::app()->session['service'] = $_POST['Services'];
                      }
                      if(isset($_POST['Comission']))
                      {
                      Yii::app()->session['comission'] = $_POST['Comission'];
                      }
                      if(isset($_POST['Sign']))
                      {
                      Yii::app()->session['sign'] = $_POST['Sign'];
                      }
                      $this->redirect('contractpagetwo');
                     */

                    $this->redirect('contractpagetwo');
                }
                else {
                    //Get the hotel detail
                    $hotel = Hotel::model()->find('id=' . $con_hid);

                    $room = Room::model()->findAll('hotel_id=' . $con_hid);
                    $hadmin = HotelAdministrative::model()->find('hotel_id=' . $con_hid);
                    $hemail = HotelEmail::model()->findAll('hotel_id=' . $con_hid);

                    $this->render('contract', array(
                        'con_hid' => $con_hid,
                        'hotel' => $hotel,
                        'room' => $room,
                        'hemail' => $hemail,
                        'hadmin' => $hadmin
                    ));
                }
            } else
                $this->redirect(Yii::app()->getBaseUrl(true));
        } else
            $this->redirect(Yii::app()->getBaseUrl(true));
    }

    public function actionContractpagetwo() {
        $this->layout = 'layout_contract';

        if ((Yii::app()->user->getstate('user_id')) && (Yii::app()->user->getstate('access') == 'manager')) {
            $con_hid = (Yii::app()->user->getstate('contract_hotel_id')) ? Yii::app()->user->getstate('contract_hotel_id') : 0;

            if ($con_hid) {
                if (isset($_POST['Hotel'])) {

                    if ($_FILES['Photo']['name'] != '') {
                        $phfile = $_FILES['Photo'];
                        $upfileinfo = pathinfo($phfile['name']);
                        if ($upfileinfo['extension'] == 'zip') {
                            $folder = Yii::app()->params->imagePath['hoteldropzone']; // folder for uploaded files
                            $idPath = $con_hid . "/";
                            $inputpath = $folder . $idPath;
                            if (!is_dir($inputpath) && !mkdir($inputpath, '0777', true)) {
                                die("Error creating folder $inputpath");
                            }
                            chmod($inputpath, 0777);

                            $path = $phfile['tmp_name'];

                            $zip = new ZipArchive;
                            $position = 0;
                            if ($zip->open($path) === true) {
                                for ($i = 0; $i < $zip->numFiles; $i++) {
                                    $filename = $zip->getNameIndex($i);
                                    $fileinfo = pathinfo($filename);

                                    if (isset($fileinfo['extension'])) {
                                        if (in_array($fileinfo['extension'], Yii::app()->params->contract_photo_type)) {
                                            copy("zip://" . $path . "#" . $filename, $inputpath . $fileinfo['basename']);
                                            chmod($inputpath . $fileinfo['basename'], 0777);

                                            $sourceImageName = $fileinfo['basename'];
                                            $targetName = CommonHelper::generateNewNameOfImage($sourceImageName);

                                            $options = Yii::app()->params['thumbnails']['hotel'];
                                            CommonHelper::generateCropImage($inputpath, $fileinfo['basename'], $inputpath, $targetName, $options);

                                            $position++;

                                            $hotelPhoto = new HotelPhoto();
                                            $hotelPhoto->hotel_id = $con_hid;
                                            $hotelPhoto->name = $targetName;
                                            $hotelPhoto->position = $position;
                                            $hotelPhoto->is_featured = 0;
                                            $hotelPhoto->is_slider = 0;
                                            $hotelPhoto->status = 1;
                                            $hotelPhoto->save();
                                        }
                                    }
                                }
                                $zip->close();
                            }
                        }
                    }


                    //Update Equipment
                    $equip = $_POST['Hotel']['equip'];

                    if (count($equip)) {
                        //Remove all existing equipments for the hotel
                        $rem_equip = HotelEquipment::model()->deleteAll('hotel_id=' . $con_hid);

                        foreach ($equip as $eky => $eval):
                            $equip = new HotelEquipment;
                            $equip->hotel_id = $con_hid;
                            $equip->equipment_id = $eval;
                            $equip->added_at = date("Y-m-d H:i:s", strtotime("now"));
                            $equip->updated_at = date("Y-m-d H:i:s", strtotime("now"));
                            $equip->save(FALSE);
                        endforeach;
                    }

                    //Update Theme
                    $theme = $_POST['Hotel']['theme'];

                    if (count($theme)) {
                        //Remove all existing equipments for the hotel
                        $rem_theme = HotelTheme::model()->deleteAll('hotel_id=' . $con_hid);

                        foreach ($theme as $tky => $thval):
                            $equip = new HotelTheme;
                            $equip->hotel_id = $con_hid;
                            $equip->theme_id = $thval;
                            $equip->added_at = date("Y-m-d H:i:s", strtotime("now"));
                            $equip->updated_at = date("Y-m-d H:i:s", strtotime("now"));
                            $equip->save(FALSE);
                        endforeach;
                    }

                    //Update content
                    $content = $_POST['Hotel']['content'];

                    foreach ($content as $cnky => $cnval):
                        $hotelcontent = HotelContent::model()->find('hotel_id=' . $con_hid . ' and type="' . $cnky . '" and portal_id=' . Yii::app()->params->default['portalId']);

                        if ($hotelcontent == NULL)
                            $hotelcontent = new HotelContent;

                        $hotelcontent->portal_id = Yii::app()->params->default['portalId'];
                        $hotelcontent->hotel_id = $con_hid;
                        $hotelcontent->content = $cnval;
                        $hotelcontent->type = $cnky;
                        $hotelcontent->language_id = Yii::app()->params->default['language_id'];

                        $hotelcontent->added_at = date("Y-m-d H:i:s", strtotime("now"));
                        $hotelcontent->updated_at = date("Y-m-d H:i:s", strtotime("now"));
                        $hotelcontent->save(FALSE);
                    endforeach;

                    $this->redirect('contractpagethree');
                }
                else {
                    // Get all the equipments
                    $criteria = new CDbCriteria;
                    $criteria->addCondition("hotel_id=0");
                    $criteria->addCondition("base_type=0");
                    $criteria->order = "type ASC";

                    $equipments = Equipment::getAllEquipment($criteria);

                    //Get all the equipments added for the hotel
                    $hotelequip = array();
                    $criteria = "hotel_id=" . $con_hid;
                    $heq = HotelEquipment::getAllHotelEquipment($criteria);
                    if ($heq != NULL) {
                        foreach ($heq as $hky => $eq):
                            array_push($hotelequip, $eq->equipment_id);
                        endforeach;
                    }

                    //Get all the themes
                    $themes = Theme::getAllTheme();

                    //Get themes which are added for the hotel
                    $hotelthemes = array();
                    $criteria = "hotel_id=" . $con_hid;
                    $hth = HotelTheme::getAllHotelTheme($criteria);
                    if ($hth != NULL) {
                        foreach ($hth as $tky => $th):
                            array_push($hotelthemes, $th->theme_id);
                        endforeach;
                    }

                    //Add content for based on definition added in parameters - hotelContentType
                    $content = array('description' => 'Description', 'nearby' => 'Nearby', 'transportation' => 'Transportation', 'parking' => 'Closed parking lot & Fee');

                    $this->render('contractpagetwo', array(
                        'hotel_id' => $con_hid,
                        'equipments' => $equipments,
                        'hotelequip' => $hotelequip,
                        'themes' => $themes,
                        'hotelthemes' => $hotelthemes,
                        'content' => $content
                    ));
                }
            } else
                $this->redirect(Yii::app()->getBaseUrl(true));
        } else
            $this->redirect(Yii::app()->getBaseUrl(true));




        /* if(isset($_POST['amenities']))
          {
          Yii::app()->session['amenities'] = $_POST['amenities'];
          if(isset($_POST['Category']))
          {
          Yii::app()->session['category'] = $_POST['Category'];
          }
          if(isset($_POST['Category']))
          {
          Yii::app()->session['category'] = $_POST['Category'];
          }
          if(isset($_POST['Chain']))
          {
          Yii::app()->session['chain'] = $_POST['Chain'];
          }
          if(isset($_POST['Detail']))
          {
          Yii::app()->session['detail'] = $_POST['Detail'];
          }
          $this->redirect('contractpagethree');
          }
          $this->render('contractpagetwo');
         */
    }

    public function actionContractpagethree() {
        $con_hid = (Yii::app()->user->getstate('contract_hotel_id')) ? Yii::app()->user->getstate('contract_hotel_id') : 0;

        if ($con_hid) {
            if (isset($_FILES['contract'])) {
                if ($_FILES['contract']['name'] != '') {
                    $hadmin = HotelAdministrative::model()->find('hotel_id=' . $con_hid);
                    if ($hadmin != NULL) {

                        //print_r($_FILES);
                        //Array ( [contract] => Array ( [name] => 500-8695727.pdf [type] => application/pdf [tmp_name] => /tmp/phptrqO5Y [error] => 0 [size] => 10253 ) ) ­
                        $phfile = $_FILES['contract'];
                        $upfileinfo = pathinfo($phfile['name']);
                        //print_r($upfileinfo);
                        //Array ( [dirname] => . [basename] => 500-8695727.pdf [extension] => pdf [filename] => 500-8695727 ) ­
                        if ($upfileinfo['extension'] == 'pdf') {
                            $folder = Yii::app()->params->imagePath['hoteldropzone']; // folder for uploaded files
                            $idPath = $con_hid . "/contract/";
                            $inputpath = $folder . $idPath;
                            $hotel_folder = $folder . $con_hid . "/";

                            if (!is_dir($hotel_folder) && !mkdir($hotel_folder, '0777', true)) {
                                die("Error creating folder $hotel_folder");
                            }
                            //chmod($hotel_folder, 0777);

                            if (!is_dir($inputpath) && !mkdir($inputpath, '0777', true)) {
                                die("Error creating folder $inputpath");
                            }
                            chmod($inputpath, 0777);

                            $targetPath = $inputpath . $phfile["name"];
                            if (move_uploaded_file($phfile["tmp_name"], $targetPath)) {
                                chmod($targetPath, 0777);

                                $hadmin->contract_file = $phfile["name"];
                                $hadmin->save(FALSE);

                                //Send Email along with the attachment
                                $hotel = Hotel::model()->findbyPk($con_hid);

                                $contactMail['from'] = Yii::app()->params['dayuseInfoEmail'];
                                $contactMail['to'] = Yii::app()->params['dayuseContractReceiver'];
                                $contactMail['subject'] = 'DAYSTAY - New Contract Uploaded';
                                $contactMail['file_path'] = $targetPath;

                                $contactMail['body'] = $this->renderPartial('/mail/send_contract', array('HotelName' => $hotel->name,), true);
                                $result = CommonHelper::sendMail($contactMail);

                                $contactMail['from'] = Yii::app()->params['dayuseInfoEmail'];
                                $contactMail['to'] = 'arnaud.daniel@gmail.com';
                                $contactMail['subject'] = 'DAYSTAY - New Contract Uploaded';
                                $contactMail['file_path'] = $targetPath;

                                $contactMail['body'] = $this->renderPartial('/mail/send_contract', array('HotelName' => $hotel->name,), true);
                                $result = CommonHelper::sendMail($contactMail);
                                if($result){
                                    echo "<script>alert('Your message has been sent.');</script>";
                                }
                            }
                        }
                    }
                }
            }
            $this->render('contractpagethree');
        } else
            $this->redirect(Yii::app()->getBaseUrl(true));
    }

    public function actionDownloadpdf() {
        $this->redirect('fullcontract');
        //$this->renderPartial('contractpagetwo', array(), true)
        /* $html2pdf = Yii::app()->ePdf->HTML2PDF();
          $html2pdf->WriteHTML($this->renderPartial('test', array(), true));
          $html2pdf->Output('contract.pdf', 'D'); */
    }

    public function actionFullcontract() {
        $con_hid = (Yii::app()->user->getstate('contract_hotel_id')) ? Yii::app()->user->getstate('contract_hotel_id') : 0;

        if ($con_hid) {
            //Get the hotel detail
            $hotel = Hotel::model()->find('id=' . $con_hid);

            $room = Room::model()->findAll('hotel_id=' . $con_hid);
            $hadmin = HotelAdministrative::model()->find('hotel_id=' . $con_hid);
            $hemail = HotelEmail::model()->findAll('hotel_id=' . $con_hid);


            // Get all the equipments
            $criteria = new CDbCriteria;
            $criteria->addCondition("hotel_id=0");
            $criteria->addCondition("base_type=0");
            $criteria->order = "type ASC";

            $equipments = Equipment::getAllEquipment($criteria);

            //Get all the equipments added for the hotel
            $hotelequip = array();
            $criteria = "hotel_id=" . $con_hid;
            $heq = HotelEquipment::getAllHotelEquipment($criteria);
            if ($heq != NULL) {
                foreach ($heq as $hky => $eq):
                    array_push($hotelequip, $eq->equipment_id);
                endforeach;
            }

            //Get all the themes
            $themes = Theme::getAllTheme();

            //Get themes which are added for the hotel
            $hotelthemes = array();
            $criteria = "hotel_id=" . $con_hid;
            $hth = HotelTheme::getAllHotelTheme($criteria);
            if ($hth != NULL) {
                foreach ($hth as $tky => $th):
                    array_push($hotelthemes, $th->theme_id);
                endforeach;
            }

            //Add content for based on definition added in parameters - hotelContentType
            $content = array('description' => 'Description', 'nearby' => 'Nearby', 'transportation' => 'Transportation', 'parking' => 'Closed parking lot & Fee');

            //Remove the header portion        
            $this->print = 1;
            $this->layout = 'layout_contract';
            $render = $this->render('fullcontract', array(
                'con_hid' => $con_hid,
                'hotel' => $hotel,
                'room' => $room,
                'hemail' => $hemail,
                'hadmin' => $hadmin,
                'equipments' => $equipments,
                'hotelequip' => $hotelequip,
                'themes' => $themes,
                'hotelthemes' => $hotelthemes,
                'content' => $content,
                'hotel_id' => $con_hid
            ));
            //Partial,TRUE

            $folder = Yii::app()->params->imagePath['hoteldropzone']; // folder for uploaded files
            $idPath = $con_hid . "/contract/";
            $inputpath = $folder . $idPath;
            $hotel_folder = $folder . $con_hid . "/";

            if (!is_dir($hotel_folder) && !mkdir($hotel_folder, '0777', true)) {
                die("Error creating folder $hotel_folder");
            }
            chmod($hotel_folder, 0777);

            if (!is_dir($inputpath) && !mkdir($inputpath, '0777', true)) {
                die("Error creating folder $inputpath");
            }
            chmod($inputpath, 0777);

            echo $inputpath;

            $outputFilePath = $inputpath . '/Projet.pdf';
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($render);
            $html2pdf->Output($outputFilePath, EYiiPdf::OUTPUT_TO_FILE);
            chmod($outputFilePath, 0777);
            exit;
        }
    }

    protected function loadMetas($action = 'detail', $hoteldetails) {

        $action = strtolower($action); // action can be index, restaurantphotos, restaurantmenu, restaurantavis, restaurantgroupes
        $model = $hoteldetails;

        $meta = "";
        $fbOgTags = array();
        $this->title = $model->name;
        $fbOgTags['title'] = $model->name;
        $content = HotelContent::model()->findByAttributes(array('hotel_id' => $model->id));
        if ($content != NULL) {
            $meta = $content->content;
        }
        $image = HotelPhoto::model()->findByAttributes(array('hotel_id' => $model->id, 'is_featured' => 1));
        if (empty($image)) {
            $image = HotelPhoto::model()->findByAttributes(array('hotel_id' => $model->id));
        }
        $this->metadescription = $meta;
        $fbOgTags['description'] = $this->metadescription;

        $baseurl = Yii::app()->getBaseUrl(true);
        $src = $baseurl . '/upload/hotel/' . $model->id . '/' . $image->name;
        $fbOgTags['image'] = $src;
        $fbOgTags['site_name'] = "Daystay";
        $this->fbOgTags = $fbOgTags;
        //echo '<pre>';print_r($this->fbOgTags);exit;
    }

}
