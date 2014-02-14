<?php defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @author Andrew Householder <andrew@artesiandesigninc.com>
 * @copyright Copyright © Andrew Householder / Artesian Design 2012
 */
$dc = Page::getCurrentPage();
$fh = Loader::helper('form');
$ih = Loader::helper('concrete/interface');
$dh = Loader::helper('concrete/dashboard');
?>
<?php echo $dh->getDashboardPaneHeaderWrapper(t('Social Links'), t('Manage your social networking links.'), false, false); ?>

	<div class="ccm-dashboard-inner">
		<div class="links">
			<?php if (is_array($links)) { ?>
			<form id="links-table" action="<?php echo $this->url(Page::getCurrentPage()->getCollectionPath(), 'update_links'); ?>" method="POST">
				<fieldset>
					<legend><?php echo t('Current Links'); ?></legend>
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<th>&nbsp;</th>
							<th><?php echo t('Active'); ?></th>
							<th><?php echo t('Name'); ?></th>
							<th><?php echo t('Link'); ?></th>
							<th>&nbsp;</th>
						</thead>
						<tbody>
						<?php foreach ($links as $count => $link) { ?>
							<tr>
								<td class="sort">
									<i class="icon-resize-vertical"></i>
									<?php echo $fh->hidden('link['.$count.'][position]', $count); ?>
								</td>
								<td class="active"><?php echo $fh->checkbox('link['.$count.'][active]', 1, $link['active']); ?></td>
								<td class="name"><?php echo $fh->text('link['.$count.'][name]', $link['name'], array('style'=>'width:95%')); ?></td>
								<td class="url"><?php echo $fh->text('link['.$count.'][url]', $link['url'], array('style'=>'width:95%')); ?></td>
								<td class="remove">
									<a class="close" href="<?php echo $this->url(Page::getCurrentPage()->getCollectionPath(), 'remove_link'); ?>" data-link-id="<?php echo $link['lID']; ?>">
										<span><?php echo t('x'); ?></span>
									</a>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</fieldset>
				<div class="form-actions">
					<button class="btn btn-primary" type="submit"><?php echo t('Save'); ?></button>
					<span class="result help-inline"></span>
				</div>
			</form>
			<?php } else { ?>
			<p><?php echo t('No links found.'); ?></p>
			<?php } ?>
		</div>

		<div class="add well">
			<form id="add-link" class="form-inline" action="<?php echo $this->url(Page::getCurrentPage()->getCollectionPath(), 'add_link'); ?>" method="POST">
				<fieldset>
					<legend><?php echo t('Add Link'); ?></legend>
					<input type="text" class="input-medium" placeholder="Link Name" name="name" />
					<input type="text" class="input-large" placeholder="Link URL" name="url" />
					<button class="btn btn-small" type="submit"><?php echo t('Add Link'); ?></button>
				</fieldset>
			</form>
			<div class="ccm-spacer">&nbsp;</div>
		</div>
	</div>

<?php echo $dh->getDashboardPaneFooterWrapper(false); ?>