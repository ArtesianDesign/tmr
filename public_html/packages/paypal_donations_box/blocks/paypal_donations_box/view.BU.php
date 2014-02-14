<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<style>
	.block-paypal-donations { text-align:center;}
	.block-paypal-donations div { margin-bottom:8px;}
	.block-paypal-donations label { display: inline;}
</style>
<div class="block-paypal-donations">
  <form action="<?php  echo $controller->paypal_url?>" method="post">
    <?php  echo $controller->getTitle()?>
    <input type="hidden" name="business" value="<?php  echo $controller->paypal_user?>">
    <input type="hidden" name="cmd" value="_donations">
    <?php  echo  $controller->getItemNameField() ?>
    <?php  echo  $controller->getItemNumberField() ?>
    <input type="hidden" name="currency_code" value="<?php  echo $controller->currency_code?>">
    <?php  echo $controller->getReturnUrlField()?>
    <!-- Display the payment button. -->
    <?php  echo $controller->getAmountField(); ?>
    <div>
	  <?php  echo $controller->getSubmitButton(); ?>
    </div>
  </form>
</div>