<?PHP
$code = 'q2w2e235s2x52s5w2w';
if (!isset($_GET['c']) && @$_GET['c'] != $code) {
	header('LOCATION: index.php');
}
require_once 'lib/CONFIG/PHPInterfaceTags.php';
require_once 'lib/CONFIG/PHPClassForm.php';
require_once 'lib/CONFIG/PHPClassFormInputTypes.php';
// inlclude the class-file
require_once( 'lib/CONFIG/class.ConfigMagik.php');

// create new ConfigMagik-Object


/*
print_r($Config);

// set a key named 'Name' with value 'SomeOne' in section 'second_section'
$Config->set( 'Name', 'SomeOne', 'second_section');

// get value from current config
$name = $Config->get( 'Name', 'second_section');
echo "<p>Name: " . $name . "</p>\n";

// remove a key/value-pair from section
$Config->removeKey( 'Name', 'second_section');

// remove entire section
$Config->removeSection( 'first_section');

// print-out ConfigMagik-Object
print_r($Config); */
$iniList = array(
	'config' => array('lib/config.ini','Website Settings','basic'),
	'slider' => array('theme/slider.ini','Slider','add',array('TITLE','IMAGE_LINK','HEADLINE','TEXT','BUTTON_TEXT','BUTTON_LINK')),
);
$def = @$_GET['m'] && $iniList[$_GET['m']] ? $_GET['m'] : 'config';
$Config = new ConfigMagik( $iniList[$def][0], true, true);
$Config->SYNCHRONIZE      = true;
$VARS = $Config->VARS;
if (@$_POST['DROP']) {
	if ($iniList[$def][2] == 'add') {
		$Config->removeSection($_POST['DROP']);
	}
	$Config = new ConfigMagik( $iniList[$def][0], true, true);
	$VARS = $Config->VARS;
}
if (@$_POST['NEW']) {	
	if ($iniList[$def][2] == 'add') {
		foreach($_POST['NEW'] as $t => $v) {
			$Config->set( $t, $v, $_POST['NEW']['TITLE']);
		}
	}
	$Config = new ConfigMagik( $iniList[$def][0], true, true);
	$VARS = $Config->VARS;
}
elseif (@$_POST) {
	foreach ($VARS as $V => $sub) {
		foreach($sub as $t => $i) {
			if (isset($_POST[$V][$t])) {
				if ($_POST[$V][$t] != $i) {					
					$Config->set( $t, $_POST[$V][$t], $V);
				}
			}
		}
	}
	$VARS = $Config->VARS;
}
$form = new PHPClassForm();
$input = new PHPClassFormInput();
$select = new PHPClassFormSelect();
$readonly = new PHPClassFormReadOnly();
$textarea = new PHPClassFormTextarea(); 

$thisPageBase = $_SERVER['PHP_SELF'].'?c='.$_GET['c'];
$thisPage = $_SERVER['PHP_SELF'].'?c='.$_GET['c'].'&m='.$def;

$protected = array(
	'MySQL','Database'
);

//print_r($Config);
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="theme/css/config.css" />

<title></title>
</head>
<body>
<div id="menu">
<?PHP 
 foreach ($iniList as $cnf => $l) {
	echo '<div class="menuList">';
	echo '<a href="'.$thisPage.'&m='.$cnf.'">'.$l[1].'</a>';
	echo '</div>';
 }
?>
</div>
<div id="container">

<?PHP	


	foreach ($VARS as $V => $sub) {

		if (in_array($V,$protected)) continue;
		echo '<div class="formField">';
		$form->openForm($V, $thisPage, 'POST');
		echo '<h1>'.CleanName($V).'</h1>
			  <div id="data">';
		foreach($sub as $t => $i) {
			echo '<div class="field">';
			 $input->tagItem('text', $V.'['.$t.']', $i, CleanName($t), 'b');
			echo '</div>';
		}		
		echo '</div>';
		if ($iniList[$def][2] == 'add') {
			echo '<button class="submitButton" name="DROP" value="'.$V.'" type="submit">DROP</button>';
		}
		$form->closeForm();
		echo '</div>';
	}
if ($iniList[$def][2] == 'add') {
		echo '<div class="formField">';
		$form->openForm('NEW', $thisPage, 'POST');
		echo '<h1>NEW SLIDE</h1>';
		foreach($iniList[$def][3] as $m) {
			echo '<div class="field">';
			$input->tagItem('text', 'NEW['.$m.']', '', CleanName($m), 'b');
				
			echo '</div>';
		
		}
		$form->closeForm();
		echo '</div>';
	
}
?>



<?php 
// cleaners and shit...
function CleanName($t) {
	$clean = $t;
	$remove = array(
		'_'=>' ',
		'DB'=>'',
	
	);
	foreach($remove as $ii => $i) {
		$clean = preg_replace('/'.$ii.'/i',$i,$clean);
	}
	$clean = ucwords(strtolower($clean));
	return $clean;
}



/*
$arr = array("From 10 to 20", "From 30 to 40", "From 40 to 50");
$form->openForm('testForm', $_SERVER['PHP_SELF'], 'POST');
if (!isset($_POST['age'])){    
    $input->tagItem('text', 'name', '', 'Your name', 'b');
    print "<br /><br />";
    $select->tagItem('age', $arr, '------', 'Select your age range', 'b');
    print "<br /><br />";
    $textarea->tagItem('comment', '', 'Write your comment', 'b');
    print "<br /><br />";
    $form->closeForm();
    print "<br /><br />";
} else {
    $readonly->tagItem('','name', $_POST['name'], 'Your name is: ', 'b');
    print "<br /><br />";
    $readonly->tagItem('','age', $_POST['age'], 'Your age is: ');
    print "<br /><br />";
    $readonly->tagItem('','comment', $_POST['comment'], 'Your comment is: ');
    print "<br /><br />";
    $form->closeForm('no_submit');
    print "<br /><br />";
}*/
?>


</body>
</html>