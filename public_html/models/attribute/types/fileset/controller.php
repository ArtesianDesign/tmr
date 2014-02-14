<?php  
defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('attribute/types/default/controller');

class FilesetAttributeTypeController extends DefaultAttributeTypeController  {

	public function form() {

		Loader::model('file_set');
		$sets = FileSet::getMySets();
		// Loader::model('file_list');

		// foreach ($sets as $i => $set) {
		// 	$fileList = new FileList();
		// 	$fileList->filterBySet($set);
		// 	$files = $fileList->get(1000);
		// 	$sets[$i]->count = count($files);
		// }
		$this->set('fileSets', $sets);
		$this->set('name', $this->field('value'));

		if (is_object($this->attributeValue)) {
			$this->set('selected', $this->getAttributeValue()->getValue());
		} else {
			$this->set('selected', 0);
		}
	}

}