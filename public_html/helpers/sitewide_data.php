<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Sitewide Data helper
 * Used to gather the data for a pages around the site
 */
class SitewideDataHelper {

	static $globalImageAttribute = array('page_thumbnail');
	protected $priorityAttribs = array();

	function setPriorityAttribs($attributes) {
		$this->priorityAttribs = (is_array($attributes)) ? $attributes : array($attributes);
	}

	function getPlaceholderFile() {

		// we get the stack for the placeholder image
		$phStack = Stack::getByName('Placeholder Image');
		if ($phStack instanceof Stack) {
			$image = false;
			// and then we iterate through the blocks and get the first image block's 
			// image this allows for a crude sort of "versioning". they can have multiple 
			// images in the stack, but whichever is first takes priority
			foreach ($phStack->getBlocks(STACKS_AREA_NAME) as $block) {
				if (!$image && $block->btHandle == 'image') {
					$image = $block->getController()->getFileObject();
				}
			}
		}

		// if after all that if we STILL don't have an image, resort to getting one by ID
		$image = ($image) ? $image : File::getByID(7);
		$image->isPlaceholder = true; // quick lil property so we can tell on the views if we're being served a ph
		return $image;
	}

	function getPageThumbnail($page, $type = 'project', $priorityAttribs = array()) {

		// if the page is a redirected page, get the thumb from the target
		if ($page->getAttribute('page_redirect')) {
			Loader::model('master_redirect','master_redirect');
			$page = ($npage = MasterRedirect::getTargetPage($page)) ? $npage : $page;
		}

		if (!$img = self::scrapePageForThumbnail($page, $type, $priorityAttribs)) {
			$pl = new PageList();
			$pl->filterByParentID($page->getCollectionID());
			$pl->sortByDisplayOrder();
			$pl->sortBy('is_featured','desc');

			foreach ($pl->get() as $page) {
				if (!$img) {
					$img = self::scrapePageForThumbnail($page, $type);
				}
			}

		}

		$img = ($img instanceof File) ? $img : SitewideDataHelper::getPlaceholderFile();
		return $img;

	}

	/**
	 * This function scrapes a given page for an image of some sort to represent
	 * it as a thumbnail. Order of priority is
	 * 1. Priority Attributes
	 * 2. "page_thumbnail" attribute (image_file)
	 * 3. "gallery" attribute (fileset)
	 * 4. Parse through the "Banner" area to find an image, slideshow, or content block.
	 * @param  Page $page 	
	 * @param  string $type variable to search different attribute "types" (grouped by prefix)
	 * @param  array  $priorityAttribs array of AttributeTypeHandles to skim first
	 * @return File $img
	 */
	function scrapePageForThumbnail($page, $type = 'project') {
		$img = false;

		// we take into account the priority attributes passed here
		if (count($this->priorityAttribs)) {
			foreach ($this->priorityAttribs as $akHandle) {
				if (!$img) {
					$img = self::getImageFromAttribute($page, $akHandle);
				}
			}
		}

		// we fall back to normal methods
		if (!$img) {
			$typeHandle = strtolower($type);
			if (!$img = self::getImageFromAttribute($page, 'page_thumbnail')) {
				if ($files = self::getPageImages($page, 'project', 1, $this->priorityAttribs)) {
					$img = $files[0];
				}
				if (!$img) {
					$banner = new Area('Banner');
					$blocks = $banner->getAreaBlocksArray($page);
					if (count($blocks)) {
						foreach ($blocks as $b) {
							$btHandle = $b->getBlockTypeHandle();
							if (!$img) {
								switch($btHandle) {
									case('image'):
										$img = $b->getInstance()->getFileObject();
										break;
									case('slideshow'):
										$ss = $b->getInstance();
										$ss->loadImages();
										$img = $ss->images[0];
										break;
									case('content'):
										$content = $b->getInstance()->content;
										if (preg_match('/{CCM:FID_([0-9]+)}/i', $content, $ccmTag)) {
											$img = File::getByID($ccmTag[1]);
										}
										break;
									default:
									// nada
								}
							}
						}
					}
				}
			}
		}
	
		return $img;

	}

