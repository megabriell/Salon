<?php
	
	include_once dirname(__file__,2).'/models/calendar.php';
	include_once dirname(__file__,2).'/models/service.php';
	$calendar = new Calendar();

	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark
	$btnOk = '';


	if(isset($_POST['create']))
	{
		session_start();
		$_POST['user'] = $_SESSION['Id_Empleado'];

		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($calendar->validData($_POST)){
			$contentMessage = 'El registro se ha creado correctamente';
			$typeMessage = $calendar->type;
				$btnOk = '$.post(\'./views/date/date\').done(function(data){$(\'#contentBody\').html(data)})';
				echo $_POST['modal'].".modal('hide');";//oculta el modal 
		}else{
			if (!empty($calendar->message)) {
				$contentMessage = $calendar->message;
				$typeMessage = $calendar->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($calendar->time)? "autoClose: 'Ok|10000'," : '';
		echo "$.alert({
			title: false,
			content: '".$contentMessage."',
			".$timeMessage."
			type: '".$typeMessage."',
			typeAnimated: true,
			buttons: {
				Ok: function(){".$btnOk."}
			}
		});";
	}

	if(isset($_GET['service']))
	{
		header('Content-Type: application/json');
		$service = new Service();
	    $rows = $service->getServiceById($_GET['service']);
	    $json=[];
	    if ($rows) {
	    	$json = [
	    		//'ID' => $rows->Id_Servicio,
	    		'Descripcion' => $rows->Descripcion,
	    		//'Precio' => $rows->Precio,
	    		//'Costo' => $rows->Costo,
	    		'Duracion' => formatHM($rows->Duracion)//,
	    		//'Estado' => $rows->Estado
	    	];
	    	echo json_encode($json);
	    }else{
	        echo json_encode($json);
	    }
		
	}

	if( isset($_GET['from']) && isset($_GET['to']) )
	{	
		session_start();
		$_SESSION['Id_Empleado'];

		header("content-type: application/json");//tipo de respuesta devuelta: Json
		$rows = $calendar->getCalendarByUser($_SESSION['Id_Empleado']);
	    if ($rows) {
	    	$out = array();
	    	foreach ($rows as $key => $value) {
			    $out[] = array(
			        'id' => $value->Id_Agenda,
			        'title' => $value->Servicio,
			        'url' => './controllers/calendar_controller.php?id_event='.$value->Id_Agenda,
			        "class"=> stateColorVar5($value->Estado),
			        'start' => strtotime($value->Fecha) . '000',
			        'end' => strtotime($value->Fecha) .'000'
			    );
	    	}
	    	echo json_encode( array("success" => 1, "result" => $out) );
		}else{
			
			//echo json_encode( array("success" => 0, "error" => 'No ha datos para mostrar') );
			echo "No hay datos";
		}
	}

	if( isset($_GET['id_event']) )
	{	
		//header("content-type: text/html");//tipo de respuesta devuelta: html
		$row = $calendar->getCalendarByEvent($_GET['id_event']);
	    if ($row) {
	    	$meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nomviembre', 'Diciembre'  );
	    	$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');

	    	$id = $row->Id_Agenda;
	    	$service = $row->Servicio;
	    	$stylist = $row->Estilista;
	    	$date = $row->Fecha;
	    	$state = $row->Estado;
	    	$duration = $row->Duracion;
	    	$commrnt = $row->Comentario;

	    	$times = explode(":", $duration);
	    	$addMinutes = ( ($times[0]*60)+ ($times[1]*1) );
	    	$time = new DateTime($date);
	    	$timeFrom = $time->format('H:i A');
	    	$time->add(new DateInterval('PT' . $addMinutes . 'M'));
	    	$timeTo = $time->format('H:i A');

	    	$timestamp = strtotime($date);
	    	$year = date('Y', $timestamp);
	    	$day = date('d', $timestamp);
	    		$noDay = date('w', $timestamp);
	    	$noMonth = date('n', $timestamp);
	    		$month = $meses[($noMonth-1)];
	    	$dateFull = $dias[($noDay)]. ' '.$day.' de '.$meses[($noMonth-1)].' '.$year;
	    	?>
	    	<section class="container">
	    		<div class="row">
	    			<article class="card fl-left">
	    				<section class="dateCard">
	    					<time datetime="<?php echo date('jS M', $timestamp) ?>">
	    						<span><?php echo $day ?></span><span><?php echo $month ?></span>
	    					</time>
	    				</section>
	    				<section class="card-cont">
	    					<small><?php echo $stylist ?></small>
	    					<h3><?php echo $service ?></h3>
	    					<div class="even-date">
	    						<i class="fa fa-calendar"></i>
	    						<time>
	    							<span> <?php echo $dateFull ?></span>
	    							<span> <?php echo $timeFrom.' A '.$timeTo ?></span>
	    						</time>
	    					</div>
	    					<div class="even-info">
	    						<i class="fa fa-commenting-o"></i>
	    						<p>
	    							<?php echo $commrnt?>
	    						</p>
	    					</div>
	    					<div class="box-footer">
	    						<a href="#" class="btn btn-danger btn-sm">Cancelar</a>
	    					</div>
	    				</section>
	    			</article>
	    		</div>
	    	<?php
		}else{
			
			echo "No hay datos";
		}
	}
?>