function edit(id){
	$.post("./views/user/edit.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
}

function add(){
	$.post("./views/user/new.php?").done(function( data ){$('#subContent').html(data)});
}

/*function frmEdit(){
	$.post("./views/user/edit.php?",{frm:id}).done(function( data ){$('#subContent').html(data);});
}*/

function disable(id){
	$.confirm({
	    title: '&#161;Advertencia!',
	    type: 'orange',
	    content: 'Al desactivar al usuario, este ya no tendrá acceso al sistema. ¿Desea continuar?',
	    buttons: {
	        SI: function () {
	        	$.ajax({
					type: "POST",
					data:  {id:id,disable:''},
					url: "./controllers/users_controller.php",
					success: function(respuesta){
						respuesta;
						$('#tableUser').DataTable().ajax.reload( null, false );
					}
				});	
	        },
	        Cancelar: function () {
	        }
	    }
	});
};

function enable(id){
	$.confirm({
	    title: '&#161;Advertencia!',
	    content: 'Si activa al usuario le estará dando acceso al sistema. ¿Desea continuar?',
	    buttons: {
	        SI: function () {
	        	$.ajax({
					type: "POST",
					data:  {id:id,enable:''},
					url: "./controllers/users_controller.php",
					success: function(respuesta){
						respuesta;
						$('#tableUser').DataTable().ajax.reload( null, false );
					}
				});	
	        },
	        Cancelar: function () {
	        }
	    }
	});
};