<?php
/* @var $this AccessCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Management',
);
//user management
//registered users
$admin_user_icons= Yii::app()->params->admin_user_icons;
$form_title = ($adminuser_id==0)? "New Admin User" : "Update Admin User";

//Yii::app()->request->baseUrl."/admin/images/".;
?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<div class="portlet box green">
<div class="portlet-title">
	<div class="caption">
		<i class="fa fa-reorder"></i><?php echo $form_title;?>
	</div>
	<div class="tools">
		<a href="javascript:;" class="collapse">
		</a>
	</div>
</div>
<div class="portlet-body form">
<form class="form-horizontal" role="form" id="form_aduser" action="/admin/accessCategory/adminuser" method="post">
<input type="hidden" name="adminuser_id" value="<?php echo $adminuser_id;?>">
<div class="form-body">
	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		You have some form errors. Please check below.	</div>
	<div class="alert alert-success display-hide">
		<button class="close" data-close="alert"></button>
		Your form validation is successful!	</div>
									
        <div class="form-group"><label class="control-label col-md-3">First Name : <span class="required"> * </span></label>
		<div class="col-md-3">
                    <input data-validation="required" class="form-control dvalid freesale" name="firstname" type="text" maxlength="60" value="<?php echo ($aduser!=NULL)? $aduser->first_name : "";?>"/>
                </div>
	</div>
        <div class="form-group"><label class="control-label col-md-3">Last Name : <span class="required"> * </span></label>
		<div class="col-md-3">
			<input data-validation="required" class="form-control dvalid freesale" name="lastname" type="text" maxlength="50" value="<?php echo ($aduser!=NULL)? $aduser->last_name : "";?>"/>
                </div>
	</div>
        <div class="form-group"><label class="control-label col-md-3">Email : <span class="required"> * </span></label>
		<div class="col-md-6">
			<input data-validation="required" class="form-control dvalid freesale" name="emailadd" type="text" maxlength="70" value="<?php echo ($aduser!=NULL)? $aduser->email_address : "";?>"/>
                </div>
	</div>
        <div class="form-group"><label class="control-label col-md-3">Password :</label>
		<div class="col-md-3">
			<input class="form-control dvalid freesale" name="pass" type="text" maxlength="35" value=""/>
                </div>
	</div>
        <div class="form-group"><label class="control-label col-md-3">Mobile : <span class="required"> * </span></label>
		<div class="col-md-3 radio-list">
                    <label>
			<input data-validation="required" class="form-control dvalid freesale" name="mobno" type="text" maxlength="12" value="<?php echo ($aduser!=NULL)? $aduser->telephone : "";?>"/>
                    </label>
                </div>
	</div>
        <div class="form-group">
            <label class="control-label col-md-3">Categories : </label>
		<div class="col-md-3 radio-list">
                <?php
                    $cn=0;
                    foreach($acc_cat as $ky=>$cat)
                    {
                        if(count($catacc))
                            $selected = (in_array($cat->id,$catacc))? "checked" : "";
                        else
                        {
                            $selected = ($cn==0)? "checked" : "";
                            $cn++;
                        }                                               
                        ?>
                    <label>
                        <input type="radio" name="catId" <?php echo $selected; ?> value="<?php echo $cat->id;?>"><?php echo $cat->name;?>
                    </label>
                        <?php
                    }
                    ?>
                </div>
	</div>
        <div class="form-group"><label class="control-label col-md-3">Portals : </label>
		<div class="col-md-3 radio-list">
		<?php
                    $cn=0;
                    foreach($portal as $ky=>$port)
                    {
                        if(count($portacc))
                            $selected = (in_array($port->id,$portacc))? "checked" : "";
                        else
                        {
                            $selected = ($cn==0)? "checked" : "";
                            $cn++;
                        } 
                        ?>
                        <label>
                        <input type="radio" name="portId" <?php echo $selected; ?> value="<?php echo $port->id;?>"><?php echo $port->name;?>
                        </label>
                        <?php
                    }
                    ?>
                </div>
	</div>
        <div class="form-group"><label class="control-label col-md-3">Icons : </label>
		<div class="col-md-3 radio-list">
                    <?php
                    $cn=0;
                    foreach($admin_user_icons as $ky=>$uimg)
                    {
                        if($aduser!=NULL)
                            $selected = ($uimg==$aduser->user_icon)? "checked" : "";
                        else
                        {
                            $selected = ($cn==0)? "checked" : "";
                            $cn++;
                        }                         
                        ?>
                    <label>
                        <input type="radio" <?php echo $selected; ?> name="iconId" value="<?php echo $uimg;?>"><img src="<?php echo Yii::app()->request->baseUrl."/images/admin/".$uimg; ?>">
                    </label>
                        <?php
                    }
                    ?>
                </div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" name="sub" value="action" class="btn green">Submit</button>	
				<a class="btn default" href="/admin/accessCategory/list">Cancel</a>			
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	
</div>
</form>
</div>
</div>
<h4>Registered Users</h4>
<div class="row">
	<div class="col-md-12">
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$dataProvider,
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
	'summaryText'=>'Showing {start} to {end} of {count} entries'.
    CHtml::dropDownList(
         'pageSize',
         $pageSize,
         Yii::app()->params['pageSizeOptions'],
         array('class'=>'change-pageSize')) .' rows per page',
	'template'=>'{items} {summary} {pager}',
	'itemsCssClass'=>'table table-striped table-bordered table-hover table-full-width',
	'pager'=>array(
		'header'=>false,
		'firstPageLabel' => "<<",
		'prevPageLabel' => "<",
		'nextPageLabel' => ">",
		'lastPageLabel' => ">>",
	),	
	'columns'=>array(
		//'idJob',
		array(
			'name'=>'first_name',
			'header'=>'<span style="white-space: nowrap;">Name</span>',
			'value'=>array($this,'getFullname'),
		),
                array(
			'name'=>'email_address',
			'header'=>'<span style="white-space: nowrap;">Email Address</span>',
			'value'=>'$data->email_address',
		),
                array(
			'name'=>'first_name',
			'header'=>'<span style="white-space: nowrap;">Category</span>',
			'value'=>array($this,'getCatname'),
		),
                array(
			'name'=>'status',
			'header'=>'<span style="white-space: nowrap;">Status</span>',
			'value'=>array($this,'getStatus'),
		),
		//'city.name:text:City',
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>'Edit',
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/accessCategory/list", array("auid"=>$data->id))',
				),
				'Delete' => array(
					'label'=>'Delete',
					'options'=>array('class'=>'fa fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/accessCategory/admindelete", array("auid"=>$data->id))',
				),
			),
		),
	),
)); ?>
</div>
</div>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js?ver=<?php echo strtotime("now");?>"></script>
<script src="/metronic/custom/form-validation-accesscategory.js?ver=<?php echo strtotime("now");?>"></script>
<!-- END PAGE LEVEL STYLES -->

<script>
jQuery(document).ready(function() {   
         FormadminValidation.init();
 });
</script>