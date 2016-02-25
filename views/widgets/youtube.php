<script src="https://apis.google.com/js/platform.js"></script>
<div class="g-ytsubscribe" data-channel="CoreDekaron" data-layout="full" data-theme="dark" data-count="default"></div>
<div class="ytList2 row">
<?PHP

	require_once '/lib/GOOGLE/Google_Client.php';
	require_once '/lib/GOOGLE/contrib/Google_YouTubeService.php';
	$DEVELOPER_KEY = 'AIzaSyAvscWvo82oc9qG6AD4C-fnJCi7r2ApJnY';

	$client = new Google_Client();
	$client->setDeveloperKey($DEVELOPER_KEY);

	$youtube = new Google_YoutubeService($client);

	try {
	$searchResponse = $youtube->search->listSearch('id,snippet', array(
	  'q' => 'CoreDekaron',
	  'maxResults' => 12,
	));
	$videos = '';
	$channels = '';
	$playlists = '';
	foreach($searchResponse['items'] as $s) {
		$id = $s['id']['videoId'];
		$thmb = $s['snippet']['thumbnails']['medium']['url'];
		$title = $s['snippet']['title'];
		echo '<div class="col-xs-4">';
		echo '<div class="ytThmb">
			<a data-toggle="tooltip" data-placement="bottom"
				title="'.$title.'"
				href="http://www.youtube.com/watch?v='.$id.'" target="_NEW"><img src="'.$thmb.'" /></a></div>';
		echo '<div class="ytTitle">'.$title.'</div>';
		echo '</div>';
	}

END;
 } catch (Google_ServiceException $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }


?>
	</div>
	