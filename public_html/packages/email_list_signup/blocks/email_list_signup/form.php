<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<style>
#email_list_signup_form input {
	width: 500px;
}
#email_list_signup_form td.field {
	padding-left: 5px;
}
#email_list_signup_form select {
	margin-left: 10px;
}
#email_list_signup_form #msgHelp td {
	padding: 5px 0 0 15px;
}
</style>

<table id="email_list_signup_form" border="0" cellpadding="0" cellspacing="0"><tr>
	<td align="right"><?php  echo $form->label('labelText', 'Form Label:'); ?></td>
	<td align="left" class="field"><?php  echo $form->text('labelText', $labelText); ?></td>
</tr><tr>
	<td align="right"><?php  echo $form->label('inFieldText', 'In-Field Label:'); ?></td>
	<td align="left" class="field"><?php  echo $form->text('inFieldText', $inFieldText); ?></td>
</tr><tr>
	<td align="right"><?php  echo $form->label('submitButtonText', 'Submit Button Text:'); ?></td>
	<td align="left" class="field"><?php  echo $form->text('submitButtonText', $submitButtonText); ?></td>
</tr><tr>
	<td align="right"><?php  echo $form->label('submitErrorHeaderMsg', 'Submit Error Heading:'); ?></td>
	<td align="left" class="field"><?php  echo $form->text('submitErrorHeaderMsg', $submitErrorHeaderMsg); ?></td>
</tr><tr>
	<td align="right"><?php  echo $form->label('submitSuccessMsg', 'Submit Success Message:'); ?></td>
	<td align="left" class="field"><?php  echo $form->text('submitSuccessMsg', $submitSuccessMsg); ?></td>
</tr><tr>
	<td align="right"><?php  echo $form->label('displayMsgInBlock', 'Display Messages:'); ?></td>
	<td align="left" class="field">
		<?php 
		$options = array(
			1 => t("Automatically (in the block's area)"),
			0 => t("Manually (elsewhere on the page)"),
		);
		echo $form->select("displayMsgInBlock", $options, $displayMsgInBlock);
		?>
	</td>
	</tr><tr id="msgHelp" style="display:none;"><td>&nbsp;</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0"><tr>
			<td align="right" valign="top" style="padding: 0;"><?php  echo t('NOTE:'); ?>&nbsp;</td>
			<td align="left" valign="top" style="padding: 0;"><?php  echo t("To display messages elsewhere on the page, your theme templates must have<br />the following line of code (in the place you want messages displayed):"); ?></td>
		</tr></table>
		<pre>&lt;?php Loader::packageElement('page_messages', 'email_list_signup'); ?&gt;</pre>
		<script type="text/javascript">
			var refreshMsgHelpDisplay = function() {
				var displayMsgInBlock = ($('#displayMsgInBlock').val() !== '0');
				$('#msgHelp').toggle(!displayMsgInBlock);
			}
		
			$(document).ready(function() {
				$('#displayMsgInBlock').change(refreshMsgHelpDisplay);
				refreshMsgHelpDisplay();
			});
		</script>
	</td>
</tr><tr>
	<td align="right"><?php  echo $form->label('confirmationEmailFrom', 'Confirmation Email FROM Address:'); ?></td>
	<td align="left" class="field"><?php  echo $form->text('confirmationEmailFrom', $confirmationEmailFrom); ?></td>
</tr><tr>
	<td align="right"><?php  echo $form->label('confirmationEmailSubject', 'Confirmation Email SUBJECT:'); ?></td>
	<td align="left" class="field"><?php  echo $form->text('confirmationEmailSubject', $confirmationEmailSubject); ?></td>
</tr><tr>
	<td align="right"><?php  echo $form->label('confirmationSuccessMsg', 'Confirmation Success Message:'); ?></td>
	<td align="left" class="field"><?php  echo $form->text('confirmationSuccessMsg', $confirmationSuccessMsg); ?></td>
</tr></table>

<br /><br />