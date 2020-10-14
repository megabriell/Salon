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
    include_once dirname(__file__,3).'/models/user.php';
    $report = new Reports();
    $data0 = $report->report3();

    $users = new User();
    if ($data0) {
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                Los 10 clientes menos frecuentes
            </div>
            <div class="box-body" id="box_body">
                <table id="dataTable0" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Cliente</td>
                            <td>Teléfono</td>
                            <td>Correo</td>
                            <td data-orderable="true">Visitas</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data0 as $key => $value) {
                            $data1 = $users->getEmployeeById($value->Id_Cliente);

                            echo "<tr>
                                <td>".$value->Id_Cliente."</td>
                                <td>".$data1->Nombre.' '.$data1->Apellido."</td>
                                <td>".$data1->Telefono."</td>
                                <td>".$data1->CorreoP."</td>
                                <td>".$value->Veces."</td>
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
    Tabla_Simple('#dataTable0','',[false,false,false,false],true,'Clientes mas frecuentes');
</script>

<?php
}
?>