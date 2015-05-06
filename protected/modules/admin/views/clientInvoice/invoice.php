<style type="text/css">
.mainWrapperPane{width:100%; padding:10px;}
.mainWrapper{width:700px; overflow: hidden;}
td{vertical-align:top;font-size: 13.4px; line-height: 17px;text-align: left;}
th{background: #efefef; text-align:left;font-weight: bold;}
.chart{margin-top: 20px;}
.chart th{padding:5px 1px;}
.chart td, .chart th{text-align: right;}
.chart td:nth-child(1), .chart th:nth-child(1){text-align: left;}
.chart td:nth-child(3){text-align: center;} 
</style>
<div class="mainWrapperPane">
<table class="mainWrapper">
    <tr>
        <td style="width:15%;"><b>Invoice Id</b></td>
        <td style="width:2%;"><b>:</b></td>
        <td><?php echo $invoiceObject->client_inv_no; ?></td>
    </tr>
    <tr>
        <td style="width:15%;"><b>Date</b></td>
        <td style="width:2%;"><b>:</b></td>
        <td><?php echo $invoiceObject->inv_date; ?></td>
    </tr>
    <tr>
        <td style="width:15%;"><b>Client</b></td>
        <td style="width:2%;"><b>:</b></td>
        <td><?php echo $invoiceObject->client->name; ?></td>
    </tr>
</table>
<table class="chart">
    <tr>
        <th style="width:30%;">Title</th>
        <th style="width:20%;">Unit Price</th>
        <th style="width:5%;">Qty</th>
        <th style="width:10%;">Vat</th>
        <th style="width:15%;">Vat Amount</th>
        <th style="width:15%;">Total Amount</th>
    </tr>
    <?php 
    $totalAmount = 0;
    foreach($clientInvoiceList as $clientInvoice){ ?>
    <tr>
        <td style="width:30%;"><?php echo $clientInvoice->title; ?></td>
        <td style="width:20%;"><?php echo $clientInvoice->unit_price; ?></td>
        <td style="width:5%;"><?php echo $clientInvoice->qty; ?></td>
        <td style="width:10%;"><?php echo $clientInvoice->vat; ?></td>
        <td style="width:20%;"><?php echo $clientInvoice->vat_amt; ?></td>
        <td style="width:20%;"><?php echo $clientInvoice->tot_amt; ?></td>
    </tr>
    <?php $totalAmount+=$clientInvoice->tot_amt; } ?>
    <tr>
        <td colspan="6" style="text-align: right"><b><?php echo $totalAmount.".00"; ?></b></td>
    </tr>
</table>
</div>