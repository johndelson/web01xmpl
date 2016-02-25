<?PHP
//error_reporting(E_ALL);
Constants::$V['widgets'] = array();



//$game->db->debug=1;

// FIX URL 
$url = Constants::$V['pageURL'];
$url_add = ''; 
$filter = '';



// category
if (@!$_GET['category']) $_GET['category'] = 'all';

if ($categories[$_GET['category']]) {
	if ($_GET['category'] != 'all')
		$filter .= ' and category = '.$_GET['category'];
}

// order
$order_by = array(
	'add' => array('Date Added',' order by timestamp desc'),
	'stock' => array('Stock',' order by stock desc'),
	'rating' => array('Rating',' order by rate desc'),
	'name' => array('Name',' order by title asc'),
);
if (!@$_GET['order'] && !@$order_by[$_GET['order']]) {
	$_GET['order'] = 'add';
}
$filter .= $order_by[$_GET['order']][1];


//get categories
//$game->db->debug=1;

//get items
$rs = $game->db->Execute('select * from item_shop where server_id = ? '.$filter,$sid);
if ($rs) {
	foreach( $rs->GetRows() as $rows => $r ) {	
		$items[$r['id']] = $r;		
	}
}


$_top_items = array();
$_new_items = array();





//print_r($items);
?>
<div class="shopBar">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa  fa-shopping-cart"></i> Webshop</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
       
       
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Category <span class="caret"></span></a>
			  <ul class="dropdown-menu">
			
				<?PHP
			
				
				foreach($categories as $cc => $c) {
					$class = @$_GET['category'] == $c['id'] ? 'class="active"' : '';
					echo '<li '.$class.'><a href="'.$url.'&category='.$c['id'].'&order='.$_GET['order'].'">
					<small class="badge pull-right bg-green">'.$c['cnt'].'</small>'.$c['title'].' </a></li>';
				}
				
				?>
				</ul>
			</li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Order <span class="caret"></span></a>
			  <ul class="dropdown-menu">
			  <?PHP 
			  if (@$_GET['category']) $url = $url .'?category='.$_GET['category'];
   			  foreach($order_by as $cc => $c) {
					$class = @$_GET['order'] == $c ? 'class="active"' : '';
					echo '<li '.$class.'><a href="'.$url.'&order='.$cc.'&category='.$_GET['category'].'">'.$c[0].'</a></li>';
				}
			  
			  ?>
			
			  </ul>
			</li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" id="shopSearch" placeholder="Search">
		   <button class="btn " id="shopSearchSubmit"><i class="fa  fa-search"></i></button>
        </div>
     
      </form>
      <ul class="nav navbar-nav navbar-right">
       	<li class="shopToggle" data-target="#shopContent .shopBoxOut" >

		 <div class="btn-group" data-toggle="buttons">
		  <label class="btn" data-original-title="Slow Large list" data-toggle="tooltip" data-placement="top" >
			<input type="radio" name="shopColumn" id="option1" value="col-sm-12" autocomplete="off"  ><i class="fa-th-list fa"></i>
		  </label>
		  <label class="btn " data-original-title="2 Row list" data-toggle="tooltip" data-placement="top">
			<input type="radio" name="shopColumn" id="option2" value="col-sm-6" autocomplete="off"   ><i class="fa-th-large fa"></i>
		  </label>
		  <label class="btn active" data-original-title="3 Row list" data-toggle="tooltip" data-placement="top">
			<input type="radio" name="shopColumn" id="option3" value="col-sm-4" autocomplete="off" checked ><i class="fa-th fa"></i>
		  </label>
		
		</div>
		</li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	

</div>
<div class="col-md-12">
<div class="callout callout-danger">
		
			<b>Filters:</b> &nbsp; 
			Category (<i><?PHP echo $categories[$_GET['category']]['title']; ?></i>),
			Order by (<i><?PHP echo $order_by[$_GET['order']][0]; ?></i>)
			<br/>
			<b>Found:</b> &nbsp; <i><?PHP echo count($items); ?></i> Items found...
</div>
 
</div>
<div class="row" id="shopContent">
<?PHP
if (count($items) > 0) {
	foreach($items as $ii => $i) {
		echo '<div class="col-sm-4 shopBoxOut">';
		
			
		echo '<div class="shopBox" data-original-title="'.$i['description'].'" data-toggle="tooltip" >';
			echo '<div class="shopBuy">';
				
			
			echo '<div class="shopPrice">
							'.number_format($i['price']).'
							<div>Cash</div>
				  </div>';
			echo '<a href="'.Constants::$V['pageURL'].'?action=buy&item='.$i['id'].'#'.$i['title'].'">
				<button  class="btn btn-sm btn-primary">
					<i class="fa fa-shopping-cart"></i> Buy!</button></a>';	  
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
				
				
				echo '<div><div class="label">Date Added:</div>'.date('d-m-Y',strtotime($i['timestamp'])).'</div>';
				echo '<div><div class="label">Category:</div>'.$categories[$i['category']]['title'].'</div>';
				echo '<div><div class="label">Stocks:</div>'.$i['stock'].' / '.$i['limit'].'</div>';
				echo '<div class="shopTags">'.do_tags($i['tag']).'</div>';
				echo '<div class="shopDescription hidden">'.$i['description'].'</div>';
			echo '</div>';
			
			echo '<div class="shopBuy2">';
				
			
			echo '<div class="shopPrice2">
							<b>'.number_format($i['price']).'</b> Cash
				  </div>';
			echo '<a href="'.Constants::$V['pageURL'].'?action=buy&item='.$i['id'].'#'.$i['title'].'">
				<button  class="btn btn-sm btn-primary">
					<i class="fa fa-shopping-cart"></i> Buy!</button></a>';	  
			echo '</div>';
				
		echo '</div></div>';
			
		
		echo '</div>';
		
	} 
} else 
	echo 'No Items Found for this Server';

?>
<div class="clear"></div>
</div>

<script>
$(document).ready(function(){
	
	$('.shopToggle input[type="radio"]').change(function(){
		var t = $(this);
		var tr = $('.shopToggle').data('target');
		  $(tr).removeClass('col-sm-6').removeClass('col-sm-12').removeClass('col-sm-4');
		  $(tr).addClass(t.attr('value'));
	});
	 $('#shopSearch').keyup(function () {

	  var rex = new RegExp($(this).val(), 'i');
	  $('.shopBoxOut').hide();
	  $('.shopBoxOut').filter(function () {
		return rex.test($(this).text());
	  }).show();

	})
});
</script>
