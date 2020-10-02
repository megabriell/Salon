
//Funcion simple para imprimir una seccion en espesifica, basada en el srcipt --- printThis

//Esta funcion es complementada con css perzonalizada --- del archivo --- complement_to_PrintThis_welmaster.css
//Es importante espesificar la ruta de los archivos de estilos en el parametro --- base
//para poder importar los estilos a la impresion. De no hacerlo la impresion no tendra estilo

function imprimir_seccion(Id_Selector) {
	$(Id_Selector).printThis({
		importCSS: false,
		importStyle: true,
		loadCSS: ["bootstrap/css/bootstrap.min.css","bootstrap/css/complement_to_PrintThis_welmaster.css"],
		base:"/system-asahi/style/",
		canvas: true
	});
}