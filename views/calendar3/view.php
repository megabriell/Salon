<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body" id="box_body" style="padding: 0 25px 0 75px;">

                <div class="row">
                    <div class="page-header"><h2></h2></div>
                    <div class="pull-left form-inline"><br>
                        <div class="btn-group">
                            <button class="btn" data-calendar-nav="prev"><< Anterior</button>
                            <button class="btn " data-calendar-nav="today">Hoy</button>
                            <button class="btn " data-calendar-nav="next">Siguiente >></button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-default" data-calendar-view="year">Año</button>
                            <button class="btn btn-default active" data-calendar-view="month">Mes</button>
                            <button class="btn btn-default" data-calendar-view="week">Semana</button>
                            <button class="btn btn-default" data-calendar-view="day">Dia</button>
                        </div>
                    </div>

                    <div class="pull-right form-inline"><br>
                        <button class="btn btn-primary" data-toggle='modal' onclick="add()">Agendar</button>
                    </div>
                </div>
                <hr/>

                <div class="row">
                    <div id="calendar"></div> <!-- Aqui se mostrara nuestro calendario -->
                    <br><br>
                </div>

                <!--ventana modal para el calendario-->
                <div class="modal fade" id="events-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn btn-default pull-right btn-sm" data-dismiss="modal" title="Cerrar">X</button>
                            </div>
                            <div class="modal-body">
                                <p>One fine body&hellip;</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="subContent"></div>

<script type="text/javascript">
    loadCSS('./views/calendar/tmpls/card.css');//css card
    loadCSS('./plugins/calendar/css/calendar.css');//css calendar
    $.getScript("./plugins/underscore/underscore-min.js").done(function(){//js underscore
        $.getScript("./plugins/calendar/js/calendar.js").done(function(){//js calendar
            $.getScript("./plugins/calendar/js/es-ES.js").done(function(){//js calendar-es-ES

                $.getScript("./views/calendar3/js/script.js");

            });
        });
    });
  
</script>