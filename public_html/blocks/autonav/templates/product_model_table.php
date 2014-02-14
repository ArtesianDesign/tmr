<?php defined('C5_EXECUTE') or die('Access Denied.');
$pages = $controller->getNavItems();
$th = Loader::helper('text');
$ih = Loader::helper('image');
$sd = Loader::helper('sitewide_data');
$dimensions = CollectionAttributeKey::getByHandle('dimensions');
$show_thumbs = false;
$global_settings_options = array('psp','cad','specs','images');
$styles = array();
$galleries = array();
foreach ($pages as $ni) {

	$page = $ni->cObj;
	$title = $th->entities($page->getCollectionName());
	$cID = $page->getCollectionID();
	$cParentID = $page->getCollectionParentID();
	$ctHandle = $page->getCollectionTypeHandle();

	switch($ctHandle) {
	case('product_type'):
		$h = new stdClass();
		$h->thumb = ($file = $page->getAttribute('page_thumbnail')) ? $file : $sd->getPlaceholderFile();
		$h->iso = ($file = $page->getAttribute('product_isolated')) ? $file : $sd->getPlaceholderFile();
		$h->style = $title;
		$h->anchor = $th->urlify($title);
		$h->title = Page::getByID($cParentID)->getCollectionName() . ': <strong>' . $title . '</strong>';
		$h->specsheet = $page->getAttribute('brochure_pdf');
		$styles[$cID]['header'] = $h;
		break;
	case('product_model'):
		$p = new stdClass();
		$p->id = $page->getCollectionID();
		if ($show_thumbs) {
			$p->thumb = ($file = $page->getAttribute('product_isolated')) ? $file : $sd->getPlaceholderFile();
		}
		$p->model = $title;
		$p->dimensions = $page->getAttribute('dimensions');
			if (is_array($p->dimensions)) {
				if (!is_array($styles[$cParentID]['settings']['dimension_keys'])) {
					$styles[$cParentID]['settings']['dimension_keys'] = array();
				}
				foreach ($p->dimensions as $dims) {
					if (!in_array($dims['key'], $styles[$cParentID]['settings']['dimension_keys'])) {
						$styles[$cParentID]['settings']['dimension_keys'][] = $dims['key'];
					}
				}
			}
		$p->cad = $page->getAttribute('cad_file');
		$p->specs = $page->getAttribute('specs_file');
		$p->images = ($fsID = $page->getAttribute('gallery')) ? FileSet::getByID($fsID) : null;
		$p->psp = $page->getAttribute('psp_certified');

		$styles[$cParentID]['models'][] = $p;

		// here we are hooking some global settings so we can modify some of the output 
		// we check to see if there are PSP-certified products in the table and if we have images/PDFs as well.
		// if we are missing any of these things table-wide, then the columns are suppressed for brevity
		foreach ($global_settings_options as $setting) {
			$styles[$cParentID]['settings'][$setting] = ($styles[$cParentID]['settings'][$setting] || $p->{$setting});
		}
		break;
	default:
		
	}
}
?>

<?php if (count($styles) > 1) { ?>
<h3 class="left-border"><?php echo t('Available Shapes'); ?></h3>
<ul class="style-listing thumbnail-grid">
	<?php foreach ($styles as $style) { 
		$header = $style['header'];
		$iso = $ih->getThumbnail($header->iso, 178, 178, true);
		?>
	<li><a href="#<?php echo $header->anchor; ?>">
		<img class="thumb" src="<?php echo $iso->src; ?>" />
		<span><?php echo $header->style; ?></span>
	</a></li>
	<?php } ?>
</ul>
<?php } ?>

