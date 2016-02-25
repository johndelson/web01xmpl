<h2>Server Page</h2>
<?PHP
 $classes = $game->decodeDefinesArray('Character Class');
 $maps = $game->decodeDefinesArray('Maps');
 $basic = $game->decodeThis('Basic','Settings'); 
 $serverid = $basic['Server ID'];
 //print_r($classes);

require_once('menu.php');

 //get online maps
 $onlineMaps = $game->webClientDo('getOnlineMaps');
 $wOld = Constants::$V['widgets'];
 Constants::$V['widgets'] = array();
 Constants::$V['widgets']['Events']  = array(
		'col'=>12,
		'display'=>true,
		'title'=>'Event Timer',
		'icon'=>'fa-clock',
 );

$events = $game->decodeDefinesArray('Events');
$hour = intval(date('G',time()));
Constants::$V['widgets']['Events']['table'] = '<table class="table table-striped table-bordered">';
foreach($events as $ee => $e) {
 
	Constants::$V['widgets']['Events']['table'] .= '<tr><td>'.$ee.'</td><td>';

	$next = array();
	$cnt=0;
	foreach($e as $st => $en) {
		$s = explode(':',$st);
		$e = explode(':',$en);
		if ($cnt == 0) $next['first'] = $st;
		$cnt++;
		if ($hour < $s[0]) {
			if (!isset($next['st'])) $next['st'] = $st;
		} 				
	}
	$now = time();
	if (!isset($next['st'])) {
		$next['st'] = $next['first'];
		$now += 86400;
	}
	$nxt = strtotime(date('m/d/Y',$now).' '.$next['st'].':00');

	//echo $nxt-time();
	$diff =$nxt - time();
	
	Constants::$V['widgets']['Events']['table'] .=  '<small data-toggle="tooltip" data-placement="bottom" title="'.date('m/d/Y',$now).' '.$next['st'].':00'.'"><div class="countDown" data-timer="'.$diff.'">'.$diff.'</div></small>';
	Constants::$V['widgets']['Events']['table'] .=  '</td></tr>';
	


}
	Constants::$V['widgets']['Events']['table'] .=  '</table>';	
	Constants::$V['widgets'] = array_merge(Constants::$V['widgets'],$wOld);
	Constants::$V['widgetsLocation'] = 'bottom';
?>
	

	
	
<div class="col-sm-12 no-padding darkTab">	
<ul class="nav nav-tabs">
 <?PHP

	$tab = 'rankings';
	if (@$_GET['tab']) $tab = $_GET['tab'];
	foreach(Constants::$V['MainNav']['Server'][3] as $sub => $s) {
		if ($s[3] != 'tab') continue;
		$active = $sub == $tab ? 'active' : '';
		echo '<li class="'.$active.'">
			<a href="#tab_'.$sub.'" data-toggle="tab"><i class="fa '.$s[0].'"></i> '.$s[1].'</a></li>';
		
	}

 ?>
  
</ul>

<div class="tab-content   bg-trans   panel-dashboard">

<div class="tab-pane <?PHP echo $tab == 'rankings' ? 'active' :''; ?>" id="tab_rankings">
	  <div class="container-fluid">
	  <div class="col-md-3 col-sm-12  no-padding">
		  <form id="heroTable-Filter" class="form-ajax">
		  <h3><i class="fa fa-filter"></i> Hero Filter 
		  <div class="pull-right">
		  <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> GO</button>
		  </div></h3>
			
			  <div class="form-group">	  
				<label for="NAME">Character Name</label>
				<input type="text" class="form-control" id="NAME" placeholder="CHARACTER NAME">
			  </div>
			  <div class="form-group">	  
			  <div class="form-header">Character Class</div>
				  <?PHP
					foreach($classes as $cl => $c) {
						echo '<div class="col-sm-3 col-xs-6 col-md-12"><div class="checkbox">
								<label>
								<input type="checkbox" checked="checked" id="classes" value="'.$cl.'"> '.$c.'
								</label>
							  </div></div>';
					}
				  ?>		
			  </div>
		  </form>
	  </div>
	  <div class="col-sm-12 col-md-9">
	  <?PHP
		$reborn = $game->decodeThis('Reborn','Settings'); 	
		$rStatus = $reborn['Reborn State'];
		$rebornCol = $reborn['Column'];	
	
	  ?>
		<table id="heroTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Class</th>	
					<th>PVP</th>
					<th>Level</th>
					<?PHP if ($rStatus == 1): ?><th><?PHP echo $rebornCol; ?></th><?PHP endif; ?>					
				</tr>
			</thead>
	 
			<tfoot>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Class</th>	
					<th>PVP</th>
					<th>Level</th>
						<?PHP if ($rStatus == 1): ?><th><?PHP echo $rebornCol; ?></th><?PHP endif; ?>
				</tr>
			</tfoot>
		</table>
		

	  </div>
	  
	  </div>
	  
  
