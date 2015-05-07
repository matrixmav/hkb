<style>
    #hiddendrop ul{position: absolute;z-index: 1;background: #fff;width: 579px;box-sizing: border-box;list-style-type: none;padding: 0px;margin: -1px 0 0 7px;border: 1px solid #999999;border-top:0;}
    #hiddendrop ul li{padding: 8px 0 8px 15px;}
    #hiddendrop ul li a{color:#333;cursor:pointer;}
    #hiddendrop ul li a:hover{text-decoration: none; }
    #hiddendrop ul li:nth-child(odd){background: #fafafa;}
</style>
<?php
$this->breadcrumbs = array(
    'Area' => array('/admin/area'),
    'Area'
);
$curController = @Yii::app()->controller->id;
$curAction = @Yii::app()->getController()->getAction()->controller->action->id;
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts') . '/formassets.php';
?>
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i><?php echo ucwords($curAction); ?> <?php echo ucwords($curController); ?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse">
            </a>
        </div>
    </div>
    <div class="portlet-body form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route) . "?id=$model->id",
            'id' => 'form_sample_3_area',
            'method' => 'get',
            'htmlOptions' => array(
                'class' => 'form-horizontal',
                'role' => 'form'
            )
        ));
        ?>		
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
                    Country
                </label>
                <div class="col-md-7">
                    <?php
                    $criteria = new CDbCriteria;
                    $criteria->addCondition("status=1");
                    $countries = Country::model()->findAll($criteria);
                    if (!empty($countries)) {
                        ?>
                        <select id="country_id" name='State[country_id]' class="form-control select2me">
                            <?php
                            $i = 0;
                            foreach ($countries as $listctry) {
                                ?>
                                <option <?php if($listctry->id == 2){echo 'selected';}?> value="<?php echo $listctry->id; ?>" <?php if (isset($selected)) {
                            echo $selected;
                        } ?>><?php echo $listctry->name; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <?php echo $form->hiddenField($model, 'slug', array('class' => 'form-control')); ?>

            <?php if (isset($model->id)) { ?>
                <input type="hidden" name="City[update]" value="<?php echo $model->id; ?>" />
            <?php } ?>
                        <input type="hidden" name="City[cityid]" id="cityid" value="<?php if (isset($model->id)) {
                $findcityid = AreaCity::model()->with('city')->findByPk($_GET['id']);
                echo $findcityid->city_id['name'];
            } ?>" />
            <div class="form-group">
                <label class="control-label col-md-3">City</label>
                <div class="col-md-7">
                    <input type="text" autocomplete="off" id="slectbox" class="form-control" value="<?php
                    if (isset($model->id)) {
                        $findcityid = AreaCity::model()->with('city')->findByPk($_GET['id']);                
                        echo $findcityid->city['name'];
                    }
                    ?>" />
                </div>
                <div class="form-group noMargin">
                    <label class="control-label col-md-3 nopadding"></label>
                    <div id="hiddendrop" class="col-md-7" style="display:none;"></div>									
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3">
                    <?php echo $model->getAttributeLabel('name'); ?><span class="required"> * </span>
                </label>
                <div class="col-md-7">
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
                </div>
            </div>
        </div>

        <div class="form-actions fluid">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">Submit</button>
                <a class="btn default" href="/admin/area">Cancel</a>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/custom/form-validation-area.js?ver=<?php echo strtotime("now"); ?>"></script>
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">
    var transDigits = "<?php echo Yii::t('translation', 'Digits Only'); ?>";
    jQuery(document).ready(function () {
        //ComponentsDropdowns.init();	

        $('#slectbox').keyup(function () {

            var citylike = $(this).val();
            var countryid = $('#country_id').val();
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('admin/area/citydrop'); ?>",
                data: {citylike: citylike, countryid: countryid},
                success: function (result) {
                    $('#hiddendrop').show();
                    $('#hiddendrop').html(result);
                    //ComponentsDropdowns.init();
                    cityanchor();
                }
            });

        });

        function cityanchor()
        {
            $('.anchorcls').click(function () {
                $('#cityid').val($(this).attr("id"));
                $('#slectbox').val($(this).text());
                $('#hiddendrop').hide();
            });
        }

    });
</script>