<?php

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

?><div class="wrap">

<h1 class="wp-heading-inline"><?php
	echo esc_html( __( 'Paypal IPN Mailchimp Log', 'wppitm-log' ) );
?></h1>

<hr class="wp-header-end">
<br/>
<?php
$url = admin_url( 'admin.php?page=wppitm_logs' );

$button = sprintf( '<button class="button-primary" id="wppitm-logs" name="wppitm-logs"><a href="%2$s" style="color: #fff;">%1$s</a></button>', esc_attr( __( 'Back', 'wppitm-log' ) ), $url );

echo $button;

?>
<br/>
<br/>
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Payer Information</div>
            <div class="panel-body">
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Email:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('email');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">First Name:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('first_name');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Last Name:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('last_name');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Country:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('country');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">City:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('city');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">State:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('state');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Zip Code:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('zip');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Type:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('type');?></label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-green">
            <div class="panel-heading">Transaction Information</div>
            <div class="panel-body">
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Payment Status:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('status');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Buyer ID:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('buyer_id');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Shipping:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('shipping');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Shipping Discount:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('shipping_discount');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Shipping Method:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('shipping_method');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Fee:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('fee');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Insurance Amount:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('insurance');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-5 control-label text-right">Payment Type:</label>
                    <label class="col-lg-7 control-label"><?php echo $log->prop('payment_type');?></label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-blue">
            <div class="panel-heading">Mailchimp Information</div>
            <div class="panel-body">
                <div class="input-group row">
                    <label class="col-lg-3 control-label text-right">Status:</label>
                    <label class="col-lg-9 control-label"><?php echo $log->prop('mailchimp_status');?></label>
                </div>
                <?php if ($log->prop('mailchimp_status') == 'SUCCESS') { ?>
                <div class="input-group row">
                    <label class="col-lg-3 control-label text-right">Mailchimp ID:</label>
                    <label class="col-lg-9 control-label"><?php echo $log->prop('mailchimp_id');?></label>
                </div>
                <?php } else if ($log->prop('mailchimp_status') == 'FAIL') { ?>
                <div class="input-group row">
                    <label class="col-lg-3 control-label text-right">Type:</label>
                    <label class="col-lg-9 control-label"><?php echo $log->prop('error_type');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-3 control-label text-right">Title:</label>
                    <label class="col-lg-9 control-label"><?php echo $log->prop('error_title');?></label>
                </div>
                <div class="input-group row">
                    <label class="col-lg-3 control-label text-right">Detail:</label>
                    <label class="col-lg-9 control-label"><?php echo $log->prop('error_message');?></label>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
