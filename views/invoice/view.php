<?php
    include_once dirname(__file__,3).'/models/tpay.php';
    include_once dirname(__file__,3).'/models/user.php';
    include_once dirname(__file__,3).'/models/invoice.php';
    include_once dirname(__file__,3).'/models/product.php';
    include_once dirname(__file__,3).'/models/service.php';
    $invoice = new Invoice();

    $id = isset($_POST['id'])? $_POST['id'] : null;
    $data = $invoice->getInvoiceById($id);
    $data2 = $invoice->getItemsById($id);

    if ($data && $data2) {
        $infoCompany = json_decode( $_COOKIE["_data1C"],true);
        $idInv = $data->Id_Enca_Factura;
        $pago = $data->Id_Tipo_Pago;
        $cliente = $data->Id_cliente;
        $fecha = $data->Fecha;
        $total = $data->Total;
        $propina = $data->Propina;
        $lDescuento = ( !empty($data->Descuento))?$data->Descuento:0;
        $descuento = ( !empty($data->Descuento))?explode("%", $data->Descuento):0;
        $comentario = $data->Comentario;

        $pay = new TPay();
        $row0 = $pay->getTPayById($pago);
        $label0 = $row0->Descripcion;

        $client = new User();
        $row1 = $client->getUserById($cliente);
        $label1 = $row1->Nombre.' '.$row1->Apellido;
        $label11 = (!empty($row1->Direccion))?$row1->Direccion:'No indica';
        $label12 = (!empty($row1->Telefono))?$row1->Telefono:'No indica';
        $label13 = (!empty($row1->NIT))?$row1->NIT:'No indica';


        $products = new Product();
        $labe2 = $products->getProducts();
        $arrayP = [];
        if ($labe2) {
            foreach ($labe2 as $key => $value) {
                $arrayP[$value->Id_Producto] = $value->Descripcion .' - '.$value->Categoria;
            }
        }

        $services = new Service();
        $label3 = $services->getServices();
        $arrayS = [];
        if ($label3) {
            foreach ($label3 as $key => $value) {
                $arrayS[$value->Id_Servicio] = $value->Descripcion;
            }
        }

?>
<div class="modal" tabindex="-1" id="modal1" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <section class="invoice" id="section_to_print">
                    <div class="row">
                        <div class="col-xs-12" align="center">
                            <h2>
                            <img src="./misc/img/sistema/<?php echo $infoCompany['imgSegundaria'] ?>" width="30" style="vertical-align: inherit;filter: grayscale(100%)">
                            <?php echo $infoCompany['Empresa'] ?>
                            </h2>
                        </div>

                        <div class="col-xs-6 invoice-col">
                            <strong>Cliente #<?php echo $cliente ?></strong>
                            <address>
                            <?php echo $label1 ?><br>
                            Direccion: <?php echo $label11 ?><br>
                            Telefono: <?php echo $label12 ?><br>
                            NIT: <?php echo $label13 ?>
                            </address>
                        </div>

                        <div class="col-xs-6 invoice-col">
                            <b>Factura #<?php echo $idInv ?></b><br>
                            Fecha de emision: <?php echo formatDateTime($fecha,'d/m/Y') ?><br>
                            Tipo de Pago: <?php echo $label0 ?><br>
                            Descuento: <?php echo $lDescuento ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <table id="dataTable2" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>Tipo</th>
                                        <th>Articulo</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>subtotal</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class='text-right'>Descuento</th>
                                        <th class='text-right' id="discount">
                                            <?php echo (($total*$descuento[0])/100)?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class='text-right'>Propina</th>
                                        <th class='text-right' id="reward">
                                            <?php echo $propina?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class='text-right'>Total</th>
                                        <th class='text-right' id="total"></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        foreach ($data2 as $key => $value) {
                                            $item = '';
                                            $inv = $value->Id_Enca_Factura;
                                            $tItem = $value->Tipo_Articulo;
                                            $dItem = $value->Id_Articulo;
                                            $price = $value->Precio;
                                            $quantity = $value->Cantidad;
                                            $sub = ( ($price*1)*($quantity*1));
                                            
                                            if ($tItem == 2) {
                                                $item = $arrayS[$dItem];
                                            }elseif ($tItem == 1) {
                                                $item = $arrayP[$dItem];
                                            }

                                            echo "<tr>
                                            <td>".itemVar2($tItem)."</td>
                                            <td>".$item."</td>
                                            <td>".$quantity."</td>
                                            <td>".$price."</td>
                                            <td class='text-xs-right'>".$sub."</td>
                                            </tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row notdisplay">
                        <div class="col-sm-12 invoice-col">
                            <b>Comentario:</b><br>
                            <?php echo $comentario ?>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_print">Imprimir</button>
            </div>
        </div>
    </div>
</div>

<script>
    $.getScript("./views/invoice/js/script2.js");
    $.getScript("./plugins/printThis-master/printThis.js").done(function(script, textStatus){
        $('#btn_print').on('click', function () {
            $('#section_to_print').printThis({
                importCSS: false,
                importStyle: true,
                loadCSS: ["plugins/bootstrap/css/bootstrap.min.css","plugins/bootstrap/css/complement_to_PrintThis_welmaster.css"],
                base:"./",
                canvas: true
            });
        });
    });
</script>

<?php
    }
?>