<?php defined('C5_EXECUTE') or die(_('Access Denied.')); ?>
<h1><?php echo t('Share Your Story'); ?></h1>
<?php
$si = new Area('Share Information');
$si->display($c);
?>
<?php if (isset($error)) { $error->output(); } ?>
<?php if (!$success) { ?>
<form id="share-story-form" action="<?php echo $this->action('submit'); ?>" method="POST" enctype="multipart/form-data">
	<div class="row">
		<div class="twelve columns">

			<fieldset>

				<legend><?php echo t('Your Information'); ?></legend>

				<label for="name"><?php echo t('Name'); ?></label>
				<input type="text" name="name" value="<?php echo $_REQUEST['name']; ?>" placeholder="Your name" />

				<label for="email"><?php echo t('E-mail Address'); ?></label>
				<input type="email" name="email" value="<?php echo $_REQUEST['email']; ?>" placeholder="Your e-mail address" />

			</fieldset>

			<fieldset>

				<legend><?php echo t('Photograph (optional)'); ?></legend>

				<label>
					<input id="has-rights" type="checkbox" name="rights" value="Yes" <?php if ($_REQUEST['rights']) { ?>checked="checked"<?php } ?> />
					<?php echo t('I certify that I own the photo or have the right to permit Totally Mount Rubidoux to use and publish this image.'); ?>
				</label>

				<div id="upload-thumbnail">
					<?php if ($preview_thumbnail) { ?>
					<div class="three columns">
						<a class="th" href="#">
							<img src="<?php echo ASSETS_URL_IMAGES; ?>/spacer.gif" />
						</a>
						<span class="p">Thumbnail</span>
					</div>
					<div class="nine columns">
					<?php } ?>

					<label for="caption"><?php echo t('Caption'); ?></label>
					<input type="text" name="caption" value="<?php echo $_REQUEST['caption']; ?>" placeholder="Photo caption" />

					<label for="image"><?php echo t('Image File'); ?></label>
					<input type="file" name="image" placeholder="Attach a photograph" />

					<?php if ($preview_thumbnail) { ?>
					</div>
					<?php } ?>
				</div>

			</fieldset>

			<fieldset>

				<legend><?php echo t('Your Story'); ?></legend>

				<label for="title"><?php echo t('Title'); ?></label>
				<input type="text" name="title" value="<?php echo $_REQUEST['title']; ?>" placeholder="Story title" />

				<label for="story"><?php echo t('Story'); ?></label>
				<textarea maxlength="300" name="story" placeholder="Type or paste your story here" rows="15" id="story"><?php echo $_REQUEST['story']; ?></textarea>

			</fieldset>

			<button type="submit" class="button right"><?php echo t('Submit Story'); ?></button>
			
			<div class="clearfix"></div>
			<hr/>
			<div class="clearfix"></div>
			<?php
    	$ma = new Area('Main');
    	$ma->display($c);
    	?>

		</div>
	</div>
</form>
<script type="text/javascript">
maxLength(document.getElementById("story"));
</script>
<?php } ?>
<?php if ($success || $c->isEditMode()) { ?>
<div class="panel">
	<?php
	$m = new Area('Thank You Message');
	$m->display($c);
	?>
</div>
<?php } ?>