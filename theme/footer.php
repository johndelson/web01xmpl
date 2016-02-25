
 </div>
            <!-- /main -->
        <!-- sidebar -->
            
        </div>
		
		
		
		
		
    </div>
</div>



<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="work-modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<div class="pull-right">
					<button type="button" class="btn btn-sm btn-warning" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>


	<script type="text/javascript" src="/theme/js/vendors/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="/theme/js/jquery.fullPage.js"></script>
	
    <script src="/theme/js/bootstrap.min.js"></script>
	<script src="/theme/js/bootstrapValidator.min.js"></script>
	<!--<script src="/theme/js/jquery.tubular.1.0.js"></script>-->
	<?PHP if (getSession()->get(Constants::LOGGED_IN) == true): ?>
	<!-- dashboard scripts -->
	<script type="text/javascript" src="/theme/js/datatables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="/theme/js/datatables/dataTables.bootstrap.js"></script>
	<script type="text/javascript" src="/theme/js/flipcountdown-master/jquery.flipcountdown.js"></script>
	<link rel="stylesheet" type="text/css" href="/theme/js/flipcountdown-master/jquery.flipcountdown.css" />
	<?PHP endif; ?>
	<script src="/theme/js/main.js"></script>

<!--	<script src="/theme/js/pace.js"></script>
	<script type="text/javascript" src="/arrowchat/external.php?type=djs" charset="utf-8"></script>
	<script type="text/javascript" src="/arrowchat/external.php?type=js" charset="utf-8"></script>-->

<script>
	
	

$(document).ready(function(){/* off-canvas sidebar toggle */

$('[data-toggle=offcanvas]').click(function() {
  /*$(this).toggleClass('visible-xs text-center');
    $(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
    $('.row-offcanvas').toggleClass('active');
    $('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
	$('#sideLogo').toggleClass('hidden-xs').toggleClass('visible-xs');
    $('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
	$('#sidebar-footer').toggle();
    $('#btnShow').toggle();*/
});
$("img").error(function(){
        $(this).hide();
});
if ($('#ServerTime').length) 
	clock.init('<?PHP echo date('n/j/Y h:i:s A',time()); ?>','ServerTime',1000);
});
</script>
<img src="http://admincp.core-games.net/fireschedule.php?return_image=1" border="0" alt="">


</body>
</html>