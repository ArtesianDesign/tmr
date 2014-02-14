<?php defined('C5_EXECUTE') or die("Access Denied.");

class PageRedirectAttributeTypeController extends AttributeTypeController  {

	protected $searchIndexFieldDefinition = 'C 255 DEFAULT 0 NULL';

	public $types = array(
		'first'    => 'First Child Page',
		'newest'   => 'Newest Child Page',
		'random'   => 'Random Child Page',
		'parent'   => 'Parent Page',
		'specific' => 'Specific Page...'
	);

	public function getValue() {
		$db = Loader::db();
		$value = $db->GetOne("select value from atPageRedirect where avID = ?", array($this->getAttributeValueID()));
		return $value;	
	}
	
	public function searchForm($list) {
		$PagecID = $this->request('value');
		$list->filterByAttribute($this->attributeKey->getAttributeKeyHandle(), $PagecID, '=');
		return $list;
	}
	
	public function search() {
		$form_selector = Loader::helper('form/page_selector');
		print $form_selector->selectPage($this->field('value'), $this->request('value'), false);
	}
	
	public function form() {
		if (is_object($this->attributeValue)) {
			$this->set('value', $this->getAttributeValue()->getValue());
		}
	}
	
	public function validateForm($p) {
		return $p['value'] != 0;
	}

	public function saveValue($value) {
		$db = Loader::db();
		$db->Replace('atPageRedirect', array('avID' => $this->getAttributeValueID(), 'value' => $value), 'avID', true);
	}
	
	public function deleteKey() {
		$db = Loader::db();
		$arr = $this->attributeKey->getAttributeValueIDList();
		foreach($arr as $id) {
			$db->Execute('delete from atPageRedirect where avID = ?', array($id));
		}
	}
	
	public function saveForm($data) {
		$db = Loader::db();
		$this->saveValue($data['value']);
	}
	
	public function deleteValue() {
		$db = Loader::db();
		$db->Execute('delete from atPageRedirect where avID = ?', array($this->getAttributeValueID()));
	}
	
}