<div class="container">
<div class="row">
<div id="communityPage" class="col-xs-12 darkTab">	
	<ul class="nav nav-tabs tab-ajax">
	 
	  <li class="active"><a href="#community-0" data-toggle="tab"><i class="fa fa-info"></i> Core-Games</a></li>
	  <?PHP 
		foreach($Server as $srv => $s) {
		?>
		<li><a href="#forum-<?PHP echo $srv; ?>" data-target="" data-toggle="tab"><span class="label label-danger">forum</span> <?PHP echo $s['Web']['Server Name']; ?></a></li>
	  <?PHP 	
		}
	   ?>
	
	
		<li>
			<a href="#Youtube" data-toggle="tab"><i class="fa bg-maroon fa-youtube"></i> Videos</a>								
		</li>
				
	</ul>

	<div class="tab-content  bg-trans scrollThis">
	<div class="tab-pane active animated fade in" id="community-0"><div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=705434352807057&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="col-sm-8 hidden-xs bg-trans" id="likebox">
<!--<div class="fb-like" data-href="https://www.core-games.net/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
	-->
<div class="fb-like-box" data-href="https://www.facebook.com/CoreDekaronOfficial" style="width:100%;" data-width="100%" data-show-faces="true" data-header="false" data-stream="true" data-show-border="false"></div>


	</div>
<div class="col-sm-4">
<div class="twitter">
		<a class="twitter-timeline" height="" data-chrome="light" data-dnt="true" href="https://twitter.com/CoreGames1" data-widget-id="474998619896946688">Tweets by @CoreGames1</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

		
		</div>
</div></div>
	<?PHP 
		foreach($Server as $srv => $s) {
		?>
		<div class="tab-pane fade" id="forum-<?PHP echo $srv; ?>"></div>
	  <?PHP 	
		}
	?>

	
	<div class="tab-pane fade" id="Youtube"></div>	
	</div>
	
</div>
</div>
</div>