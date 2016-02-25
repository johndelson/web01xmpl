<h2 class="">Web Vault. <small class="text-muted">store & move items from the games.</small></h2>
<?PHP
//error_reporting(E_ALL);
//INSTALL BY PASS
if ($_GET['install'] == 1) {
	
$item_vault = 'CREATE TABLE IF NOT EXISTS `item_vault` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `owner_id` varchar(50) NOT NULL,
	  `char_id` varchar(50) NOT NULL,
	  `server_id` int(20) NOT NULL,
	  `item_id` varchar(255) NOT NULL,
	  `item_serial` varchar(100) NOT NULL,
	  `datestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `active` int(11) NOT NULL,
	  `flag` int(11) NOT NULL,
	  `data` text NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;';
$game->db->Execute($item_vault);
	
}

$web = $game->decodeThis('Website','Settings');


Constants::$V['widgets'] = array();
$game->db->debug=0;

/* get items from game storage */
$vL= array();
foreach($Characters['data'] as $cc => $c) {

	$vL[$c['NO']] = $game->webClientDo('gameStorageList',array($c['NO']));
	
}

		
?>
<div class="col-xs-6 ">
<div class="panel panel-dashboard">

<div class="panel-table  bg-trans">

		<!-- GUILD LIST -->
		<table id="vaultTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
				
					<th>Type</th>
					<th>Status</th>							
				</tr>
			</thead>	 
			<tfoot>
				<tr>
					<th></th>					
					<th>Name</th>
					
					<th>Type</th>
					<th>Status</th>		
				</tr>
			</tfoot>
		</table>
		
		  <div class="clear"></div>
		</div>
	

    </div>
</div>

<div class="col-xs-6 ">

<div class="row">
<div class="vaultTab">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">

	<li role="presentation" class="dropdown open pull-right">
        <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="true">Character List <span class="caret"></span></a>
        <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
         <?PHP
		  $cn = 0;
			foreach($Characters['data'] as $cc => $c) {
				$cn++;
				$cl = ($cn==1) ? 'class="active"' : '';
				
				echo '<li role="presentation" '.$cl.'>
				<a href="#Char_'.$c['NAME'].'" aria-controls="Char_'.$c['NAME'].'" role="tab" data-toggle="tab">';
				$cnt = count($vL[$cc]['data']);
				if ($cnt > 0) 
					echo '<span class="label label-success pull-right">'.$cnt.'</span>';
				echo '<i class="fa fa-user"></i> '.$c['NAME'].'</a></li>';
			}
		  ?>   

		 
        </ul>
      </li>
    <h3>Character Storages</h3>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  	  <?PHP
		$cn = 0;
		foreach($Characters['data'] as $cc => $c) {
			$cn++;
			$cl = ($cn==1) ? 'active' : '';
			
			echo '<div role="tabpanel" class="bg-trans tab-pane '.$cl.'" id="Char_'.$c['NAME'].'">
			<div class="col-xs-12 panel-dashboard ">';
			
				
				if ($vL[$cc]['code'] == 200) {
					
					echo '<br/><table class="table table1st table-striped" id="t_'.$c['NO'].'" >';
					foreach($vL[$cc]['data'] as $ii => $i) {
						echo '<tr id="i_'.$i['ID'].'_'.$c['NO'].'"><td>'.$i['ID'] .'</td>';
						echo '<td><img src="'.$i['IMG'] .'" height="42" /></td>';
						echo '<td>';
						echo $i['NAME'] . '<br/><small>'.$i['INDEX'].' / '.$i['TYPE'].'</small>';
						echo '</td>';
						echo '<td>';
						if (@$i['noAction'] == 1) {
							echo '<i>Disabled</i>';
						} else {
							echo '<button 
									data-cid="'.$c['NO'].'" 
									data-id="'.$i['ID'].'" 
									data-sid="'.$sid.'" 
									data-callback="itemMove"
									
									data-action="vaultStore" class="ajax btn btn-sm btn-primary">
								<i class="fa-reply fa"></i> Store</button>';
						}
						echo '</td>';
						echo '</tr>';
					}
					echo '</table><br/>';
				} else echo '<i>This Character ['.$c['NAME'].'] has Zero (0) Items in storage</i>';
				
			
			echo '</div></div>';
		}
	  ?>
   
  </div>

</div>

</div>
</div>
<div id="vaultAuction" class="hidden">
TESTING AUCTION BUTTON
</div>
<script language="javascript">
var ajaxurl = "/api/?&cache=0&sid=<?PHP echo $sid; ?>";
var vaultTableUrl = ajaxurl+"&action=vaultList";


function vaultformat(o) {
		var out = '<div class="pull-right"><img src="'+o.IMG+'" /></div>';
		out += '<ul class="list-inline">';
		if (o['FLAG'] == 0) {
			out += '<li><button class="btn btn-sm btn-primary ajax" data-sid="<?PHP echo $sid; ?>" data-callback="refreshTable" data-action="vaultSendGame" data-id="'+o['ID']+'"><i class="fa  fa-mail-forward"></i> Send to Game</button></li>'+
			'<li><button class="btn btn-sm btn-success getFrom" data-sid="<?PHP echo $sid; ?>" data-action="vaultAuction" data-id="'+o['ID']+'"><i class="fa  fa-sort-numeric-asc"></i> Auction</button></li>';
		}
		out +='<li><button class="btn btn-sm btn-danger ajax" data-sid="<?PHP echo $sid; ?>" data-callback="refreshTable" data-action="vaultDelete" data-id="'+o['ID']+'"><i class="fa fa-times"></i> Delete</button></li>'+
			
			'</ul>';
		out += 'ID: <b class="text-success">'+ o['ID']+'</b> <br/>'+
			'Index: <b class="text-success">'+ o['INDEX']+'</b> <br/>'+
			'From: <b class="text-success">'+ o['CHAR']+'</b> <br/>'+
			'Serial: <b class="text-success">'+ o['SERIAL']+'</b> <br/>'+
			'Date Moved: <b class="text-success">'+ o['DATE']+'</b> <br/>'
			
	
		return out;
}
function itemMove(data) {		
	var t = $('#i_'+data['id']+'_'+data['cid']);
	t.html('<td colspan="4">'+data['msg']+'</td>');
	var tab = $('#vaultTable').dataTable().api();
	tab.ajax.url( vaultTableUrl  ).load();
}
function refreshTable(data) {
	var tab = $('#vaultTable').dataTable().api();
	tab.ajax.url( vaultTableUrl).load();
	
	if (data.do) {
		switch(data.do) {
			case 'insert':
				var t= $(data.t + ' tr:first').before(data.html);
				
			break;
			
			
		}
		
	}
}	

	
$(document).ready(function() {	

	var vaultTable = $('#vaultTable').dataTable( {
		"processing": true,
		"serverSide": true,
		"sDom": '<<"pull-right"i><"pull-right"l><rt>p>',
		"ajax": vaultTableUrl,
		"columns": [
			{   "class":          'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
			{ "data": "NAME" },
			
		
			{ "data": "TYPE" },
			{ "data": "STATUS" },
		
			
		],
		"order": [[ 2, "desc" ],
				 
		],		
		"fnDrawCallback" : function() {
				$('#vaultTable tbody .details-control:first').trigger('click');
		}
	});
	$('#vaultTable tbody').on('click', '.details-control', function () {
        var tr = $(this).closest('tr');
        var row = vaultTable.api().row( tr );
       
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {          
            row.child( vaultformat(row.data())).show();
            tr.addClass('shown');
        }
    });
	
	
	/*$('.itemMove').on('click',function(e) {
	  var p = $(this).data('id');
	  var cid = $(this).data('cid');
	  var t = $(this).parent().parent();
	  var url = ajaxurl+'&action=vaultStore&id='+p+'&cid='+cid;
	  $.getJSON( url ,function(data) {		 
		if (data['code'] == 500) {
			alert(data['msg']);
		} else {
			t.html('<td colspan="2">'+data['msg']+'</td>');
			var tab = vaultTable.api();
			tab.ajax.url( vaultTableUrl  ).load();
		}
	   
	  });
	});*/
});

</script>