
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Tipos de pagos registrados</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Nuevo Registro" onclick="add()" id="btn_11">
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
                    <td>Descuento</td>
                    <td></td>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="subContent"></div>

<script type="text/javascript">
	var datacol = new Array('./controllers/tpay_controller.php',
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

    function edit(id){
        $.post("./views/tpay/edit.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }

    function add(){
        $.post("./views/tpay/new.php?").done(function( data ){$('#subContent').html(data)});
    }

    function deleteP(id,opt){
        $.confirm({
            title: '&#161;Advertencia!',
            type: 'red',
            content: 'Realmenete desea eliminar el registro. ¿Desea continuar?',
            buttons: {
                SI: function () {
                    $.ajax({
                        type: "POST",
                        data:  {id:id,delete:''},
                        url: "./controllers/tpay_controller.php",
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
