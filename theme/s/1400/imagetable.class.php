<?PHP
require('../../../lib/CSV/parsecsv.lib.php');
include_once '../../../lib/CACHE/phpfastcache.php';

phpFastCache::setup("storage","auto");
phpFastCache::setup("path", '../../../cache/');
$cache = phpFastCache();

class imagetable {
	public $file = 'imagetable.txt';
	public $data = array();
	public $header = array();
	function __construct() {
		$this->initiate();
		
	}
	function initiate() {
		$data = __c("files")->get($this->file);
		if($data == null) {
			$csv = new parseCSV($this->file);					
			foreach($csv->data as $data => $d) {	
				$this->data[$d['type']][$d['index']] = $d;
			}		
			
			__c("files")->set($this->file,$this->data,48000);
		}
		$this->data = $data;
	}
	function get($type,$index) {
		if (!$this->data[$type][$index]) $this->initiate();
		$data = $this->data[$type][$index];
		$data['image'] = preg_replace('/UI\\\Game\\\/i','',$data['image']);
		$data['image'] = preg_replace('/\\\/i','/',$data['image']);
		$data['image'] = preg_replace('/dds/i','png',$data['image']);
		return $data;
	}

}

?>