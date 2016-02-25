<div id="mainHeadings">
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
	
	
	<section class="<?PHP echo $left; ?> no-padding wrap-<?PHP echo preg_replace('/ /i','_',$info['Web']['Server Name']); ?>">
		<?PHP  
	
		 require($body); 
		 
		 ?>
	</section>
	

	
&nbsp;
<?PHP

	$left = 'col-sm-9 col-xs-12';
	$right = 'col-sm-3 col-xs-12';
	if (count(@$widgets) == 0) {
		$left = 'col-xs-12';
		$right = 'hidden';
	}

?>

<section class="<?PHP echo $right; ?> no-padding">
</section>       
			
			
