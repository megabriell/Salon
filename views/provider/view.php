<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Proveedores registrados</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Nuevo Registro" onclick="add_0()" id="btn_01">
                <i class="fa fa-plus"></i> Agregar
            </button>
        </div>
    </div>
    <div class="box-body" id="box_body">
        <div class="circle_small center-block" align="center" id="circleLoading">
            Cargando...
            <div class="loader_small">
                <div class="loader_small">
                    <div class="loader_small">
                        <div class="loader_small">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table id="dataTable0" class="table table-bordered table-hover" width="100%" style="display: none;">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Descripción</td>
                    <td>Estado</td>
                    <td></td>
                </tr>
            </thead>
        </table>
    </div>
</div>


<script type="text/javascript">
    var datacol = new Array('./controllers/provider_controller.php',
        [
            {'data':'ID'},
			{'data':'Col1'},
			{'data':'Col2'},
			{'data':'btns'}
        ],
        '',
        {getData:''}
    );
    tableSimple('#dataTable0',datacol,[true,true,25],'',false);

    function edit_0(id){
        $.post("./views/provider/edit.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }

    function add_0(){
        $.post("./views/provider/new.php?").done(function( data ){$('#subContent').html(data)});
    }

    function disable_0(id,opt){
        $.confirm({
            title: '&#161;Advertencia!',
            type: (opt)? false : 'orange',
            content: (opt)?'Realmenete desea activar el registro. ¿Desea continuar?':'Al desactivar el registro, ya no podra utilizarse. ¿Desea continuar?',
            buttons: {
                SI: function () {
                    $.ajax({
                        type: "POST",
                        data:  (opt)?{id:id,enable:''} : {id:id,disable:''},
                        url: "./controllers/provider_controller.php",
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
</script>
