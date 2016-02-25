<?PHP
require('../../../../lib/CSV/parsecsv.lib.php');
$csv = new parseCSV('guild.csv');

$icon = @$_GET['i'] ? $_GET['i'] : 107;
$bg = @$_GET['bg'] ? $_GET['bg'] : 33;

$image = array();


foreach($csv->data as $data => $d) {

	if ($d['type'] == 'guildicon_s' && $d['index'] == $icon) $image['icon'] = $d;
	
	if ($d['type'] == 'guildbg' && $d['index'] == $bg) $image['bg'] = $d;
	
}

// create background
$bg = imagecreatefrompng($image['bg']['image']);

$icon = imagecreatefrompng($image['icon']['image']);

$dest = imagecreatetruecolor($image['bg']['w'], $image['bg']['h']);
imagecopy($dest, $bg, 0, 0, $image['bg']['x'], $image['bg']['y'], $image['bg']['w'], $image['bg']['h']);


imagecopyresized($dest, $icon, 0, 0, $image['icon']['x'], $image['icon']['y'], $image['bg']['w'], $image['bg']['h'], $image['icon']['w'], $image['icon']['h']);

header('Content-Type: image/png');
imagegif($dest);

imagedestroy($dest);
imagedestroy($src);

?>