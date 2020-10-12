<?php
    include_once dirname(__file__,3).'/models/tpay.php';
    include_once dirname(__file__,3).'/models/user.php';
    include_once dirname(__file__,3).'/models/invoice.php';
    include_once dirname(__file__,3).'/models/product.php';
    include_once dirname(__file__,3).'/models/service.php';
    $pay = new TPay();
    $client = new User();
    $invoice = new Invoice();

    $id = isset($_POST['id'])? $_POST['id'] : null;
    $data = $invoice->getInvoiceById($id);
    $data2 = $invoice->getItemsById($id);

    if ($data && $data2) {
        $idInv = $data->Id_Enca_Factura;
        $pago = $data->Id_Tipo_Pago;
        $cliente = $data->Id_cliente;
        $stylist = ( !empty($data->Id_Employee))? $data->Id_Employee : '';
        $fecha = $data->Fecha;
        echo "<script>
            $('#tpay option[value=\"".$pago."\"]').prop('selected', true);
            $('#client option[value=\"".$cliente."\"]').prop('selected', true);
            $('#dateInv').datepicker('setDate', '".formatDateTime($fecha,'d-m-Y')."');
        </script>";
        if (!empty($stylist)) {
            echo "<script>$('#stylist option[value=\"".$stylist."\"]').prop('selected', true);</script>";
        }
        $products = new Product();
        $label0 = $products->getProducts();
        $arrayP = [];
        if ($label0) {
            foreach ($label0 as $key => $value) {
                $arrayP[$value->Id_Producto] = $value->Descripcion .' - '.$value->Categoria;
            }
        }
        $services = new Service();
        $label1 = $services->getServices();
        $arrayS = [];
        if ($label1) {
            foreach ($label1 as $key => $value) {
                $arrayS[$value->Id_Servicio] = $value->Descripcion;
            }
        }

?>
<div class="modal" tabindex="-1" id="modal0" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-sm" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <h4 class="modal-title">Modificar Factura</h4>
            </div>
        <div class="modal-body">
            <form class="form-horizontal" id="dataForm0" autocomplete="off">
                <div class="box-body">
                    <div class="form-group">
                        <label for="tpay" class="col-sm-2 control-label">Tipo Pago</label>
                        <div class="col-sm-10">
                            <input type="hidden" id="id" name="id" value="<?php echo $idInv ?>">
                            <select class="form-control" id="tpay" name="tpay">
                                <option disabled selected hidden value="">Selecciones un Tipo de pago</option>
                                <?php
                                    $rows_1 = $pay->getTPays();
                                    if ($rows_1) {
                                        foreach ($rows_1 as $value) {
                                            $id = $value->Id_Tipo_Pago;
                                            $desc = $value->Descripcion;
                                            echo '<option value="'.$id.'">'.$desc.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="client" class="col-sm-2 control-label">Cliente</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="client" name="client">
                                <option disabled selected hidden value="">Selecciones un cliente</option>
                                <?php
                                    $rows_1 = $client->getTypeUsers(3);
                                    if ($rows_1) {
                                        foreach ($rows_1 as $key => $value) {
                                            $id = $value->Id_Usuario;
                                            $name = $value->Nombre.' '.$value->Apellido;
                                            echo '<option value="'.$id.'">'.$name.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="stylist" class="col-sm-2 control-label">Estilista</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="stylist" name="stylist">
                                <option disabled selected hidden value="">Selecciones un estilista</option>
                                <?php
                                    $rows_2 = $client->getTypeUsers(2);
                                    if ($rows_2) {
                                        foreach ($rows_2 as $key => $value) {
                                            $id = $value->Id_Usuario;
                                            $name = $value->Nombre.' '.$value->Apellido;
                                            echo '<option value="'.$id.'">'.$name.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dateInv" class="col-sm-2 control-label">Fecha</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="dateInv" name="dateInv" placeholder="Fecha a facturar">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="discount" class="col-sm-2 control-label">%Descuento</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="discount" name="discount" placeholder="Aplicar descuento a total de factura" value="<?php echo $data->Descuento ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reward" class="col-sm-2 control-label">Propina</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="reward" name="reward" placeholder="Propina"  value="<?php echo $data->Propina ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="commentary" class="col-sm-2 control-label">Comentario</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="commentary" name="commentary" placeholder="Escriba su comentario aqui..."><?php echo $data->Comentario ?></textarea> 
                        </div>
                    </div>

                    <!-- Formulario para agregar articulos de articulos agregados--->
                    <div class="form-group">
                        <label class="col-xs-2 control-label" for="descipcion">Articulos</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="tArticule" name="tArticule">
                                <option disabled selected hidden value="">Tipo de articulo</option>
                                <option value="1">Producto</option>
                                <option value="2">Servicio</option>
                            </select>
                        </div>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" name="desArticule" id="desArticule" placeholder="Seleccione el articulo">
                            <input type="hidden" id="IdArticule" name="IdArticule">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"></label>
                        <div class="col-xs-4">
                            <input type="number" class="form-control" name="price" id="price" placeholder="Precio">
                        </div>
                        <div class="col-xs-4">
                            <input type="number" class="form-control"name="quantity" id="quantity"  placeholder="Cantidad">
                        </div>
                        <div class="col-xs-1">
                        <button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
                            <i class="fa fa-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                    <!-- Tabla de articulos agregados--->
                    <div id="result_items">
                        <table id="dataTable2" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Tipo</th>
                                    <th>Articulo</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class='text-right'>Total</th>
                                    <th class='text-right' id="total"></th>
                                    <th></th>
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
                                        $btn = '<button type="button" class="btn btn-danger btn-sm" onclick="removeItem('.$inv.','.$dItem.','.$tItem.','.$key.')" id="perm_'.$key.'">
                                            <i class="fa fa-trash"></i> Quitar</button>';

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
                                        <td>".$sub."</td>
                                        <td>".$btn."</td>
                                        </tr>";
                                    }//
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" name="edit" value="Modificar">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $.getScript("./views/invoice/js/script1.js");
</script>


<?php
    }
?>