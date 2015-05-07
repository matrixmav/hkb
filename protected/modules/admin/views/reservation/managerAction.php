<?php
if ($data->reservation_status != 1 && $data->res_date >= date('Y-m-d')) {
    $optionLink = '<li><a href="/admin/reservation/reservationstatus?reservation_id=' . $data->id . '&customer_id='.$data->customer->id.'&admin_action=1&manager=1">Confirm</a></li>';
}
if ($data->res_date <= date('Y-m-d')) {
    $optionLink = '<li><a href="/admin/reservation/reservationstatus?reservation_id=' . $data->id . '&customer_id='.$data->customer->id.'&admin_action=2&manager=1">No Show</a></li>';
} else {
    $optionLink = '<li><a href="/admin/reservation/reservationstatus?reservation_id=' . $data->id . '&customer_id='.$data->customer->id.'&admin_action=6&manager=1">Refuse</a></li>';
}
?>
<a href='javascript:void(0)' class="customPopover" data-html='true' data-placement='left' data-toggle='popover' data-html='true' data-content='<ul class="popoverList"><?php echo $optionLink;?></ul>'><i title='Add / Edit' class='fa fa-external-link-square'></i></a> &nbsp;&nbsp;
    <script>
$('[data-toggle="popover"]').popover({
    trigger: 'click'
});

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
         if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});
</script>