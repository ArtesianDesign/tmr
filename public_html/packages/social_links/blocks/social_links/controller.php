<?php defined('C5_EXECUTE') or die(_('Access Denied.'));

	/**
	 * Block to display the Social Links added through the dashboard
	 * @author Andrew Householder for Artesian Design
	 */

	class SocialLinksBlockController extends BlockController {
		
		protected $btTable = 'btSocialLinks';
		protected $btInterfaceWidth = '350';
		protected $btInterfaceHeight = '300';
		protected $btCacheBlockRecord = true;
		protected $btCacheBlockOutput = true;
		protected $btCacheBlockOutputOnPost = true;
		protected $btCacheBlockOutputForRegisteredUsers = false;
		protected $btCacheBlockOutputLifetime = 300;
		protected $btWrapperClass = 'ccm-ui';
		public $showActive = false;

		public function getBlockTypeDescription() {
			return t('A block to display your social links.');
		}
		
		public function getBlockTypeName() {
			return t('Social Links');
		}

		public function on_start(){
			Loader::model('social_link', 'social_links');
		}

		public function add(){
			$this->configure();
		}		
		
		public function edit(){
			$this->configure();
		}		
		
		public function configure(){
			$this->set('allLinks', $this->loadAllLinks());
			$this->set('links', $this->getLinks());
		}

		public function getLinks(){
			if ($this->showActive) {
				$links = SocialLink::getActive();
			} else {
				$links = array();
				if ($this->links) {
					$linkIDs = json_decode($this->links);
					foreach ($linkIDs as $lID) {
						$links[] = SocialLink::getByID($lID);
					}
				}
			}
			return $links;
		}

		public function view(){
			$this->set('links', $this->getLinks());
		}

		public function loadAllLinks(){
			return SocialLink::getActive();
		}

		public function save($data){
			$data['links'] = json_encode(array_values(array_filter($data['lID'])));
			parent::save($data);
		}

	}
	
?>