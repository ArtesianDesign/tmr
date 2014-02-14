<?php  
class SocialLink {
		
	public function clearRecords() {
		$db = Loader::db();
		$db->query("TRUNCATE TABLE SocialLinks");
	}
	
	public function addLink($name, $url, $position = false, $active = 1) {

		$th = Loader::helper('text');
		$q['name'] = $th->unhandle($name);
		$q['handle'] = $th->sanitizeFileSystem($q['name']);
		$q['url'] = $url;
		$q['active'] = $active;
		$q['position'] = ($position) ? $position : SocialLink::getCount();

		$db = Loader::db();
		$query = "INSERT INTO SocialLinks (name, handle, url, active, position) VALUES (?, ?, ?, ?, ?)";
		return $db->query($query,array($q));
		
	}
	
	public function removeByHandle($data) {

		$th = Loader::helper('text');
		$handle = $th->handle($data);
		$db = Loader::db();
		return $db->query("DELETE FROM SocialLinks WHERE handle = ?", array($handle));
		
	}
	
	public function removeAll() {

		$db = Loader::db();
		return $db->query("TRUNCATE TABLE SocialLinks");
		
	}
	
	public function removeByID($data) {

		$db = Loader::db();
		return $db->query("DELETE FROM SocialLinks WHERE lID = ?", array(intval($data)));
	
	}
	
	public function getLink($data) {
	
		$th = Loader::helper('text');
		$handle = $th->sanitizeFileSystem($data);
		
		$db = Loader::db();
		$row = $db->GetRow("SELECT * FROM SocialLinks WHERE handle LIKE ?", array($handle));

		if (is_array($row)) {
			return $row;
		} else {
			return false;
		}
		
	}

	public function getByID($data) {
	
		$db = Loader::db();
		return $db->GetRow("SELECT * FROM SocialLinks WHERE lID = ?", array($data));

	}
	
	public function getAll(){
	
		$db = Loader::db();
		$rows = $db->getAll("SELECT * FROM SocialLinks ORDER BY position ASC");
		return $rows;

	}

	public function getActive(){

		$db = Loader::db();
		$rows = $db->getAll("SELECT * FROM SocialLinks WHERE active = 1 ORDER BY position ASC");
		return $rows;

	}

	public function getCount(){

		return count(SocialLink::getAll());

	}
		
} // end class def