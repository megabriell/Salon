/*
Tabla con multiples filtros en encabezadao usando la libreria DataTable y extensiones del mismo
AUTOR: ING. MANUEL GABRIEL
GUATEMALA

funcion tableAdvanced(element,inputHead,ajax,option,inputSelect,IdReset,sumCol,report,order);

PARAMETROS:
element -> id de la tabla para aplicar la funcion DataTable
inputHead -> estilo para aplicar a input`s y select de thead(Encabezado de columna)
option -> array (False o True) para funcion paginacion, info(pie de tabla) y busqueda de DataTable
ajax -> array (False o True) para funcion paginacion, info(pie de tabla) y busqueda de DataTable
inputSelect -> array de columnas para aplicar input select, por numero de columna
IdReset -> Boton para resetear filtros de tabla
sumCol -> array de tres valores. 1.Numero de columna a sumar 2.id de elemento para mostrar el total 3.simbolo de moneda
report -> false para desabilitar botones de exportar. por defecto activado
order -> ordena las filas de la tabla de forma ascendente o descendente. Indicando el numero de columna y la forma de ordenar

EJEMPLO:
tableAdvanced("#example","classinput",['file.php',[data:col],filename],[true,true,true],[4,6,7],"#limpiar",[5,"#total","Q "],false);
*/

function tableAdvanced(element,inputHead,ajax,option,inputSelect,IdReset,sumCol=null,report=true,order=[0,'desc']){
    //agrega input en thead de la tabla
    $(element+' thead th:not(.notexport)').each(function(){
        title = $(element+' thead th').eq($(this).index()).text();
        $(this).html(title+'<input type="text" class="'+inputHead+'" />');
    });    

    //Inicia la funcion DataTable
    var table = $(element).DataTable({
        responsive: true,
        //'serverSide': true,
        paging: option[0],
        lengthMenu: [[25, 50, -1], [ 25, 50, "Todo"]],
        info: option[1],
        searching: option[2],
        ajax:{
            method:'POST',
            url:ajax[0]
        },
        columns:
            ajax[1],
        order: order,
        dom: "<'#Button_reports'><'row'<'col-sm-12'l>>rtip",//datatable dom        
        drawCallback: function(){
            //verifica si el parametro sum no esta vacio para realizar la suma
            if (sumCol != null || sumCol.length < 2) {
                var api = this.api();
                //la funcion $.number pertenece a la libreria juery.number.min 
                var total_suma = $.number(api.column(sumCol[0], {page:'current'}).data().sum() , 2 , ".", ",");
                $(sumCol[1]).html("Q" + total_suma );
            }
        },  
        initComplete: function () {
            if (inputSelect.length > 0) {
                this.api().columns(inputSelect).every( function(){
                    var column = this;
                    //obtiene el titulo del encabezado de la columna
                    var titulo = $(element+' thead th').eq(column.index()).text();
                    //limpia el encabezado de la columna 
                    $(element+' thead th').eq(column.index()).empty().html(titulo);

                    var selects = $('<select class="'+inputHead+'"><option value="" ></option></select>')
                    .appendTo($(column.header())).on( 'change', function(){
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search( val ? 
                            jQuery.fn.DataTable.ext.type.search.string(val) : '' ).draw();
                    });
                    column.data().unique().sort().each( function ( d, j ){
                        if ($(d).length>0) {
                            selects.append('<option value="'+$(d).text()+'">'+d+'</option>')
                        }else{
                            selects.append('<option value="'+d+'">'+d+'</option>')
                        }
                    });
                    $('select', table.column(column.index()).header()).on('click', function(e) {
                        e.stopPropagation();
                    });
                });
            }
            $("#circleLoading").remove();
            $(element).show();
            $("#load_table").hide();
        }
    });//Finaliza la funcion DataTable

    if (report) {
        //Constructor Buttons
        var titlePage = 'Asahi';
        var data = new Date($.now());
        var time = "_"+data.getDate()+"-"+(data.getMonth() + 1)+"-"+data.getFullYear()+"_"
        +data.getHours()+"-"+data.getMinutes()+"-"+data.getSeconds();
        if (ajax[2]) {
            titlePage = ajax[2];
        }
        new $.fn.dataTable.Buttons( table, {
            buttons: [
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title:'Reporte '+titlePage+time,
                    exportOptions: {
                        columns: ':not(.notexport)',//Ignora la columna de class notExport al Exportar
                        format: {
                            header:  function (data, columnIdx) {
                                return data.split('<')[0];
                            }
                        }
                    }
                },
                {
                    extend: 'excel',
                    title:'Reporte '+titlePage+time,
                    text: 'Excel',
                    exportOptions: {
                        columns: ':not(.notexport)',//Ignora la columna de class notExport al Exportar
                        format: {
                            header:  function (data, columnIdx) {
                                return data.split('<')[0];
                            }
                        }
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title:'Reporte '+titlePage+time,
                    exportOptions: {
                        columns: ':not(.notexport)',//Ignora la columna de class notExport al Exportar
                        format: {
                            header:  function (data, columnIdx) {
                                return data.split('<')[0];
                            }
                        }
                    }
                },{

                    extend: 'copy',
                    text: 'Copiar',
                    title:'Reporte '+titlePage+time,
                    exportOptions: {
                        columns: ':not(.notexport)',//Ignora la columna de class notExport al Exportar
                        format: {
                            header:  function (data, columnIdx) {
                                return data.split('<')[0];
                            }
                        }
                    }
                }
            ]
            
        });
        table.buttons().containers().appendTo( $('#Button_reports') );//Agrega los botones de exportar, al div Creado en propiedad dom
        $('#Button_reports').css({"padding": "8px"}); 
    }

    // aplica la busqueda introducida en el input o select
    table.columns().eq(0).each(function(colIdx){
        $('input', table.column(colIdx).header()).on('keyup change', function() {
            table
            .column(colIdx)
            .search( jQuery.fn.DataTable.ext.type.search.string(this.value) )
            .draw();
        });

        $('input', table.column(colIdx).header()).on('click', function(e) {
            e.stopPropagation();
        });
    });

    $(IdReset).click(function(){
        var classinpt = inputHead.split(' ')[0];
       $("."+classinpt).val('');
       table.search('').columns().search('').draw();
    });                      
};

