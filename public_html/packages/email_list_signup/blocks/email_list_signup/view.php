<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<div class="email_list_signup_container">
	<?php  if (isset($emailListSignupError)): ?>
		<div class="email_list_signup_error_inblock alert-box alert">
			<?php  echo $emailListSignupError; ?>
		</div>
	<?php  endif; ?>

	<?php  if (isset($emailListSignupSuccess)): ?>
		<div class="email_list_signup_success_inblock alert-box success">
			<?php  echo $emailListSignupSuccess; ?>
		</div>
	<?php  endif; ?>

	<form method="post" action="<?php  echo $this->action('submit_form'); ?>">
		<?php  echo $form->label('email', $labelFieldText); ?>
		<?php  echo $form->text('email', array('title' => $inFieldText)); ?>
		<button class="button" type="submit"><?php echo $submitButtonText; ?></button>
	</form>
</div>