</div>
  <div class="tab-pane  <?PHP echo $tab == 'guilds' ? 'active' :''; ?>" id="tab_guilds">    
    <div class="container-fluid">
	  <div class="col-xs-12 no-padding">
	
		<!-- GUILD LIST -->
		<table id="guildTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
					<th>Logo</th>
					<th>Name</th>
					<th>Members</th>
					<th>Master</th>
					<th>Level</th>							
				</tr>
			</thead>	 
			<tfoot>
				<tr>
					<th></th>
					<th>Logo</th>
					<th>Name</th>
					<th>Members</th>
					<th>Master</th>
					<th>Level</th>	
				</tr>
			</tfoot>
		</table>
		
		
		</div>
	
  
    </div>
  </div>

  <div class="tab-pane  <?PHP echo $tab == 'livemap' ? 'active' :''; ?>" id="tab_livemap">
  
    <div class="container-fluid">
	<div class="row">
	  <div class="col-xs-12 no-padding">
	  <form id="heroTable-Filter" class="form-ajax">
	  <h3><i class="fa fa-filter"></i> Map List 
	  <div class="pull-right">
	
	  </div></h3>
		<div class="list-group map-list">
		<div class=" scrollThis2">
		<?PHP
		 foreach($onlineMaps['data'] as $mm =>$m) {
			echo '<div class="col-xs-4"><a href="#" data-mapid="',$m['MAPID'],'" class="bg-trans list-group-item">
			<img src="/s/dekaron/map/'.$serverid.'/'.$m['MAPID'].'" class="mapIcon" />
			<span class="badge">',$m['CNT'],'</span>
			',($m['MAPNAME'] == '' ? '[id:'.$m['MAPID'].']-unknown':$m['MAPNAME']),'
		    </a></div>';
		 
		 }
	
		?>
		  </div>
		</div>
  
	  </form>
	  </div>
	  <div class="col-xs-12 row">
		  <div class="col-xs-8 no-padding">
		  <div id="map-holder">
		  </div>
		  </div>
		  <div class="col-xs-3 pull-right">
		  <div id="user-list-holder">
		  </div>
		  </div>
	   </div>
	</div>
	 </div>
  </div>
  
  <div class="tab-pane  <?PHP echo $tab == 'events' ? 'active' :''; ?>" id="tab_events">
  <?PHP
	$events = $game->decodeDefinesArray('Events');
	$hour = intval(date('G',time()));
	
?>
<div class="container-fluid">
<div class="table-responsive">
	<table class="table crossed table-condensed">
	<?PHP for($x=0;$x <= 25; $x++) {
	 echo '<colgroup></colgroup>';
	}
	?>
	<thead><tr class="bg-trans"><th>Event</th>
	<?PHP for($x=0;$x <= 24; $x++) {
			$now = ($x == $hour) ? 'bg-teal' :'old';
			if ($x > $hour) $now = '';
			echo '<th class="'.$now.'"><span data-original-title="'.$x.':00" data-toggle="tooltip" data-placement="top">'.$x.'</span></th>'; 
	}
	?>
	</tr></thead>
	<tbody>
	<?PHP
		foreach($events as $ee => $e) {
			echo '<tr><td>'.$ee.'</td>
				';
				//print_r($e);<td colspan="25">
			$times = array();
			foreach($e as $aa => $a) {		
				$b = explode(':',$aa);
				$times[$b[0]] = array($aa,$a);
			}	
			for($x=0;$x <= 24; $x++) {
				$now = ($x == $hour) ? 'bg-teal' :'old';
				if ($x > $hour) $now = '';
				$time = (@$times[$x]) ? '<i data-original-title="'.$times[$x][0].' - '.$times[$x][1].'" data-toggle="tooltip" data-placement="top" class="fa fa-clock-o"></i>' : '';		
				echo '<td  class="'.$now.'">'.$time.'</td>';
			}
			/*echo '<div class="progress">';	
			for($x=0;$x <= 24; $x++) {				
				$active = (@in_array($x,$times)) ? 'progress-bar progress-bar-success' : 'progress-bar';
				echo '<div class="'.$active.'" style="width: 4.166666666666667%">						
					  </div>';				
			}				
			echo '</div>';</td>
			*/
			echo '</tr>';
		
		}
	
	?>
	
	
	</tbody>
	
	<tfoot><tr  class="bg-trans"><th>Event</th>
	<?PHP for($x=0;$x <= 24; $x++) {
			$now = ($x == $hour) ? 'bg-teal' :'old';
			if ($x > $hour) $now = '';
			echo '<th class="'.$now.'">'.$x.'</th>'; 
	}
	?>
	</tr></tfoot>
	</table>
	
