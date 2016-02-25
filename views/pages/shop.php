<?PHP
$items = array();


//get categories
$categories = array('all' => array('id'=>'all','title'=>'All Categories'));
$rs = $game->db->Execute('select *,(select count(*) from item_shop where category = a.id) as cnt  from item_shop_category a where server_id = ? order by title',$sid);
if ($rs) {
	foreach( $rs->GetRows() as $rows => $r ) {			
		$categories[$r['id']] = $r;
	}
}
switch(@$_GET['action']) {
		case 'main':
		default:
			include('shop/main.php');
		break;
		case 'buy':
			include('shop/buy.php');
		break;
		
}


function do_tags($tags) {
	$r = '';
	if (strlen($tags) > 3) {
		$tg = explode(',',$tags);
		foreach($tg as $tt => $t) {
			$r .= '<a href="#'.$t.'">'.$t.'</a>';
		}
		
		return $r;
	} //else return '<strike>No Tags Added</strike>';
	
	
}
?>