//simple tabla con formato DataTable 
//funcion Tabla_Simple(IdTabla,Columa_a_sumar,optciones[info,paginacion,tamano_tabla],IdBotonReset)
function Tabla_Simple(element, sum=null, option, report=false,titlePage){

    var tabla = $(element).DataTable({
        pagingType: "numbers",
        lengthMenu: [[25, 50, -1], [25, 50, "Todo"]],
        info:option[0],
        paging:option[1],
        pageLength: option[2],
        searching: option[3],
        dom: "<'#Button_reports'><'row'<'col-sm-6'l><'col-sm-6'f>>rtip",//Datatable dom
        responsive: true,
        drawCallback: function(){
            //verifica si el parametro sum no esta vacio para realizar la suma
            if (sum != null || sum.length < 2) {
                var api = this.api();
                //la funcion $.number pertenece a la libreria juery.number.min 
                var total_suma = $.number(api.column(sum[0], {page:'current'}).data().sum() , 2 , ".", ",");
                $(sum[1]).html(sum[2] + total_suma );
            }
        }
    });

    if (report) {
        var titleExport = '';
        var data = new Date($.now());
        var time = "_"+data.getDate()+"-"+(data.getMonth() + 1)+"-"+data.getFullYear()+"_"
        +data.getHours()+"-"+data.getMinutes()+"-"+data.getSeconds();
        if (titlePage) {
            titleExport = titlePage;
        }else{
            titleExport = 'Reporte';
        }
        //Constructor Buttons 
        new $.fn.dataTable.Buttons( tabla, {
            buttons: [
            {
                extend: 'print',
                title:'Reporte '+titleExport+time,
                text: 'Imprimir',
                exportOptions: {
                    columns: ':not(.notexport)'//Ignora la columna de class notExport al Exportar
                }
            },
            {
                extend: 'excel',
                title:'Reporte '+titleExport+time,
                text: 'Excel',
                exportOptions: {
                    columns: ':not(.notexport)'//Ignora la columna de class notExport al Exportar
                }
            },
            {
                extend: 'pdf',
                title:'Reporte '+titleExport+time,
                text: 'PDF',
                exportOptions: {
                    columns: ':not(.notexport)'//Ignora la columna de class notExport al Exportar
                }
            },{

                extend: 'copy',
                title:'Reporte '+titleExport+time,
                text: 'Copiar',
                exportOptions: {
                    columns: ':not(.notexport)'//Ignora la columna de class notExport al Exportar
                }
            }
            ]
        });
        tabla.buttons().containers().appendTo( $('#Button_reports') );//Agrega los botones, al div Creado en propiedad dom
        $('#Button_reports').css({"padding": "8px"}); 
    }

    if (tabla){
        $("#circleLoading").remove();
        $("#load_table").hide();
        $(element).show();
    }
};

