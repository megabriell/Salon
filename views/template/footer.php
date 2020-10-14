			</section><!-- End section .content -->
        </div><!-- End div .content-wrapper -->
    </div><!-- End div .wrapper -->

<p style="margin-top: 25px;"></p>
<footer class="main-footer navbar-fixed-bottom">
	<!-- A la derecha -->
	<div class="pull-right hidden-xs">
		V.4.2
	</div>
	<!-- Predeterminado a la izquierda -->
	<strong>Copyright &copy; 2020-2021 <a href="#"><?php echo $infoCompany['Empresa']?></a></strong> All rights reserved.
</footer>



<!-- AdminLTE App -->
<script src="./template/js/app.js"></script>
<!-- bootstrapvalidator -->
<script src="./plugins/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
<!-- Formato number -->
<script src="./plugins/jquery-number-master/jquery.number.min.js"></script>

<!-- Datatable -->
<link rel="stylesheet" href="./plugins/datatables/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="./plugins/datatables/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="./plugins/datatables/css/dataTable.Welmaster.css">
<script src="./plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables/js/dataTables.bootstrap.min.js"></script>
<script src="./plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables/js/responsive.bootstrap.min.js"></script>
<script src="./plugins/datatables/js/accent-neutralise.js"></script>
<script src="./plugins/datatables/js/sum.js"></script>
<script src="./plugins/datatables/js/dataTable.Welmaster.js"></script>

<!-- Jquery-confirm-->
<link rel="stylesheet" href="./plugins/Jquery-confirm/jquery-confirm.min.css">
<script src="./plugins/Jquery-confirm/jquery-confirm.min.js"></script>

<!-- moment -->
<script type="text/javascript" src="./plugins/moment/moment.min.js"></script>

<!-- Scroll to element -->
<script type="text/javascript" src="./plugins/jquery.scrollTo/jquery.scrollTo.js"></script>

<script type="text/javascript">
	jQuery.event.special.touchstart = {
		setup: function( _, ns, handle ){
			if ( ns.includes("noPreventDefault") ) {
				this.addEventListener("touchstart", handle, { passive: false });
			} else {
				this.addEventListener("touchstart", handle, { passive: true });
			}
		}
	};
	loadCSS = function(href) {
        $.ajax({
            url: href,
            dataType: 'text',
            success: function(data) {
                $('<style type="text/css">\n' + data + '</style>').appendTo( 'head' );                    
            }                  
        });
    };
    window.onload = function(e){ 
    	$('.menuItem').click( function(event) {
    		event.preventDefault();
    		var optM = $(this).attr("href");
    		$.post("./views/"+optM+"/"+optM).done(function( data ){$('#contentBody').html(data)});
    	});

		$('#home, .treeview-menu > li > a').click( function(event) {
			event.preventDefault();
			$('#home, .treeview-menu > li > a').parent().removeClass('active');
			$('.treeview-menu > li > a').parent().parent().parent().removeClass('active');

			$(this).parent().addClass("active");
			$(this).parent().parent().parent().addClass("active");
			$('#menuTreeP').text( $(this).parent().parent().parent().children('a').text() ).show();
			$('#menuTreeS').text($(this).text()).show();
		});
		
	}
</script>
    
</body>
</html>
