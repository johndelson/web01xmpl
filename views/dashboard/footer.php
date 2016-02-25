<div class="clear"></div>
<section id="bottomContent" class="col-sm-12 hidden-xs no-padding ">
	<?PHP
		echo ApiController::widgets($sid,'community-btm',true,3600*24);	
	?>
</section>	
<div class="clear"></div>
<section id="bottomContent2" class="col-sm-12 hidden-xs no-padding">
	<?PHP
		echo ApiController::widgets($sid,'forum-btm',true,3600);
	
	?>
</section>	
<div class="clear"></div>	
</div><!-- mainDashboard -->
	
        </div>
    </div>
</div>
	
	
</div><!-- mainWrap -->
<div class="clear"></div>
<div class="col-12 biggerSide" id="copyright">
		 <div class="pull-right socialBtm">
			<a href="<?PHP echo Constants::TWITTER; ?>" target="_NEW" class="twitter"><i class="fa fa-twitter"></i></a>
			<a href="<?PHP echo Constants::YOUTUBE; ?>" target="_NEW"  class="youtube"><i class="fa fa-youtube"></i></a>
			<a href="<?PHP echo Constants::FACEBOOK; ?>" target="_NEW"  class="facebook"><i class="fa fa-facebook"></i></a>
		 </div>
		 <i class="glyphicon glyphicon-copyright-mark"></i> Core-Games.net - 2015. Trademarks are the property of their respective owners, all sites and servers are added by users.
		<br/>
		<?PHP

		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - STARTTIME), 4);
		echo 'Page generated in '.$total_time.' seconds.';
		?>
						
</div>



<?PHP  include_once "theme/footer.php"; ?>