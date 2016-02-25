<div class="PaymentPage">
<?PHP
/*
require_once('lib/PAYWALL/paymentwall.php');
Paymentwall_Base::setApiType(Paymentwall_Base::API_GOODS);
Paymentwall_Base::setAppKey('1951366d51e78424ad207d45d65889ef'); // available inside of your merchant account
Paymentwall_Base::setSecretKey('d0f015fe02c5db90db3c039c0da81401'); // available inside of your merchant account
$widget = new Paymentwall_Widget(
  $uid,                                  // id of the end-user who's making the payment
  'p10_1',                                       // widget code, e.g. p1; can be picked inside of your merchant account

  array('email' => 'user@hostname.com')         // additional parameters
);
echo $widget->getHtmlCode();
<div class="col-xs-12 text-center">
<iframe src="<?PHP echo $api; ?>" width="750" height="500" frameborder="0"></iframe>
</div>
$api = 'https://api.paymentwall.com/api/ps/?key=1951366d51e78424ad207d45d65889ef&uid='.$uid.'&widget=p10_1';

*/


if (!is_array($Payment)) {
	echo '<div class="alert alert-danger">No Payment settings for this server.</div></div>';
	return false;
} 

$PaymentSetup = array(
	'Paypal' => array(
			'<span class="label label-info">P</span>'
			
	),
	'Zaypay' => array(
			'<span class="label label-primary">Z</span>'
			
	),
	'Western Union/Others' => array(
		'',
	),

);

?>
<div class="col-sm-12 darkTab">
<ul class="nav nav-tabs">
<?PHP
$tab = 'paypal';
if (@$_GET['tab']) $tab = $_GET['tab'];
$cnt = 0;
foreach($TopNav['Payment'][3] as $pp => $p) {	
	$cl = ($pp == $tab) ? 'active': '';
	echo '<li class="'.$pp.' '.$cl.'"><a href="#tab_'.$cnt.'" data-toggle="tab">
		<i class="fa '.$p[0].'"></i> '.$p[1].'</a></li>';
	$cnt++;
}

?>

</ul>
<div class="tab-content bg-trans panel-dashboard">
<?PHP
$game= Constants::$SERVER[$sid];
$web = $game->decodeThis('Website','Settings');


$cnt = 0;
foreach($TopNav['Payment'][3] as $pp => $p) {	
	$cl = ($pp == $tab) ? 'active': '';
	echo '<div class="tab-pane fade in '.$cl.'" id="tab_'.$cnt.'">';
	switch($pp) {
		default:
			echo $Payment[$p[1]];
		break;
		case 'zaypay':
		?>
		<p><span class="label label-info">Note</span> Sms Payment System Info: After  Finish the payment you must wait and complete the Questionnaire and there in the place 
		were will be asking for you name Please Enter your Account login ID (your account name) 
		"Not your Real name or other !!!or you will never receive any coins because the system no idea were to send them !!!</p>
		
		<iframe class="zapay" src="http://www.zaypay.com//en-GB/pay/<?PHP echo $Payment[$p[1]]; ?>/payments/new" scrolling="no"></iframe>
		<?PHP
		break;
		
		case 'paypal':

		$Packages= array(
				// name       ( name , price$ , Ran cash, description
                                //'Pack0' => array('name'=>'50 '.$_config['cash_name'],'price'=>'50',$_config['cash_name']=>'50','Description'=>'+shit nothing'),
				'Pack1' => array('name'=>700 ,'price'=>'5'),
				'Pack2' => array('name'=>1700 ,'price'=>'10'),
				'Pack3' => array('name'=>3500 ,'price'=>'20'),
				'Pack4' => array('name'=>9150 ,'price'=>'50'),
				'Pack5' => array('name'=>20250 ,'price'=>'100'),
			    'Pack6' => array('name'=>42000 ,'price'=>'200'),
				'Pack7' => array('name'=>106999 ,'price'=>'500'),
				
				);
		?>
		<h4>
		Pick a Paypal Package
		</h4>
		<div >
		<table class="table table-striped table-bordered">
		<thead>
		<tr>
		<th>Promo</th>
		<th>Amount</th>
		<th>Rewards</th>
		<th></th>
		</tr>
		</thead>
		<tbody>
		<?PHP 
		$head = '<form method="post" target="_blank" action="https://www.paypal.com/cgi-bin/webscr">
		<input type="hidden" name="cmd" value="_donations">
		<input name="business" value="'.$Payment[$p[1]].'" type="hidden">
		<input name="lc" value="GB" type="hidden">

		<input name="no_shipping" value="1" type="hidden">
		<input name="rm" value="1" type="hidden">
		<input name="currency_code" value="USD" type="hidden">
		<input name="bn" value="PP-BuyNowBF:btn_buynowCC_LG_global.gif:NonHosted" type="hidden">		
		<input value="'.$uid.'" id="item_name" name="item_name" type="hidden">
		<input value="USD" name="currency_code" type="hidden">';
		
			foreach($game->decodeDefinesArray('Paypal Loadup') as $pack => $p) {
				echo '<tr><td colspan="4"><span class="label label-primary">Pack</span> '.$p['DESCRIPTION'].'</td></tr><tr>';
				echo '<td><b>'.$pack.'</b></td>';
				echo '<td>'.$p['USD'].'.<small>00</small> <b class="label label-danger">USD</b></td>';
				echo '<td>'.number_format($p['CASH']).'.<small>00</small> <b class="label label-success">'.$label['cash'].'</b></td>';
			
				echo '<td>';
			
				echo $head;
				echo '<input name="cn" value="Load UP! Account: '.$Account['data']['USER_ID'].' Account NO: '.$uid.' Cash: '.number_format($p['CASH']).' " type="hidden">
					<input type="hidden" name="amount" value="'.$p['USD'].'.00">
					<input name="on0" value="Server" type="hidden">
					<input name="os0" value="'.$web['Server Name'].'" type="hidden">
					<input name="on1" value="Account" type="hidden">
					<input name="os1" value="'.$Account['data']['USER_ID'].'" type="hidden">
					
					<input name="on2" value="Account No" type="hidden">
					<input name="os2" value="'.$uid.'" type="hidden">
					<input name="on3" value="Cash Load" type="hidden">
					<input name="os3" value="'.$p['CASH'].'" type="hidden">
					
					';
				
				echo '<input type="image"  src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="PayPal - The safer, easier way to pay online!" />	';
				echo '</form>';
			
			echo '</td></tr>';
			}

		
		?>
		</tbody>
		</table>
		</div>
		

		
		<?PHP
		
		break;
	}

	
	echo '</div>';
	$cnt++;
}
?>
 
</div>

</div>
</div>



