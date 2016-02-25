<div id="mainHeadings">
	<?PHP
			require('views/widgets/actg-alerts.php'); 
		
	?>

</div>


<div class="container-fluid idashboard">
<div class="row-fluid">
	<div class="fixed">  
		<div id="sidebar">
			<?PHP
				echo ApiController::widgets($sid,'sidebar',true,0);	
			?>
				   
		</div> 
	</div>
	<div class="hero-unit filler">  <!-- we have removed spanX class -->
    <div id="mainDashboard">
<!-- bar -->
<div id="mainBar">
	
		<div class="col-xs-12 no-padding">
			<div class="topSInfo">
			
			<div class="ServerTimeBox pull-right hidden-xs">
					<div 
					data-toggle="popover" 
					data-placement="left"
					data-trigger="hover" 
					title="Server Time" 
					data-content="Date: <?PHP echo date('M d, Y',time()) .' <br> 
										Time: '. date('h:i:s A',time()); ?>"	>
					<span class="label label-danger"><i class="fa  fa-clock-o"></i> Time</span> 
					<span id="ServerTime"></span> <small class="text-muted">Europe</small>
				</div>
					
					
			</div>
		<div class="row">
			<div class="pull-left">
				<img class="gameLogo" src="/theme/<?PHP echo strtolower($game->game); ?>/<?PHP echo strtolower($game->game); ?>_icon.png" />
				
			</div>
			<h3 
			data-toggle="popover" 
				data-placement="bottom"
				data-trigger="hover" 
				title="<?PHP echo strtoupper($info['Web']['Server Name']); ?>" 
				data-content="<?PHP echo $info['Web']['Description']; ?>"	>
			<button data-toggle="tooltip" data-placement="bottom" title="Change the Server you are viewing.."
			href="#" data-target="#serverList" role="button" class="btn btn-xs btn-success modalpop">
			<i class="fa fa-retweet"></i></button>
			<?PHP echo strtoupper($info['Web']['Server Name']); ?>   <small class="hidden-xs description"><?PHP echo $game->game; ?></small>
			</h3>
			
			<div class="serverMenu">
				<ul class="">
				<?PHP
					 echo Constants::$V['ServerMenu'];
				?>			
				</ul>
			</div>
	
		</div>
		
		</div>
	</div>
	
		
</div>
<!-- bar end -->
<!-- bread -->
<ol class="breadcrumb animated fadeInUp">	
	  <li><a href="/">Home</a></li>
	  <li><a href="/dashboard"><i class="fa fa-desktop"></i> <?PHP echo $info['Web']['Server Name']; ?></a></li>
	  <li class="active"><?PHP echo $page; ?></li>
		<div class="hide"><small>
		<?PHP 
			echo $info['Web']['Description'];
		?>
		</small></div>
</ol>
	<!-- end bread -->		

<?PHP
//print_r($widgets);
	$left = 'col-md-9 col-sm-12  col-xs-12';
	$right = 'col-md-3 col-sm-12 col-xs-12';
	if (count(Constants::$V['widgets']) == 0) {
		$left = 'col-xs-12';
		$right = 'hidden';
	}
	if ($widgetsLocation != 'right') {
		$left = 'col-xs-12';
		$right = 'col-xs-12';	
	}

?>
<section class="<?PHP echo $left; ?>  no-padding wrap-<?PHP echo preg_replace('/ /i','_',$info['Web']['Server Name']); ?>">
<?PHP 	

echo Constants::$V['bodyContents']; ?>
	<br/><br/>&nbsp;<br/>
</section>

<section class="<?PHP echo $right; ?> no-padding">
<?PHP
	echo Constants::$V['widgetsContents'];

?>
</section>