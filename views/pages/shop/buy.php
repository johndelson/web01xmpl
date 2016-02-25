<?PHP

Constants::$V['widgets'] = array(
	'cash' => DashboardController::cashParse($game),
);
error_reporting(0);

?>

<?PHP 
$error = 0;
// get item
if (!@$_GET['item'] || !@ctype_digit($_GET['item'])) {
	echo '<div class="callout callout-warning">';
	echo '</h3>Warning</h3><p>ITEM NOT FOUND...</p>';	
	echo '</div>';
	$error = 1;
}
if ($error == 0) {

	//get items
	$rs = $game->db->Execute('select * from item_shop where server_id = ? and id =? ',
		array($sid,$_GET['item']));
	if ($rs) {
		foreach( $rs->GetRows() as $rows => $r ) {	
			$items[$r['id']] = $r;		
		}
	}
	
}
	$i = $items[$_GET['item']];

	$giftForm = getTemplate()->get('form/checkaccount.form.php',$i);
	Constants::$V['widgets']['gift']  = array(
		'col'=>12,
		'display'=>true,
		'title'=>'Gift This Item',
		'icon'=>'fa-gift',
		'body'=>'
				'.$giftForm.'
		
		
		
		',
	);
?>
<div class="row">
<div class="shopBuyMenu pull-right">
					
<div class="btn-group">
	<button type="button" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Buy!</button></button>
	<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a href="<?PHP echo Constants::$V['pageURL']; ?>?action=comfirm&item=<?PHP echo $i['id']; ?>&target=vault"><i class="fa fa-shopping-cart"></i> Buy and Send to Item Vault</a></li>
		<li><a href="<?PHP echo Constants::$V['pageURL']; ?>?action=comfirm&item=<?PHP echo $i['id']; ?>&target=game"><i class="fa fa-shopping-cart"></i> Buy and Send to Game Via Mail</a></li>		
		 </ul>
</div>		
&nbsp;
<div class="btn-group">
<a href="#giftItem">
	<button type="button" class="btn btn-danger"><i class="fa fa-gift"></i> Gift!</button>
</a>

</div>	

		
</div>

<a href="<?PHP echo Constants::$V['pageURL']; ?>"> 
	<button  class="btn btn-md btn-primary">
		<i class="fa fa-mail-reply"></i> Back to Webshop Main...</button>
</a>
</div><br/>
<div class="row">
<?PHP

		echo '<div class="col-sm-12 no-padding shopBoxOut">';
		
			
		echo '<div class="shopBox">';
		echo '<div class="shopBuy">';
				
			
			echo '<div class="shopPrice">
							'.number_format($i['price']).'
							<div>Cash</div>
				  </div>';
			
			echo '</div>';
			
		echo '<div class="shopBoxInner">';
		echo '<h3>'.$i['title'].'</h3>';
			echo '<div class="shopIMG pull-left">';
				$item = json_decode($i['item_data'],true);
				$img = 'No Image';
				if (strlen($i['image']) > 4) {
					if (strlen($i['image']) > 6) $i['image'] = substr($i['image'],0,7);
						$img = '<img src="http://i.imgur.com/'.$i['image'].'s.png" />';
				}
				echo $img;
			echo '</div>';
			echo '<div class="shopText">';
				
				
				echo '<div><div class="label">Date Added:</div>'.$i['timestamp'].'</div>';
				echo '<div><div class="label">Category:</div>'.$categories[$i['category']]['title'].'</div>';
				echo '<div><div class="label">Stocks:</div>'.$i['stock'].' / '.$i['limit'].'</div>';
				echo '<div class="shopTags"><div class="label">Tags:</div>'.do_tags($i['tag']).'... </div>';
				
			echo '</div>';
			
			
		echo '</div></div>';
		
		
	
	
		echo '<div class="clear"></div>
			<div class="shopDescriptionBox">
				'.$i['description'].'
			</div>';
	
		
?>

<div class="row shopBox">

<div class="shopBuyMenu  pull-right">
					
<div class="btn-group">
	<button type="button" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Buy!</button></button>
	<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a href="<?PHP echo Constants::$V['pageURL']; ?>?action=comfirm&item=<?PHP echo $i['id']; ?>&target=vault"><i class="fa fa-shopping-cart"></i> Buy and Send to Item Vault</a></li>
		<li><a href="<?PHP echo Constants::$V['pageURL']; ?>?action=comfirm&item=<?PHP echo $i['id']; ?>&target=game"><i class="fa fa-shopping-cart"></i> Buy and Send to Game Via Mail</a></li>		
		 </ul>
</div>		
&nbsp;
<div class="btn-group">
<a href="#giftItem">
	<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#GiftModal"><i class="fa fa-gift"></i> Gift!</button>
</a>

</div>	

		
</div>
</div>
	</div>
</div>

<div class="row"><br/>
<div class="callout callout-warning">
<h4>Buying Informations</h4>
		<dl class="dl-horizontal">
			<dt>VIA GAME MAIL</dt>
			<dd>You can directly send items that you bought to your game account via GAME MAIL.</dd>
			<dt>VIA ITEM VAULT</dt>
			<dd>The Item Vault is out <b>Free</b> Website storage for all your items... </dd>
			<dd>You can directly send an item to the Website Item Vault for later use.</dd>
			<dt>GIFT AN ITEM</dt>
			<dd>Sending items to your friends is easy.</dd>
			<dd>Just make sure you know his <b>Character</b> Name.</dd>
			<dd>Your Friends <b>Character</b> must be in the same Server as website item ( this items is for <b><?PHP echo strtoupper($info['Web']['Server Name']); ?></b>).</dd>
		</dl>
</div>
 
</div>


<script>
$(document).ready(function(){
	var t = $('#giftItem');
	  t.bootstrapValidator({           
		icon: {
		  valid: 'glyphicon glyphicon-ok',
		  invalid: 'glyphicon glyphicon-remove',
		  validating: 'glyphicon glyphicon-refresh'
		},
		excluded: [],
		submitHandler: function(validator, form, submitButton) {
		  //t.html('Sending data to server');	
		 
		  $.getJSON('/api/?'+form.serialize(), {
			sid: t.data('sid'),
			action: t.data('action'),
			
		  }).done(function( data ) {                                    
			$.parseJSONData(data);			            
		  });
		}				
	});
});
</script>