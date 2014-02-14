<?php defined('C5_EXECUTE') or die(_('Access Denied.')); ?>

<div class="block-paypal-donations">
	<form action="<?php echo $controller->paypal_url; ?>" method="post">
		<p><?php echo $title; ?></p>
		<input type="hidden" name="business" value="<?php echo $paypal_user; ?>">
		<input type="hidden" name="cmd" value="_donations">
		<?php echo $controller->getItemNameField(); ?>
		<?php echo $controller->getItemNumberField(); ?>
		<input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">
		<?php echo $controller->getReturnUrlField(); ?>
		<!-- Display the payment button. -->
		<?php echo $controller->getAmountField(); ?>
		<div>
		<?php echo $controller->getSubmitButton(); ?>
		</div>
	</form>
</div>