	/**
	 * Function to gather some sort of summary data from a page. We check following locations in order
	 * 1. Meta Description (page attribute)
	 * 2. Description
	 * 3. Actual page content via the "Content" block in a given area (defaults to "Main")
	 * @param  Page $page 	page object to search
	 * @param  int $truncate Truncate summary by n chars.
	 * @param  string $area Area handle to search for content
	 * @return string       page summary
	 */
	function scrapePageForSummary($page, $truncate = 0, $area = 'Main'){
		$summary = '';
		if ($page instanceof Page && !$page->error) {
			if ($summary = $page->getAttribute('meta_description')) {
				// no code needed
			} elseif ($summary = $page->getCollectionDescription()) {
				// no code needed
			} else {
				// last ditch effort. we are going to try to get some content from the 
				// first "Content" block in the given area (Defaults to "Main")
				$m = new Area($area);
				$blocks = $m->getAreaBlocksArray($page);
				if (count($blocks)) {
					foreach ($blocks as $b) {
						if (!$summary && $b->getBlockTypeHandle() == 'content') {
							$html = $b->getInstance()->getContent();
							$doc = new DOMDocument();
							$doc->loadHTML($html);
							$paragraphs = $doc->getElementsByTagName('p');
							if ($firstp = $paragraphs->item(0)) {
								$summary = strip_tags($firstp->nodeValue);
							}
						}
					}
				}
			}
		}
		return ($truncate) ? Loader::helper('text')->shortenTextWord($summary, $truncate) : $summary;
	}

	function getImageFromFileset($fsID, $order = 'display'){
		// can pass a fileset object or fileset id
		$fs = ($fsID instanceof FileSet) ? $fs = $fsID : FileSet::getByID($fsID);
		$fl = new FileList();
		$fl->filterBySet($fs);
		
		switch ($order) {
			case('random'):
				$files = $fl->get();
				$file = $files[array_rand($files)];
				break;
			default:
				$fl->sortByFileSetDisplayOrder();
				$files->$fl->get(1);
				$file = $files[0];
		}
		return $file;
	}

	function getPageImages($page, $type = 'project', $qty = null, $priorityAttribs = array()) {

		$files = false;
		$fl = new FileList();

		if ($fsID = $page->getAttribute('gallery')) {
			$fl->filterBySet(FileSet::getByID($fsID));
		} else if ($fsID = $page->getAttribute($type . '_files')) {
			$pfs = FileSet::getByID($fsID);
			$ifs = FileSet::getByName(ucwords($type) . ' Images');
			$fl->filterBySet($pfs);
			$fl->filterBySet($ifs);
		}
		
		if ($fsID) {
			$fl->sortByFileSetDisplayOrder();
			$files = $fl->get($qty);
		}

		return $files;

	}

	function getImageFromAttribute($page, $akHandle) {

		$img = false;
		$ak = CollectionAttributeKey::getByHandle($akHandle);
		if (is_object($ak)) {
			if ($val = $page->getAttribute($akHandle)) {
				$atHandle = $ak->getAttributeType()->getAttributeTypeHandle();
				switch ($atHandle) {
					case('image_file'):
						$img = $val;
						break;
					case('fileset'):
						$fl = new FileList();
						$fl->sortByFileSetDisplayOrder();
						$fl->filterBySet(FileSet::getByID($val));
						$files = $fl->get(1);
						$img = $files[0];
						break;
					default:
				}
				$img->source = $akHandle;
			}
		}
		return $img;

	}

	function recursiveAttributeSearch($page, $akHandle){
		$ak = CollectionAttributeKey::getByHandle($akHandle);
		if (is_object($ak)) {
			$result = new stdClass();
			$result->value = false;
			$result->page = $page;

			$ancestors = Loader::helper('navigation', 'california_baptist')->getTrailToCollection($page);
			array_unshift($ancestors, $page);
			foreach ($ancestors as $ancestor) {
				if (!$result->value){
					$result->value = $ancestor->getAttribute($akHandle);
					if ($result->value) { $result->page = $ancestor; }
				}
			}
			return $result;
		}
	}
}