//tableAdvanced(element,ajax,option,sumCol=null,report=true,order=[0,'desc']);
function tableSimple(element, ajax, option, sum=null, report=true,order=[0,'desc']){
    if (ajax[3]) {
        var sendData = ajax[3];
    }else{
        var sendData = {};
    }
    var tabla = $(element).DataTable({
        responsive: true,
        lengthMenu: [[25, 50, -1], [ 25, 50, "Todo"]],
        paging: option[0],
        info: option[1],
        pageLength: option[2],
        searching: option[3],
        ajax:{
            method:'POST',
            url:ajax[0],
            data:sendData
        },
        columns:ajax[1],
        order: order,
        dom: "<'#Button_reports'><'row'<'col-sm-6'l><'col-sm-6'f>>rtip",//Datatable dom
        drawCallback: function(){
            //verifica si el parametro sum no esta vacio para realizar la suma
            if (sum != null || sum.length < 2) {
                var api = this.api();
                //la funcion $.number pertenece a la libreria juery.number.min 
                var total_suma = $.number(api.column(sum[0], {page:'current'}).data().sum() , 2 , ".", ",");
                $(sum[1]).html(sum[2] + total_suma );
            }
        }
    });

    if (report) {
        var titlePage = 'Asahi';
        var data = new Date($.now());
        var time = "_"+data.getDate()+"-"+(data.getMonth() + 1)+"-"+data.getFullYear()+"_"
        +data.getHours()+"-"+data.getMinutes()+"-"+data.getSeconds();
        if (ajax[2]) {
            titlePage = ajax[2];
        }
        //Constructor Buttons 
        new $.fn.dataTable.Buttons( tabla, {
            buttons: [
            {
                extend: 'print',
                title:'Reporte '+titlePage+time,
                text: 'Imprimir',
                exportOptions: {
                    columns: ':not(.notexport)'//Ignora la columna de class notExport al Exportar
                }
            },
            {
                extend: 'excel',
                title:'Reporte '+titlePage+time,
                text: 'Excel',
                exportOptions: {
                    columns: ':not(.notexport)'//Ignora la columna de class notExport al Exportar
                }
            },
            {
                extend: 'pdf',
                title:'Reporte '+titlePage+time,
                text: 'PDF',
                exportOptions: {
                    columns: ':not(.notexport)'//Ignora la columna de class notExport al Exportar
                }
            },{

                extend: 'copy',
                title:'Reporte '+titlePage+time,
                text: 'Copiar',
                exportOptions: {
                    columns: ':not(.notexport)'//Ignora la columna de class notExport al Exportar
                }
            }
            ]
        });
        tabla.buttons().containers().appendTo( $('#Button_reports') );//Agrega los botones, al div Creado en propiedad dom
        $('#Button_reports').css({"padding": "8px"}); 
    }

    if (tabla){
        $("#circleLoading").remove();
        $("#load_table").hide();
        $(element).show();
    }
};