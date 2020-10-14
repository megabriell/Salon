<script src="./plugins/datatables/js/reports/dataTables.buttons.min.js"></script>
<script src="./plugins/datatables/js/reports/buttons.bootstrap.min.js"></script>
<script src="./plugins/datatables/js/reports/jszip.min.js"></script>
<script src="./plugins/datatables/js/reports/pdfmake.min.js"></script>
<script src="./plugins/datatables/js/reports/vfs_fonts.js"></script>
<script src="./plugins/datatables/js/reports/buttons.html5.min.js"></script>
<script src="./plugins/datatables/js/reports/buttons.print.min.js"></script>


<?php
    include_once dirname(__file__,3)."/config/session.php";
    include_once dirname(__file__,3).'/models/reports.php';
    include_once dirname(__file__,3).'/models/product.php';
    include_once dirname(__file__,3).'/models/service.php';
    $report = new Reports();
    $data0 = $report->report0();

    $products = new Product();
    $data1 = $products->getProducts();
    $arrayP = [];
    if ($data1) {
        foreach ($data1 as $key => $value) {
            $arrayP[$value->Id_Producto] = $value->Descripcion .' - '.$value->Categoria;
        }
    }

    $services = new Service();
    $data2 = $services->getServices();
    $arrayS = [];
    if ($data2) {
        foreach ($data2 as $key => $value) {
            $arrayS[$value->Id_Servicio] = $value->Descripcion;
        }
    }

    if ($data0) {
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                Los 10 productos mas vendidos
            </div>
            <div class="box-body" id="box_body">
                <table id="dataTable0" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Articulo</td>
                            <td>Descripción</td>
                            <td>Cantidad</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data0 as $key => $value) {
                            if ($value->Tipo_Articulo == 2) {
                                $desc = $arrayS[$value->Id_Articulo];
                            }elseif ($value->Tipo_Articulo == 1) {
                                $desc = $arrayP[$value->Id_Articulo];
                            }

                            echo "<tr>
                                <td>".$value->Id_Articulo."</td>
                                <td>".itemVar2($value->Tipo_Articulo)."</td>
                                <td>".$desc."</td>
                                <td>".$value->Ventas."</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="subContent"></div>

<script type="text/javascript">
    Tabla_Simple('#dataTable0','',[false,false,false,false],true,'productos mas vendido');
</script>

<?php
}
?>