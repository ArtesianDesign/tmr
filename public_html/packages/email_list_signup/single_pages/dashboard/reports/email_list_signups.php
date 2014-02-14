<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<h1><span>Email List Signups</span></h1>

<div class="ccm-dashboard-inner">
	<table border="1" cellpadding="5">
		<tr>
			<th>email</th>
			<th>IP Address</th>
			<th>Created</th>
			<th>Confirmed</th>
		</tr>

		<?php  foreach ($signups as $signup): ?>
		<tr>
			<td><?php  echo htmlentities($signup->email); ?></td>
			<td><?php  echo $signup->ip; ?></td>
			<td><?php  echo $signup->created; ?></td>
			<td><?php  echo $signup->confirmed; ?></td>
		</tr>
		<?php  endforeach; ?>
	</table>

	<div style="padding-top: 10px;">
		<form method="post" action="<?php  echo $this->action('download_signups'); ?>">
			<?php  echo $form->submit('download', 'Download List (.csv)'); ?>
		</form>
	</div>
</div>
