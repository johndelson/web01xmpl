<div id="community-btm">
<h2>Around the Community</h2>
<div class="row">
	<div class="col-md-4 col-sm-6">
	<div id="ytBox">
		

		<div class="g-ytsubscribe" data-channel="CoreDekaron" data-layout="full" data-theme="dark" data-count="default"></div>
		<div class="ytList">
	<?PHP
		$items = ApiController::youtube_get_list();
		
		if ($items['code'] == 200) {
		foreach($items['data'] as $s) {
			$id = $s['id']['videoId'];
			$thmb = $s['snippet']['thumbnails']['default']['url'];
			$title = $s['snippet']['title'];
			echo '<div class="col-xs-4">';
			echo '<div class="ytThmb">
				<a data-toggle="tooltip" data-placement="bottom"
					title="'.$title.'"
					href="http://www.youtube.com/watch?v='.$id.'" target="_NEW"><img src="'.$thmb.'" /></a></div>';
			//echo '<div class="ytTitle">'.$title.'</div>';
			echo '</div>';
		}
		} else echo 'No Match Found';
	?>
		</div>
	</div>
	</div>

	<div class="col-md-4 col-sm-6">
	<a class="twitter-timeline" href="https://twitter.com/DekaronCore" data-widget-id="606366909596966914">Tweets by @DekaronCore</a>

	</div>
	<div class="col-md-4 col-sm-12">
		<div id="likebox">

		<div id="fb-root"></div>
	
		<div class="fb-like-box" data-href="https://www.facebook.com/CoreDekaronOfficial" style="width:100%;"
		 data-width="100%" data-show-faces="true" 
		 data-header="false" data-stream="false" data-show-border="false"></div>

		</div>
	</div>
 
 </div>

