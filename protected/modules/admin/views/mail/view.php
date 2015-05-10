<?php
$this->breadcrumbs = array(
    'Email' => array('/admin/mail'),
    'Read'
);
?>

<div class="row">
    <div class="col-md-12">
            <?php echo CHtml::link(Yii::t('translation', 'Inbox'), '/admin/mail', array("class" => "btn  green margin-right-20")); ?>
            <?php echo CHtml::link(Yii::t('translation', 'Compose') . ' <i class="fa fa-plus"></i>', '/admin/mail/compose', array("class" => "btn  green margin-right-20")); ?>
            <?php echo CHtml::link(Yii::t('translation', 'Sent'), '/admin/mail/sent', array("class" => "btn  green margin-right-20")); ?>
    </div>
</div>

<div class="col-md-12 form-group">
    <label class="col-md-1">Sender:</label>
    <div class="col-md-6">
        <p><?php echo $mailObject->touser->full_name; ?></p>
    </div>
</div>
<div class="col-md-12 form-group">
    <label class="col-md-1">Receiver:</label>
    <div class="col-md-6">
        <p><?php echo $mailObject->fromuser->full_name; ?></p>
    </div>
</div>
<div class="col-md-12 form-group">
    <label class="col-md-1">Subject:</label>
    <div class="col-md-6">
        <p><?php echo $mailObject->subject; ?></p>
    </div>
</div>
<div class="col-md-12 form-group">
    <label class="col-md-1">Message:</label>
    <div class="col-md-6">
        <p><?php echo $mailObject->message; ?></p>
    </div>
</div>
<?php if(!empty($mailObject->attachment)){ ?>
<div class="col-md-12 form-group">
    <label class="col-md-1">Attachement </label>
    <div class="col-md-6">
        <p><?php echo $mailObject->attachment; ?></p>
    </div>
</div>
<?php } ?>


