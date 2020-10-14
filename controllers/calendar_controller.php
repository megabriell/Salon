<?php
/**
 * 
 * Controlador para la clase Calendar
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/
	include_once dirname(__file__,2).'/models/calendar.php';
	include_once dirname(__file__,2).'/models/service.php';
	include_once dirname(__file__,2).'/models/user.php';
	$calendar = new Calendar();

	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark
	$meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Nomviembre', 'Diciembre'  );
	$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
	$btnOk = '';
	$infoUser = json_decode( $_COOKIE["_data0U"],true);
	session_start();
	switch ($infoUser['sistema']) {
	    case 1:
	        $page = "calendar1";
	        break;
	    case 2:
	        $page = "calendar2";
	        break;
	    case 3:
	        $page = "calendar3";
	        break;
	}


	if(isset($_POST['create']))//Agendar nueva cita
	{
		$_POST['user'] = $_SESSION['Id_Empleado'];

		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($calendar->validData($_POST)){
			$contentMessage = 'El registro se ha creado correctamente';
			$typeMessage = $calendar->type;
				$btnOk = '$.post(\'./views/'.$page.'/view\').done(function(data){$(\'#contentBody\').html(data)})';
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

	if(isset($_POST['createOp2']))//Agendar nueva cita
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($calendar->validData($_POST)){
			$contentMessage = 'El registro se ha creado correctamente';
			$typeMessage = $calendar->type;
				$btnOk = '$.post(\'./views/'.$page.'/view\').done(function(data){$(\'#contentBody\').html(data)})';
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

	if(isset($_POST['edit']))//Editar Cita
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($calendar->validData($_POST,'edit')){
			$contentMessage = 'El registro se ha modificado correctamente';
			$typeMessage = $calendar->type;
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



	if(isset($_POST['cancel']))//Cancela la cita
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		//options = 0-pendiente|1-Pospuesto|2-completado|3-Cancelado
		if( $calendar->changeState($_POST['id'],3) ){//Change state of event vars( id , option)
			$contentMessage = 'El registro se ha cancelado correctamente. Puede agendar otra cita si lo desea.';
			$typeMessage = $calendar->type;
				$btnOk = '$.post(\'./views/'.$page.'/view\').done(function(data){$(\'#contentBody\').html(data)})';
				echo "$('#events-modal').modal('hide');";//oculta el modal 
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


	if(isset($_POST['completed']))//Dar por complado la cita
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		//options = 0-pendiente|1-Pospuesto|2-completado|3-Cancelado
		if( $calendar->changeState($_POST['id'],2) ){//Change state of event vars( id , option)
			$contentMessage = 'La cita se ha finalizado correctamente.';
			$typeMessage = $calendar->type;
				$btnOk = '$.post(\'./views/'.$page.'/view\').done(function(data){$(\'#contentBody\').html(data)})';
				echo "$('#events-modal').modal('hide');";//oculta el modal 
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


	if(isset($_GET['service']))//Otiene informacion del servicio {Descripcion, Duracion(Tiempo)}
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


	if(isset($_GET['validHour']))//Valida que la hora selecciona no este ocupada
	{
		header('Content-Type: application/json');
		$id = $_GET['id'];
		$date = DateTime::createFromFormat("d/m/Y", $_GET['date'])->format('Y-m-d');
		$time = formatDateTime($_GET['dataTime'],'H:i:s');
		$compare = strtotime($date.' '.$time);
		if (empty($id) || empty($date)) {
			$result = false;
			$mesage = 'Debe completar todos los campos';
		}else{
			$rows = $calendar->getCByDatesS( $id, $date );
		    if ($rows) {
		    	foreach ($rows as $key => $value) {

		    		$newTime = sumMDate($value->Fecha,$value->Duracion);
		    		$startTime = strtotime($value->Fecha);
		    		$endTime = strtotime($newTime);

		    		if(($compare >= $startTime) && ($compare <= $endTime)){
		    			$result = false; //Hora seleccionada dentro de rango de tiempo
		    			$mesage = 'Ya se tiene programada una cita en este horario. <br>Duración de la cita: '.formatDateTime($value->Fecha, 'g:i A'). ' a '. formatDateTime($newTime, 'g:i A').'<br>Por favor selecciones otro horario';
		    			break;
		    		}else{
		    			$result = true;//Hora seleccionada fuera de rango de tiempo
		    			$mesage = '';
		    		}

			    }
		    }else{
		    	$result = true;
		    	$mesage = '';
		    }
		}
		echo json_encode(array('valid' => $result, 'message'=>$mesage));
	}

	if( isset($_GET['complet']) )//Devuelve todos los registros filtros por cliente
	{	
		header("content-type: application/json");//tipo de respuesta devuelta: Json
		$rows = $calendar->getAllCalendar();
	    if ($rows) {
	    	$out = array();
	    	foreach ($rows as $key => $value) {
	    		$duration = $value->Duracion;
	    		$date = $value->Fecha;
		    	$timeTo = sumMDate($date,$duration);

			    $out[] = array(
			        'id' => $value->Id_Agenda,
			        'title' => $value->Servicio,
			        'url' => './controllers/calendar_controller.php?id_event='.$value->Id_Agenda,
			        "class"=> stateColorVar5($value->Estado),
			        'start' => strtotime($date) . '000',//<-Esta propiedad debe ser devuelta. Requisito!
			        'end' => strtotime($timeTo) .'000',//<-Esta propiedad debe ser devuelta. Requisito!
			        'startTime' => formatDateTime($date,'H:i'),
			        'endTime' => formatDateTime($timeTo,'H:i')
			    );
	    	}
	    	echo json_encode( array("success" => 1, "result" => $out) );
		}else{
			//echo json_encode( array("success" => 0, "error" => 'No ha datos para mostrar') );
			echo "No hay datos";
		}
	}
	elseif( isset($_GET['from']) && isset($_GET['to']) ){//Devuelve todos los registros filtros por cliente
		$_SESSION['Id_Empleado'];//get id of Session

		header("content-type: application/json");//tipo de respuesta devuelta: Json
		$rows = $calendar->getCalendarByUser($_SESSION['Id_Empleado'],$infoUser['sistema']);
	    if ($rows) {
	    	$out = array();
	    	foreach ($rows as $key => $value) {
	    		$duration = $value->Duracion;
	    		$date = $value->Fecha;
		    	$timeTo = sumMDate($date,$duration);

			    $out[] = array(
			        'id' => $value->Id_Agenda,
			        'title' => $value->Servicio,
			        'url' => './controllers/calendar_controller.php?id_event='.$value->Id_Agenda,
			        "class"=> stateColorVar5($value->Estado),
			        'start' => strtotime($date) . '000',//<-Esta propiedad debe ser devuelta. Requisito!
			        'end' => strtotime($timeTo) .'000',//<-Esta propiedad debe ser devuelta. Requisito!
			        'startTime' => formatDateTime($date,'H:i'),
			        'endTime' => formatDateTime($timeTo,'H:i')
			    );
	    	}
	    	echo json_encode( array("success" => 1, "result" => $out) );
		}else{
			//echo json_encode( array("success" => 0, "error" => 'No ha datos para mostrar') );
			echo "No hay datos";
		}
	}


	if ( isset($_POST['getData']) ) { //Devuelve todo los registros de la base de datos
		header('Content-Type: application/json');
		$arrayUs = [];

		$clients = new User();
		$rowUs = $clients->getTypeUsers();

		if ($rowUs) {
			foreach ($rowUs as $key => $value) {
				$arrayUs[$value->Id_Usuario] =  $value->Nombre.' '.$value->Apellido;
			}

		    $rows = $calendar->getCalendars($_SESSION['Id_Empleado'],$infoUser['sistema']);
		    $json['data']=[];
		    if ($rows) {
		        foreach ( $rows as $row ){
		            $id = $row->Id_Agenda;
		            $date = $row->Fecha;
		            $duration = $row->Duracion;
		            $state = $row->Estado;
		            $newDate = sumMDate($date, $duration);
		            $btnEdit = '';
		            $bnt0 = '<button type="button" class="btn btn-default btn-xs" title="ver registro" onclick="viewDate(\''.$id.'\')" id="btn2"> <i class="fa fa-eye"></i> Ver</button>';

		            if ($infoUser['sistema'] == 1) {
		            	$btnEdit = '<button type="button" class="btn btn-primary btn-xs" title="Editar registro" onclick="edit(\''.$id.'\')" id="btn2"> <i class="fa fa-edit"></i> Editar</button>';
		            }

		            $json['data'][] = [
		                'ID'=>$id,
		                'Col1'=>$row->Servicio,
		                'Col2'=>$arrayUs[$row->Id_Cliente],
		                'Col3'=>$arrayUs[$row->Id_Estilista],
		                'Col4'=> formatDateTime($date,'d/m/Y H:i A'),
		                'Col5'=>formatDateTime($newDate,'d/m/Y H:i A'),
		                'Col6'=>[
		                	'display' => '<span style="position: absolute;padding: 5px;color:'.textColor($state).';text-transform: capitalize;font-weight: bold;">'
		                		.stateVar5($state).'</span>',
		                	'order'=>$state
		                ],
		                'btns'=>$bnt0.$btnEdit
		            ];
		        }
		        echo json_encode($json);
		    }else{
		        echo json_encode($json);
		    }
		}
	}



	if( isset($_GET['id_event']) )//obtinen toda la informacion relevante del cita
	{	
		header("content-type: text/html");//tipo de respuesta devuelta: html
		$row = $calendar->getCalendarByEvent($_GET['id_event']);
	    if ($row) {

	    	$id = $row->Id_Agenda;
	    	$service = $row->Servicio;
	    	$stylist = $row->Estilista;
	    	$date = $row->Fecha;
	    	$state = $row->Estado;
	    	$duration = $row->Duracion;
	    	$commrnt = $row->Comentario;

	    	$newTime = sumMDate($date,$duration);
	    	$timeFrom = formatDateTime($date,'H:i A');
	    	$timeTo = formatDateTime($newTime,'H:i A');

	    	$year = formatDateTime($date,'Y');
	    	$day = formatDateTime($date,'d');
	    	$noDay = formatDateTime($date,'w');//get number day from week 0-6
	    	$noMonth = formatDateTime($date,'n');//get number from month 1-12
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
	    					<div>
		    					<span style="position: absolute;padding: 5px;color:<?php echo textColor($state) ?>;text-transform: capitalize;font-weight: bold;">
		    						evento <?php echo stateVar5($state) ?>
		    					</span>
		    				</div>
		    				<?php
		    				if ($state == 0) { //Si la cita esta pendiente mostra boton cancelar
		    					if ($infoUser['sistema'] == 3) {
		    				?>
			    					<div class="box-footer">
			    						<a href="#" class="btn btn-danger btn-sm" onclick="cancel(<?php echo $id?>)" title="Cancelar cita">
			    						Cancelar</a>
			    					</div>
	    					<?php
	    						}elseif ($infoUser['sistema'] == 2) {
	    					?>
			    					<div class="box-footer">
			    						<a href="#" class="btn btn-success btn-sm" onclick="completed(<?php echo $id?>)" title="Finalizar cita">Finalizar</a>
			    					</div>
	    					<?php
	    						}
	    					}
		    				?>
	    				</section>
	    			</article>
	    		</div>
	    	<?php
		}else{
			echo "No hay datos";
		}
	}
?>