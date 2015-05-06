<?php
$this->breadcrumbs = array(
    'Client' => array('/admin/client'),
    'Client'
);
$headerName = 'Create Client';
if (isset($_REQUEST['clientId'])) {
    $headerName = 'Edit Client';
}
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts') . '/formassets.php';
?>
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i><?php echo $headerName; ?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse">
            </a>
        </div>
    </div>
    <div class="portlet-body form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'id' => 'form_sample_3_client',
            'method' => 'get',
            'htmlOptions' => array(
                'class' => 'form-horizontal',
                'role' => 'form',
                'data-type' => 'index'
            )
        ));
        ?>
        <?php echo $form->hiddenField($model, 'id', array('class' => 'form-control')); ?>   
        <div class="form-body">
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                You have some form errors. Please check below.
            </div>
            <div class="alert alert-success display-hide">
                <button class="close" data-close="alert"></button>
                Your form validation is successful!
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    Name<span class="required"> * </span>
                </label>
                <div class="col-md-7">
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
                </div>
            </div>
            <?php if ($model->scenario == 'update') { ?>
                <div class="form-group">
                    <label class="control-label col-md-3">
                        Client No
                    </label>
                    <div class="col-md-7">
                        <?php echo $form->textField($model, 'client_no', array('class' => 'form-control', 'readOnly' => true)); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-md-3">
                    Address<span class="required"> * </span>
                </label>
                <div class="col-md-7">
                    <?php echo $form->textArea($model, 'address', array('class' => 'form-control')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">
                    Postal Code<span class="required"> * </span>
                </label>
                <div class="col-md-7">
                    <?php echo $form->textField($model, 'postal_code', array('class' => 'form-control')); ?>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3">
                    Country<span class="required"> * </span>
                </label>
                <div class="col-md-7">
                    <select  id="country_id" name="Client[country_id]" onchange="getCountryCityList(this.value)" class="form-control select2me">  
                        <?php
                        $criteria = new CDbCriteria;
                        $criteria->addCondition("status=1");
                        $countries = Country::getAllCountry($criteria);
                        $setcountryid = '';
                        $i = 0;
                        foreach ($countries as $country) {
                            $countrySelected = "";
                            if ($country->id == $model->country_id)
                                $countrySelected = "selected='selected'";
                            if ($i == 0) {
                                $setcountryid = $country->id;
                                $i++;
                            }
                            ?>			
                            <option <?php
                            if ($country->id == 2) {
                                echo 'selected';
                            }
                            ?> value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option> 
                                <?php
                            }
                            ?>		 
                    </select>

                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">
                    City<span class="required"> * </span>
                </label>
                <div class="col-md-7" id="citydropdownList">
                </div>
                <div class="col-md-7" id="citytextbox">
<?php echo $form->textField($model, 'city', array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    EmailID<span class="required"> * </span>
                </label>
                <div class="col-md-7">
<?php echo $form->textField($model, 'email_add', array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    Language<span class="required"> * </span>
                </label>
                <div class="col-md-7">
                    <select  name="Client[language_id]" class="form-control select2me">  
                        <?php
                        $languages = Language::getAllLanguage();
                        foreach ($languages as $language) {
                            ?>			
                            <option value="<?php echo $language->id; ?>"><?php echo $language->name; ?></option> 
                            <?php
                        }
                        ?>		 
                    </select>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">
                    Vat-No<span class="required"> * </span>
                </label>
                <div class="col-md-7">
<?php echo $form->textField($model, 'vat_no', array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-actions fluid">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">Submit</button>
                    <a class="btn default" href="/admin/client">Cancel</a>
                </div>
            </div>
<?php $this->endWidget(); ?>
        </div>
    </div>
    <script src="/metronic/custom/form-validation-client.js?ver=<?php echo strtotime("now"); ?>"></script>
    <script src="/metronic/assets/scripts/custom/components-dropdowns.js"></script>