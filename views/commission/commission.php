<?php include_once dirname(__file__,3)."/config/session.php";
$infoUser = json_decode( $_COOKIE["_data0U"],true); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Comision del mes actual</h3>
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
                            <td>Factura</td>
                            <td>Cliente</td>
                            <td>Fecha</td>
                            <td>Facturado</td>
                            <td>Tipo Pago</td>
                            <td>Propina</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="5" class='text-right'>Total Q</th>
                            <th class='text-right' id="total"></th>
                            <th></th>
                        </tr>
                          <tr>
                            <th colspan="5" class='text-right'>Salario Q</th>
                            <th class='text-right'><?php echo $infoUser['Salario']?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="subContent"></div>

<script type="text/javascript">
    var datacol = new Array('./controllers/commission_controller.php',
        [
            {'data':'ID'},
            {'data':'Col1'},
            {'data':{
                    '_': "Col2.display",
                    'sort': "Col2.order"
                }
            },
            {'data':'Col3'},
            {'data':'Col4'},
            {'data':'Col5'},
            {'data':'btns'}
        ],
        '',
        {getData:''}
    );
    tableSimple('#dataTable0',datacol,[true,true,25],[5,'#total',''],false);

    function view(id){
        $.post("./views/invoice/view.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }
</script>
