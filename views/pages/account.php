<?PHP 
$tab = 'info';
if (@$_GET['tab']) $tab = $_GET['tab'];

?>
<h2>Account Management</h2>
<div  class="col-xs-12  no-padding  darkTab">	
	<ul class="nav nav-tabs">
	 
	  <?PHP 
		$cnt =1;
		foreach($content as $cont => $w) {
		$icon = (@$w['icon']) ? '<i class="fa '.$w['icon'].'"></i> ' : '';
		$badge = (@$w['badge']) ? '<span class="badge">'.$w['badge'].'</span>' : '';
			$active = ($cont == $tab) ? 'class="active"' :'';
		?>
		<li <?PHP echo $active; ?>><a href="#account-<?PHP echo $cnt; ?>" data-target="" data-toggle="tab">		
		<?PHP echo $icon; ?> <?PHP echo $w['title']; ?> <?PHP echo $badge; ?></a> </li>
		<?PHP 	
		$cnt++;
		}
	   ?>
	</ul>
	
	
	<div class="tab-content  bg-trans   panel-dashboard">
	
	<?PHP 
		$cnt =1;
		foreach($content as $cont => $w) {	
			$active = ($cont == $tab) ? 'active  in"' :'';	
		?>
		<div class="tab-pane animated fade <?PHP echo $active; ?>" id="account-<?PHP echo $cnt; ?>">
		<?PHP
		if (@$w['footer'])
			echo '<div class="tab-footer">'.$w['footer'].'</div>';
		if (@$w['body'])
			echo '<div class="tab-body">'.$w['body'].'</div>';
		if (@$w['table']) echo $w['table'];
	
		?>
		</div>
	  <?PHP
		$cnt++;
		}
	?>

	
	
	</div>
</div>
<script>
$(document).ready(function() {
/* stats adder UI script */
$('.statAdderBtn').each(function(e,i) {
  var t = $(i),
      v = t.parent().children('span').html(),
      id = t.parent().children('span').attr('id'),
      type= id.split('-'),
      l = t.parent().children('label').html();
  
  var input = '<div><div class="input-group input-group-sm">'+              
               '<span class="input-group-addon">'+l+'</span>'+
               '<input type="text" name="stats['+type[0]+']" value="0" class="stats form-control">'+
               '<span class="input-group-btn">'+
               '<button data-target="'+id+'" class="btn btn-default sendStatBtn" type="button">Go!</button></span>'+
              '</div><label class="feedback"></label></div>';
      
  t.popover({
    'placement': 'auto',
			'html':true,
			'container': '#MyCharacters',
      'content': input,
    'title': 'Add Stat to '+ l
  });
  
});

$('#MyCharacters').delegate('[data-toggle=popover]','click',function(e) {
	var t = $("#MyCharacters [data-toggle=popover]");
    t.not(this).popover('hide');   
    $('.popover-title').append('<button type="button" class="close">&times;</button>');	
    $('.popover-title .close').click(function(e){
           t.popover('hide');
    });
});


$('#MyCharacters').delegate('.sendStatBtn','click',function(e) {
  var t = $(this),
      tr = $('#'+t.data('target')),
      c = t.parent().parent(),
      f = c.parent().children('.feedback'),
      v = t.parent().children('span').html();
  var value = c.children('.stats').val();
  if (value > 0) {
      t.button('loading');
      $.getJSON('/api/', {
      sid: tr.data('sid'),
      action: tr.data('action'),
      type: tr.data('type'),
      id: tr.data('id'),
        stat: value
      }).done(function( data ) {
       
        t.button('reset');
        if (data.msg) {
          f.html(data.msg);
          data.msg = '';
        }
         $.parseJSONData(data);
      });
  } else {
      f.html('['+value+'] Invalid Input');
  }
});



});

</script>