</div>
  </div>
  <div class="row">
	<div class="col-sm-12">	
		<div class="panel panel-dashboard">
			<div class="panel-heading">			
				<h3 class="panel-title"><i class="fa  fa-bookmark"></i> Castle Siege</h3>
			</div>
			
			<table class="table table-striped table-bordered">	
			<?PHP
				$data = $game->webClientDo('getCastleSiege');
				$cs = $data['data'];
				//print_r($cs);
				
			?>
			<tr><td>Castle Holder:</td><td>
			<?PHP
				echo '<div  class="col-sm-3 no-padding"><img src="'.$cs['guild']['LOGO'].'" width="64"></div>';
				echo '<div  class="col-sm-9"><b>'.$cs['guild']['NAME'].'</b><br/>';
				echo 'Master: <b>'.$cs['guild']['MASTER'].'</b><br/>';
				echo 'Members: <b>'.$cs['guild']['MEMBERS'].'</b><br/></div>';
			?>
			</td></tr>
			<tr><td>Next Seige Date:</td><td>
			<?PHP			
				$csDate = strtotime($cs['start_time']);
				echo date($info['Basic']['Date Format'],$csDate);
			
			?>
			</td></tr>
			<tr><td>Countdown:</td><td>
			<?PHP			
				$diff = strtotime($cs['start_time']) - time() ;
				echo '<div class="countDown" data-timer="'.$diff.'">'.$diff.'</div>';
			?>
			</td></tr>
			<tr><td>End Seige Date:</td><td>
			<?PHP			
				$csDate = strtotime($cs['end_time']);
				echo date($info['Basic']['Date Format'],$csDate);
			
			?>
			</td></tr>
		
			</table>
			
		</div>
	</div>
	</div>
