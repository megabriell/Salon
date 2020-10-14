    var datacol = new Array('./controllers/reserve_controller.php',
        [
            {'data':'ID'},
            {'data':'Col1'},
            {'data':'Col2'},
            {'data':'Col3'},
            {'data':{
                    '_': "Col4.display",
                    'sort': "Col4.order"
                }
            },
            {'data':'Col5'},
            {'data':'btns'}
        ],
        '',
        {getData:''}
    );
    tableSimple('#dataTable0',datacol,[true,true,25],'',false);
    
    function add(id){
        $.post("./views/reserve/new.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }

    function cancel(id){
        $.confirm({
            title: '&#161;Advertencia!',
            type: 'danger',
            content: '¿Realmenete desea cancelar la reserva del producto?.',
            buttons: {
                SI: function () {
                    $.ajax({
                        type: "POST",
                        data:  {id:id,canceled:''},
                        url: "./controllers/reserve_controller.php",
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

    function complete(id){
        $.confirm({
            title: '&#161;Advertencia!',
            type: 'orange',
            content: '¿Quiere dar por finalizado(Facturado) la reserva de producto?.',
            buttons: {
                SI: function () {
                    $.ajax({
                        type: "POST",
                        data:  {id:id,completed:''},
                        url: "./controllers/reserve_controller.php",
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