<?php include_once dirname(__file__,3)."/config/session.php"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body" id="box_body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1" data-toggle="tab" aria-expanded="true">
                                Productios Registrados
                            </a>
                        </li>
                        <li>
                            <a href="#tab_2" data-toggle="tab" aria-expanded="true">
                                Categoria de productos
                            </a>
                        </li>
                        <li>
                            <a href="#tab_3" data-toggle="tab">
                                Proveedor de producto
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <?php include_once dirname(__file__,3)."/views/product/view.php"; ?>
                        </div>

                        <div class="tab-pane" id="tab_2">
                            <?php include_once dirname(__file__,3)."/views/category/view.php"; ?>
                        </div>

                        <div class="tab-pane" id="tab_3">
                            <?php include_once dirname(__file__,3)."/views/provider/view.php"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="subContent"></div>
