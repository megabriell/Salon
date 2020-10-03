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
		$rows = $calendar->getCalendar($_SESSION['Id_Empleado']);
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
?>