<?php foreach ($styles as $style) { 
	$header = $style['header'];
	$settings = $style['settings'];

	// start off with 2 (image, model).
	$total_columns = 2;
	// for each active setting, we increase total column count
	// for settings which are arrays, we count them.
	foreach ($settings as $setting) {
		if (is_array($setting)) {
			$total_columns += count($setting);
		} elseif ($setting) {
			$total_columns++;
		}
	} ?>
<div class="product-type-item">
	<h2>
		<a name="<?php echo $header->anchor; ?>"></a>
		<?php if ($header->thumb) { ?>
		<?php $thumb = $ih->getThumbnail($header->thumb, 20, 20); ?>
		<img class="style-thumbnail" src="<?php echo $thumb->src; ?>" />
		<?php } ?>
		<?php echo $header->title; ?>
		<?php if ($header->specsheet) { ?>
		<a href="<?php echo $header->specsheet->getDownloadURL(); ?>" class="specsheet pull-right" title="<?php $header->specsheet->getTitle(); ?>">
			<?php echo t('Download Spec Sheet'); ?>
			<i class="icon-qc icon-paper-2"></i>
		</a>
		<?php } ?>
	</h2>
	<table class="table table-striped uniform product-table" data-uniform-filter=".dimension">
		<thead>
			<tr>
				<?php if ($show_thumbs) { ?><th class="thumb" scope="col"></th><?php } ?>
				<th class="model" scope="col"><?php echo t('Model #'); ?></th>
				<?php if ($settings['psp']) { ?><th class="psp" scope="col"></th><?php } ?>
				<?php foreach ($settings['dimension_keys'] as $dim) { ?>
				<th class="dimension" scope="col"><?php echo $dim; ?></th>
				<?php } ?>
				<?php if ($settings['cad']) { ?><th class="cad" scope="col">CAD</th><?php } ?>
				<?php if ($settings['specs']) { ?><th class="specs" scope="col"><?php echo t('Specs'); ?></th><?php } ?>
				<?php if ($settings['images']) { ?><th class="images" scope="col"><?php echo t('Images'); ?></th><?php } ?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td<?php if ($settings['psp']) { ?> class="psp-info"<?php } ?> colspan="<?php echo $total_columns - 2; ?>">
					<?php if ($settings['psp']) { ?>
					<?php echo t('Planters designated with the PSP logo can be specially ordered in SRC to meet the Government K-4 L-2 Rating for Perimeter Security Protection with no connection method necessary.Interior dimensions change for PSP planters–please confirm when placing order.'); ?>
					<?php } ?>
				</td>
				<td class="back-to-top" colspan="2">
					<a href="#">
						<?php echo t('Back to Top'); ?>
					</a>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($style['models'] as $p) { ?>
			<tr>
				<?php if ($show_thumbs) { ?>
				<td class="thumb">
					<?php $img = $ih->getThumbnail($p->thumb, 9999, 40); ?>
					<img src="<?php echo $img->src; ?>" />
				</td>
				<?php } ?>

				<th class="model" scope="row"><?php echo $p->model; ?></th>

				<?php if ($settings['psp']) { ?>
				<td class="psp">
					<?php if ($p->psp) { ?>
					<i class="icon-qc icon-psp"></i>
					<?php } ?>
				</td>
				<?php } ?>

				<?php foreach ($settings['dimension_keys'] as $dk) { ?>
				<td class="dimension">
					<?php foreach ($p->dimensions as $pd) {
						if ($dk == $pd['key']) { 
							echo $pd['value'];
						}
					} ?>
				</td>
				<?php } ?>

				<?php if ($settings['cad']) { ?>
				<td class="cad">
					<?php if ($p->cad) { ?>
					<a href="<?php echo $p->cad->getDownloadURL(); ?>" title="<?php echo $p->cad->getTitle(); ?>">
						<i class="icon-qc icon-dwg"></i>
						<span class="hide-me"><?php echo $p->cad->getTitle(); ?></span>
					</a>
					<?php } ?>
				</td>
				<?php } ?>

				<?php if ($settings['specs']) { ?>
				<td class="specs">
					<?php if ($p->specs) { ?>
					<a href="<?php echo $p->specs->getDownloadURL(); ?>" title="<?php echo $p->specs->getTitle(); ?>">
						<i class="icon-qc icon-pdf"></i>
						<span class="hide-me"><?php echo $p->specs->getTitle(); ?></span>
					</a>
					<?php } ?>
				</td>
				<?php } ?>

				<?php if ($settings['images']) { ?>
				<td class="images">
					<?php
					if ($p->images) {
						$fl = new FileList();
						$fl->filterBySet($p->images);
						$files = $fl->get();
						foreach($files as $file) {
							$galleries[$p->id]['href'] = $file->getRelativePath();
							$galleries[$p->id]['title'] = $file->getTitle();
						} ?>
					<a href="#" class="simple-gallery" data-gallery-id="<?php echo $p->id; ?>" title="<?php echo $p->model . t(' Gallery'); ?>">
						<i class="icon-qc icon-gallery"></i>
						<span class="hide-me"><?php echo t('Gallery'); ?></span>
					</a>
					<?php } ?>
				</td>
				<?php } ?>

			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php } // end for each section ?>
<script>
var SimpleGallery = <?php echo json_encode($galleries); ?>;
</script>