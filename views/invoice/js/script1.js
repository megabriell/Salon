	var idForm = $('#dataForm0'),
    idModal = $('#modal0'),
    idTable = $('#dataTable0'),
    idTable2 = $('#dataTable2');

    idModal.modal({backdrop:'static'});
    idForm.bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            tpay: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar una opción'
                    },
                    hoice: {
                        min: 1,
                        message: 'Debe seleccionar almenos una opción'
                    }
                }
            },
            client: {
                validators: {
                    notEmpty: {
                        message: 'Debe seleccionar una opción'
                    },
                    hoice: {
                        min: 1,
                        message: 'Debe seleccionar almenos una opción'
                    }
                }
            },
            stylist: {
                validators: {
                    hoice: {
                        min: 1,
                        message: 'Debe seleccionar almenos una opción'
                    }
                }
            },
            date: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    date: {
                        message: 'Seleccione una opcion'
                    },
                    date: {
                        format: 'DD/MM/YYYY',
                        message: 'La fecha no es valida'
                    }
                }
            },
            dateInv: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    date: {
                        message: 'Seleccione una opcion'
                    },
                    date: {
                        format: 'DD/MM/YYYY',
                        message: 'La fecha no es valida'
                    }
                }
            },
            discount: {
                validators: {
                    regexp: {
                        //regexp: /^(100(\.0{1,2})?|([0-9]?[0-9](\.[0-9]{1,2})?)%?)$/,
                        regexp: /^(([0-9]?[0-9](\.[0-9]{1,2})?)%)$/,
                        message: 'Debe aplicar un % de descuento, ejemplo 5%'
                    }
                }
            },
            reward: {
                validators: {
                    numeric: {
                        message : 'Introduze un valor valido'
                    }
                }
            },
            commentary: {
                validators: {
                    stringLength: {
                        max: 100,
                        message: 'El campo debe tener un maximo de 100 caracteres'
                    }
                }
            },
            tArticule: {
                excluded:true
            },
            desArticule: {
                excluded:true
            },
            IdArticule: {
                excluded:true
            },
            price: {
                excluded:true
            },
            quantity: {
                excluded:true
            }
        }
    }).on('changeDate', '#dateInv', function(e) {
        idForm.bootstrapValidator('revalidateField', 'dateInv');
    }).on('success.form.bv', function(form){
        if ( !idTable2.DataTable().data().any() ) {
            alert('Debe agregar un articulo para facturar');
            return false;
        }
        form.preventDefault();
        var $form = $(form.target), option = $('input[type="submit"]'),
        form_data = new FormData($form[0]),
        total =  $('#total').text().split(" ");
        form_data.append(option.attr('name'), '');//option create or update
        form_data.append('modal', '$("#'+idModal.attr('id')+'")');//for hide model when have success
        form_data.append('total',total[1]);
        option.button('loading');
        $.ajax({
            url: "./controllers/invoice_controller.php",
            type: "POST",
            data:  form_data,
            processData: false,
            contentType: false,
            success: function(data){
                data;
                option.button('reset');
                idTable.DataTable().ajax.reload( null, false );
            }
        });
    });

    var idItem = $("#IdArticule"),
        type = $("#tArticule"),
        description = $("#desArticule"),
        price = $("#price"),
        quantity = $("#quantity"),
        iteration = 0;

    /*#####     DataTable of Items  ######*/
    idTable2.DataTable({
        responsive: true,
        paging: false,
        info: false,
        pageLength: false,
        searching: false,
        drawCallback: function(){
            var api = this.api(),
            total = api.column(4, {page:'current'}).data().sum(),//total tabla
            descuento = ( $('#discount').val() != '' )? $('#discount').val().split("%") : '0';//aplicar descuento
            var restaDescuento  = ( (total) * (descuento[0]*1) )/100,
            reward = ( $('#reward').val() != '' )? $('#reward').val() : '0';
            var total_suma = $.number( (total-restaDescuento+(reward*1)), 2 , ".", ",");
            $('#total').html('Q ' + total_suma );
        }
    });
    /*#####     End DataTable of Items  ######*/

