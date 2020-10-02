function edit(id){
	$.post("./views/service/edit.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
}

function add(){
	$.post("./views/service/new.php?").done(function( data ){$('#subContent').html(data)});
}

function disable(id,opt){
    $.confirm({
        title: '&#161;Advertencia!',
        type: (opt)? false : 'orange',
        content: (opt)?'Realmenete desea activar el registro. ¿Desea continuar?':'Al desactivar el registro, ya no podra utilizarse. ¿Desea continuar?',
        buttons: {
            SI: function () {
                $.ajax({
                    type: "POST",
                    data:  (opt)?{id:id,enable:''} : {id:id,disable:''},
                    url: "./controllers/service_controller.php",
                    success: function(respuesta){
                        respuesta;
                        $('#dataTable0').DataTable().ajax.reload( null, false );
                    }
                }); 
            },
            Cancelar: function () {
            }
        }
    });
};