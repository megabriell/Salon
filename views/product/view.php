<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Prodcutos registrados</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Nuevo Registro" onclick="add_2()" id="btn_21">
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
        <table id="dataTable2" class="table table-bordered table-hover" width="100%" style="display: none;">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Descripción</td>
                    <td>Categoria</td>
                    <td>Proveedor</td>
                    <td>Costo</td>
                    <td>Precio</td>
                    <td>Stock</td>
                    <td>Estado</td>
                    <td></td>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script type="text/javascript">
    var datacol = new Array('./controllers/product_controller.php',
        [
            {'data':'ID'},
            {'data':'Col1'},
            {'data':'Col2'},
            {'data':'Col3'},
            {'data':'Col4'},
            {'data':'Col5'},
            {'data':'Col6'},
            {'data':'Col7'},
            {'data':'btns'}
        ],
        '',
        {getData:''}
    );
    tableSimple('#dataTable2',datacol,[true,true,25],'',false);

    function edit_2(id){
        $.post("./views/product/edit.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }

    function add_2(){
        $.post("./views/product/new.php?").done(function( data ){$('#subContent').html(data)});
    }

    function disable_2(id,opt){
        $.confirm({
            title: '&#161;Advertencia!',
            type: (opt)? false : 'orange',
            content: (opt)?'Realmenete desea activar el registro. ¿Desea continuar?':'Al desactivar el registro, ya no podra utilizarse. ¿Desea continuar?',
            buttons: {
                SI: function () {
                    $.ajax({
                        type: "POST",
                        data:  (opt)?{id:id,enable:''} : {id:id,disable:''},
                        url: "./controllers/product_controller.php",
                        success: function(respuesta){
                            respuesta;
                            $('#dataTable2').DataTable().ajax.reload( null, false );
                        }
                    }); 
                },
                Cancelar: function () {
                }
            }
        });
    };
</script>
