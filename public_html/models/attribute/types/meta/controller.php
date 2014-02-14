<?php defined('C5_EXECUTE') or die('Access Denied.');

class MetaAttributeTypeController extends AttributeTypeController  {

	protected $searchIndexFieldDefinition = 'X NULL';

	public function getValue() {
		$db = Loader::db();
		$data = array();
		$values = $db->getAll("SELECT * FROM atMetaValues WHERE avID = ?", array($this->getAttributeValueID()));
		if (is_array($values)) {
			foreach ($values as $value) {
				$key = $this->getKeyByID($value['kID']);
				$data[$key['pos']]['key'] = $key['name'];
				$data[$key['pos']]['value'] = $value['value'];
			}
		}
		return $data;
	}

	public function getKeyByName($name) {
		$db = Loader::db();
		return $db->getRow("SELECT * FROM atMetaKeys WHERE name = ? AND avID = ?", array($name, $this->getAttributeValueID()));
	}

	public function getKeyByID($kID) {
		$db = Loader::db();
		return $db->getRow("SELECT * FROM atMetaKeys WHERE kID = ? AND avID = ?", array(intval($kID), $this->getAttributeValueID()));
	}

	public function addKey($name, $pos = 0) {
		$akID = $this->getAttributeKey()->getAttributeKeyID();
		$db = Loader::db();
		$return = $db->Execute("INSERT INTO atMetaKeys (avID, akID, name, pos) VALUES (?, ?, ?, ?)", array($this->getAttributeValueID(), $akID, $name, $pos));
		return ($return) ? $this->getKeyByID($db->Insert_ID()) : null;
	}

	public function addValue($name, $value, $pos) {
		$akID = $this->getAttributeKey()->getAttributeKeyID();
		$db = Loader::db();
		$key = ($key = $this->getKeyByName($name)) ? $key : $this->addKey($name, $pos);
		$vID = $db->Execute("INSERT INTO atMetaValues (avID, akID, kID, value) VALUES (?, ?, ?, ?)", array($this->getAttributeValueID(), $akID, $key['kID'], $value));
		return ($vID) ? $this->getValueByID($vID) : null;
	}

	public function getValueByID($vID) { 
		$db = Loader::db();
		return $db->getOne("SELECT * FROM atMetaValues WHERE avID = ? AND vID =?", array($this->getAttributeValueID(), intval($vID)));
	}

	public function getValueByKeyID($kID) { 
		$db = Loader::db();
		return $db->getOne("SELECT * FROM atMetaValues WHERE avID = ? AND kID =?", array($this->getAttributeValueID(), intval($kID)));
	}

	public function getKeys() {
		$db = Loader::db();
		return $db->getAll("SELECT * FROM atMetaKeys WHERE avID = ?", array($this->getAttributeValueID()));
	}

	public function getAllKeys() {
		$akID = $this->getAttributeKey()->getAttributeKeyID();
		$db = Loader::db();
		return $db->getAll("SELECT * FROM atMetaKeys WHERE akID = ?", array($akID));
	}

	public function getAllKeyNames() {
		$akID = $this->getAttributeKey()->getAttributeKeyID();
		$db = Loader::db();
		return $db->getCol("SELECT DISTINCT(name) FROM atMetaKeys WHERE akID = ?", array($akID));
	}

	public function form() {
		// if (is_object($this->attributeValue)) {
		// 	$value = Loader::helper('text')->entities($this->getAttributeValue()->getValue());
		// }
		$this->set('akID', $this->getAttributeValueID());
		$this->set('keys', $this->getAllKeyNames());
		$this->set('data', $this->getValue());
	}

	// public function searchForm($list) {
	// 	$db = Loader::db();
	// 	$list->filterByAttribute($this->attributeKey->getAttributeKeyHandle(), '%' . $this->request('value') . '%', 'like');
	// 	return $list;
	// }
	// 
	public function getJsonValue() {
		return json_encode($this->getValue());
	}
	
	public function getDisplayValue() {
		$data = $this->getValue();
		$html  = '<table class="table table-bordered table-striped">';
		$html .= '<thead><tr><th>' . t('Key') . '</th><th>' . t('Value') . '</th></tr></thead><tbody>';
		foreach ($data as $pos => $meta) {
			$html .= '<tr>';
			$html .= '<td>' . $meta['key'] . '</td>';
			$html .= '<td>' . html_entity_decode($meta['value']) . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		return $html;
	}
	
	// public function search() {
	// 	$f = Loader::helper('form');
	// 	echo $f->text($this->field('value'), $this->request('value'));
	// }
		
	public function saveValue($meta) {
		if (is_array($meta)) {
			$th = Loader::helper('text');
			foreach($meta as $m) {
				$this->addValue($m['key'], $m['value'], $m['pos']);
			}
		}
	}
	
	public function saveForm($data) {
		$this->saveValue($_REQUEST['meta']);
	}
	
	public function deleteKey() {
		$db = Loader::db();
		$akID = $this->getAttributeKey()->getAttributeKeyID();
		$db->Execute("DELETE FROM atMeta WHERE avID = ?", array($id));
		$db->Execute("DELETE FROM atMetaKeys WHERE avID = ?", array($id));
		$db->Execute("DELETE FROM atMetaValues WHERE avID = ?", array($id));
	}

}