/*#####     Function add and remove item to DataTable of Items  ######*/
    function addItem(){
        var values;
        if (type.children(":selected").val() == '') {
            type.focus().select();
            return false;
        }else if(idItem.val() == ''){
            description.focus();
            return false;
        }else if(description.val() == ''){
            description.focus();
            return false;
        }else if(price.val() == ''){
            price.focus();
            return false;
        }else if(quantity.val() == ''){
            quantity.focus();
            return false;
        }
        data = {
            'tItem':type.val(),
            'dItem':idItem.val(),
            'qItem':quantity.val(),
            'pItem':price.val(),
            'additem':iteration
        };
        //send data of item added to cache
        $.post("./controllers/invoice_controller.php",data).done(function(data){});

        //add row to dataTable
        idTable2.DataTable().row.add(values = [
            $("#tArticule option:selected" ).text(),
            description.val(),
            quantity.val(),
            price.val(),
            $.number( ( (quantity.val()*1) * (1*price.val()) ) , 2 , ".", ","),
            '<button type="button" class="btn btn-danger btn-sm deleteItem" value="'+iteration+'">'
                +'<i class="fa fa-trash"></i> Quitar</button>'
        ]).draw( false );

        //clear input's
        $("#tArticule").prop("selected", false);
        type.val('');
        idItem.val('');
        description.val('');
        price.val('');
        quantity.val('');
        iteration++;
    }

    //Clear cache of server
    idModal.on('hidden.bs.modal', function (e) {
       $.post("./controllers/invoice_controller.php",{clear:''}).done(function(data){});
    })

    //remove item of table
    $('#dataTable2 tbody').on( 'click', '.deleteItem', function () {
        $.post("./controllers/invoice_controller.php?",{delitem:$(this).val()}).done(function(data){});
        idTable2.DataTable()
        .row( $(this).parents('tr') ).remove().draw();
    });

    function removeItem(idE,idA,idT,row){
        console.log();
        $.confirm({
            title: '&#161;Advertencia!',
            type: 'red',
            content: 'Realmenete desea eliminar el registro. El proceso es irreversible ¿Desea continuar?',
            buttons: {
                SI: function () {
                    $.ajax({
                        type: "POST",
                        data:  {id:idE, item:idA, type:idT, removeItem:''},
                        url: "./controllers/invoice_controller.php",
                        success: function(respuesta){
                            respuesta;
                            idTable2.DataTable()
                            .row( $('#perm_'+row).parents('tr') ).remove().draw();
                        }
                    }); 
                },
                Cancelar: function () {
                }
            }
        });
    }
/*#####     End function add item to DataTable of Items  ######*/
    
    loadCSS('./plugins/datepicker/datepicker3.css'); //css fileinput
    $.getScript("./plugins/datepicker/bootstrap-datepicker.js").done(function(script, textStatus){
        $.getScript("../plugins/datepicker/locales/bootstrap-datepicker.es.js").done(function( script, textStatus ) {
            $('#dateInv').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                language: 'es',
                todayHighlight: true
            })
        });
    });

    loadCSS('./plugins/autocomplete/easy-autocomplete.css'); //css fileinput
    $.getScript("./plugins/autocomplete/jquery.easy-autocomplete.js").done(function(){
        
                description.easyAutocomplete({
                    url: function(phrase) {
                        return "./controllers/invoice_controller.php";
                    },
                    getValue: function(element) {
                        return element.Val1;
                    },
                    ajaxSettings: {
                        dataType: "json",
                        method: "POST"
                    },
                    preparePostData: function(data) {
                        data.item = description.val(); //{item:$("#desArticule").val()}
                        data.type = type.val();//{type:$("#tArticule").val()}
                        data.autocomplet = '';
                        return data;
                    },
                    list: {
                        maxNumberOfElements:5,
                        onSelectItemEvent: function() {
                            var val1 = description.getSelectedItemData().ID,
                            val2 = description.getSelectedItemData().Val2;

                            idItem.val(val1).trigger("change");
                            price.val(val2).trigger("change");
                        }
                    },
                    requestDelay: 500
                });
    });