</div>
</div>
</div>
<script>
$(document).ready(function() {



$('.countDown').each(function(e,i) {
  var t = $(this);
  var timer = t.data('timer'); 
  var cd = setInterval( function(){
    if (timer > 0) {
      timer = timer - 1;
      t.html(convert_to_time_x100(timer));
      
    } else {
      clearInterval(cd, 1000); 
      t.html('Live');
    }
   } , 1000);
});

function convert_to_time_x100(secs_x100) {
	  var secs_x100 = parseInt(secs_x100),  hh_x100 = secs_x100 / 3600,hh_x100 = parseInt(hh_x100),mmt_x100 = secs_x100 - (hh_x100 * 3600),mm_x100 = mmt_x100 / 60,mm_x100 = parseInt(mm_x100),ss_x100 = mmt_x100 - (mm_x100 * 60);
	  if (hh_x100 > 23)  {
		 dd_x100 = hh_x100 / 24;
		 dd_x100 = parseInt(dd_x100);
		 hh_x100 = hh_x100 - (dd_x100 * 24);
	  } else { dd_x100 = 0; }

	  if (ss_x100 < 10) { ss_x100 = "0"+ss_x100; }
	  if (mm_x100 < 10) { mm_x100 = "0"+mm_x100; }
	  if (hh_x100 < 10) { hh_x100 = "0"+hh_x100; }
	  if (dd_x100 == 0) { return (hh_x100+":"+mm_x100+":"+ss_x100); }
	  else {
		if (dd_x100 > 1) { return (dd_x100+" days "+hh_x100+":"+mm_x100+":"+ss_x100); }
		else { return (dd_x100+" day "+hh_x100+":"+mm_x100+":"+ss_x100); }
	  }
	}
	function guildformat(d) {
		var out = '<ul class="list-inline">';
		$.each(d.MEMBERLIST, function(e,i) {
			out += '<li class="col-xs-3"><span class="label label-danger">'+i.TITLE+'</span> '+i.NAME+'</li>';
		});
		out += '</ul>';
		return out;
	}
	<?PHP if (@$thisVIP == true): ?>
	function format( d ) {
		var ret = '<div class="more-wrap row" style="background-image:url(/theme/s/<?PHP echo $serverid; ?>/img/CLASS/mini_'+d.CL+'.png);"><div class="col-xs-12">';
		if (d.GUILD) {
		//console.log(d.GUILD);
		ret += 	'<div class="col-xs-3 guildDisplay">'+
				'<img src="'+d.GUILD.LOGO+'/80">'+
				'<h4>'+d.GUILD.NAME+'</h4>'+
				d.GUILD.TITLE+
			'</div>';
		}
		ret += 	'<div class="col-xs-3">';
		if (d.RANK) {
			ret += 	'<label>Rank:</label>'+
				'<div>'+d.RANK+'</div>';
		}	
			ret += 	'<label>MONEY:</label>'+
				'<div>'+d.MONEY+'</div>'+
				'<label>MAP:</label>'+
				'<div>'+d.MAPID+'</div>'+
			'</div>';
		ret += 	'<div class="col-xs-6">'+
				'<label>Confirmed Kills:</label>'+
				'<div><span>Players <span class="badge bg-red">'+d.KILLS+'</span></span></div>'+
				'<label>PVP Win/Lose/Draw:</label>'+
				'<div><span>Wins <span class="badge bg-yellow">'+d.WIN+'</span></span> <span>Lose <span class="badge bg-fuchsia">'+d.LOSE+'</span></span> <span>Draw <span class="badge bg-purple">'+d.DRAW+'</span></span></div>'+
				'<label>Stats Distribution:</label>'+
				'<div><span>STR <span class="badge bg-blue">'+d.STR+'</span></span> <span>CON <span class="badge bg-green">'+d.CON+'</span></span> <span>DEX <span class="badge bg-maroon">'+d.DEX+'</span></span> <span>SPR <span class="badge bg-teal">'+d.SPR+'</span></span> </div>'+
	
			'</div>';
					
	
		ret += '</div>';
		
		return ret;
	}
	<?PHP else: ?>
	function format( d ) {
		return '<h3><i class="fa fa-exclamation-triangle"></i> VIP ACCESS NEEDED! <small> buy monthly VIP access now...</small></h3>';
	}
	<?PHP endif; ?>
	var ajaxurl = "/api/?&cache=1800&sid=<?PHP echo $sid; ?>";
	
	
	var heroTableUrl = ajaxurl+"&action=heroRankings";
	var heroTable = $('#heroTable').dataTable( {
		"processing": true,
		"serverSide": true,
		"sDom": '<l<"pull-right"i><rt>p>',
		"ajax":  heroTableUrl,
		"columns": [
			{   "class":          'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
			{ "data": "NAME" },
			{ "data": "CLASS" },
		
			{ "data": "PVP" },
			{ "data": "LEVEL" },
		<?PHP if ($rStatus == 1): ?>{ "data": "<?PHP echo $rebornCol; ?>" }<?PHP endif; ?>
			
		],
		"order": [[ 3, "desc" ],
				   [ 4, "desc" ]
		],		
		"fnDrawCallback" : function() {
				$('#heroTable tbody .details-control:first').trigger('click');
		}
	});
	
	
    $('#heroTable tbody').on('click', '.details-control', function () {
        var tr = $(this).closest('tr');
        var row = heroTable.api().row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {          
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });
	
	$("#heroTable-Filter").submit(function( event ) {  
	  event.preventDefault();
	  var t = $(this);
	  var search = t.find('#NAME').val();
	  var table = heroTable.api();
	  var filter = $("input[id=classes]:checked").map(
			 function () {return this.value;}).get().join(",");
	  var url = heroTableUrl+ '&classed='+filter;
	  if (search != '') {
		table.search(search)
	  } else {
		table.search('');
	  }	
		
		table.ajax.url( url ).load();
	});
	
	/*guild list*/
	var guildTableUrl = ajaxurl+"&action=guildList";
	var guildTable = $('#guildTable').dataTable( {
		"processing": true,
		"serverSide": true,

		"ajax":  guildTableUrl,
		"columns": [
			{   "class":          'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
		    {  "class":          'guild_logo',
			  "orderable":      false,
			  "data": "LOGO",
			  "defaultContent": '' },
			{ "data": "NAME" },
			{ "data": "MEMBERS" },		
			{ "data": "MASTER" },
			{ "data": "LEVEL" },
			
		],
		"order": [[ 3, "desc" ],
					 [ 5, "desc" ],
					 [ 2, "asc" ],
		],
		"fnDrawCallback" : function() {
				$('#guildTable tbody .details-control:first').trigger('click');
		}
	});

	$('#guildTable tbody').on('click', '.details-control', function () {
        var tr = $(this).closest('tr');;
        var row = guildTable.api().row( tr );
       
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {          
            row.child( guildformat(row.data())).show();
            tr.addClass('shown');
        }
    });
	
	
	
	
	/* online map script */

	var onlineMapURL = ajaxurl + '&action=onlineByMapId';



	$('.map-list').delegate('a','click',function(e) {
	  e.preventDefault();
	  var t = $(this);
	  $('.map-list a').removeClass('active');
	  t.addClass('active');  
	  var mapid = t.data('mapid'),
		  userList = $('#user-list-holder'),
		  mapHolder = $('#map-holder');
	  mapHolder.html('<img src="/s/dekaron/map/<?PHP echo $serverid; ?>/'+mapid+'" />');       
	  $.getJSON(onlineMapURL + '&mapid='+ mapid,function(data) {
		if (data.mapSrc) {
			//mapHolder.html('<img src="'+data.mapSrc+'" />');        
		}
		userList.html('No Online Players');
		if (data.data == undefined) return false;
		if (data.data.length > 0) {
		   
		  out = '<h3><i class="fa fa-star"></i> '+(data.data.length)+' Online</h3><div class="list-group user-list"><div class="scrollThis">';
		  $.each(data.data,function(e,i) { 
		      var icon = '';
			  if (i.GUILD) icon = '<img src="'+i.GUILD.LOGO+'/16"> ';
			  out += '<a href="#" data-target="'+i.NO+'" class="list-group-item">'+icon+''+i.NAME+'</a>';
			  
			content = $.map(i,function(x,z) {			  
			  if ($.inArray(z,[ "NO", "NAME", "X", "Y", "MAPID","CL",'GUILD' ]) == -1 && x != '') 
				return z +': '+x;
			}).join(" <br> ");
			if (i.GUILD) {
				name = i.GUILD.NAME;
				content = "<div class='pull-right guildLogo'><img src='"+i.GUILD.LOGO+"'><span>"+name.replace(/[^a-z0-9\s]/gi, '')+"</span></div>" + content;
			}
			
			  mapHolder.append('<div data-toggle="popover" data-title="'+i.NAME+'" data-content="'+content+'" data-id="'+i.NO+'" style="top:'+i.X+'px;left:'+i.Y+'px;" class="animated map-dot"><i class="fa fa-user"></i></div>');
		  });
		  
		  out += '</div></div>';
		  userList.html(out);
		  
		} else {
			userList.html('No Online Players');
		} 
		
		$('#user-list-holder .scrollThis').slimScroll({
				'color': '#fff',
				'size': '6px',
				'height': 'auto',
				'alwaysVisible': true
		});
		$("#map-holder [data-toggle=popover]").popover({
			'placement': 'auto',
			'html':true,
			'container': '#map-holder'
			
		});
		
	  });
	});




	$('#map-holder').delegate('[data-toggle=popover]','click',function(e) {
      	$("[data-toggle=popover]").not(this).popover('hide');        
	});

	$('#user-list-holder').delegate('a','click',function(e){
		  e.preventDefault();
		  var t = $(this);
		  $('.user-list a').removeClass('active');
		  t.addClass('active'); 
		  var tr = $('[data-id='+t.data('target')+']');
		  $("#map-holder [data-toggle=popover]").removeClass('active');
		  tr.trigger('click').addClass('active');
	});
	$('#user-list-holder').delegate('a','hover',function(e){
		  e.preventDefault();
		  var t = $(this);
		  var tr = $('[data-id='+t.data('target')+']');
		  $("#map-holder [data-toggle=popover]").removeClass('active');
		  tr.addClass('active');
	});
	
	
	$('.map-list a:first').trigger('click').addClass('active');

});

</script>