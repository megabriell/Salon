<?php
	include_once dirname(__file__,2).'/models/config.php';
	$config = new Configuration();
	$contentMessage = NULL;
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark

	$infoCompany = json_decode( $_COOKIE["_data1C"] ,true);//COOKIE
		

	//Request: get image
	if(isset($_POST['getImg']))
	{
		header('Content-Type: application/json');
		$json=[];

		if( !empty($infoCompany['imgPrincipal']) ){
			$json['initialPreview'][0] = [
				"<img src='/misc/img/sistema/".$infoCompany['imgPrincipal']."' class='img-responsive alt='logo' title='logo'>"
			];
			$json['initialPreviewConfig'][0] = [
				'caption'=>$infoCompany['imgPrincipal'], 
		        'url'=> 'controllers/config_controller.php',
		        'key'=> 0,
		        'extra'=> ['delete' => '']
			];
			$json['btndisable'][0] = false;
		}else{
			$json['initialPreview'][0] = '';
			$json['initialPreviewConfig'][0] = '';
			$json['btndisable'][0] = true;
		}

		if( !empty($infoCompany['imgSegundaria']) ){
			$json['initialPreview'][1] = [
				"<img src='/misc/img/sistema/".$infoCompany['imgSegundaria']."' class='img-responsive alt='logo' title='logo'>"
			];
			$json['initialPreviewConfig'][1] = [
				'caption'=>$infoCompany['imgSegundaria'], 
		        'url'=> 'controllers/config_controller.php',
		        'key'=> 1,
		        'extra'=> ['delete' => '']
			];
			$json['btndisable'][1] = false;
		}else{
			$json['initialPreview'][1] = '';
			$json['initialPreviewConfig'][1] = '';
			$json['btndisable'][1] = true;
		}

		if( !empty($infoCompany['favicon']) ){
			$json['initialPreview'][2] = [
				"<img src='/misc/img/sistema/".$infoCompany['favicon']."' class='img-responsive alt='favicon' title='favicon'>"
			];
			$json['initialPreviewConfig'][2] = [
				'caption'=>$infoCompany['favicon'], 
		        'url'=> 'controllers/config_controller.php',
		        'key'=> 2,
		        'extra'=> ['delete' => '']
			];
			$json['btndisable'][2] = false;
		}else{
			$json['initialPreview'][2] = '';
			$json['initialPreviewConfig'][2] = '';
			$json['btndisable'][2] = true;
		}
		echo json_encode($json);
	}


	//Request: add new image
	if(isset($_POST['uploadFile']))
	{	
		header('Content-Type: application/json');
		if( !$config->addImg($_FILES, $infoCompany['IdEmpresa']) ){
			$contentMessage = $config->message;
		}
		$json = [
			'error' => $contentMessage,
			'initialPreview' => $config->extra['Preview'],
			'initialPreviewConfig' => $config->extra['PreviewConfig'],
			'initialPreviewAsData' => false
			//,'append' => true
	    ];
	    echo json_encode($json);	
	}


	//Request: delete image
	if(isset($_POST['delete'])){
		header('Content-Type: application/json');

		switch ($_POST['key']) {
			case 0:
				$img = $infoCompany['imgPrincipal'];
				break;
			case 1:
				$img = $infoCompany['imgSegundaria'];
				break;
			case 2:
				$img = $infoCompany['favicon'];
				break;
			default:
				$img = NULL;
				break;
		}
		if( !$config->deleteImg($img, $infoCompany['IdEmpresa'], $_POST['key']) ){
			$contentMessage = $config->message;
		}
		$json = [
			'error' => $contentMessage,
			'append' => false
	    ];
	    echo json_encode($json);
	}

	//Request: get information of input
	if(isset($_POST['getInf']))
	{	
		header('Content-Type: application/json');

		$json = [];
		if( $config->getCompany($infoCompany['IdEmpresa']) ){
			$json = $config->extra;
			$json[] = $infoCompany['IdEmpresa'];
		}
		echo json_encode($json);
	}

	if(isset($_POST['update']))
	{
		header('Content-Type: application/javascript');
		if($config->validData($_POST)){
			$contentMessage = 'La imformación se ha actualizado correctamente. Debe refrescar la página para ver los cambios.';
			$typeMessage = $config->type;
		}else{
			if (!empty($config->message)) {
				$contentMessage = $config->message;
				$typeMessage = $config->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($config->time)? "autoClose: 'Ok|10000'," : '';

		echo "$.alert({
			title: false,
			content: '".$contentMessage."',
			".$timeMessage."
			type: '".$typeMessage."',
			typeAnimated: true,
			buttons: {
				Ok: function () {}
				}
		});";
	}
?>