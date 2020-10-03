    var idForm = $('#dataForm'),
    idModal = $('#add_evento'),
    idTable = $('#dataTable0');

    idModal.modal();
    idForm.bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            stylist: {
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
            service: {
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
            date: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    date: {
                        message: 'Seleccione una opcion'
                    },
                    date: {
                        format: 'DD/MM/YYYY h:m',
                        message: 'La fecha no es valida'
                    }
                }
            },
            comment: {
                validators: {
                    stringLength: {
                        max: 100,
                        message: 'El campo debe tener un maximo de 100 caracteres'
                    }
                }
            },
        }
    }).on('success.form.bv', function(form){
        form.preventDefault();
        var $form = $(form.target), option = $('input[type="submit"]'),
        form_data = new FormData($form[0]);
        form_data.append(option.attr('name'), '');//option create or update
        form_data.append('modal', '$("#'+idModal.attr('id')+'")');//for hide model when have success
        option.button('loading');
        $.ajax({
            url: "./controllers/calendar_controller.php",
            type: "POST",
            data:  form_data,
            processData: false,
            contentType: false,
            success: function(data){
                data;
                option.button('reset');
            }
        });
    });

    loadCSS('./plugins/datatimepicker/css/bootstrap-datetimepicker.min.css'); //css fileinput
    $.getScript("./plugins/datatimepicker/js/bootstrap-datetimepicker.min.js").done(function(){
        $('#datetimepicker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            minDate: new Date()
        }).on('dp.change', function(e) {
            idForm.bootstrapValidator('revalidateField', 'date');
        })
    });


    //<!-- Script estetico -->
        $("#service").change(function() {
            var opt = $(this).find(":selected").val();
            $.getJSON("./controllers/calendar_controller.php",{service:opt}).done(function(data){
                $('#time').text(data.Duracion+'(H:M) ->Duración aproximada');
            });
        });
        $('#datetimepicker').datetimepicker().on('dp.change', function(e){
            var inpt1 = $('#date').val().split(" "),
            inpt2 = $('#time').text().split("("),
            inpt2 = inpt2[0].split(":");

            var date = inpt1[0].split("/"),
            time = inpt1[1],
            newtime = date[2]+'-'+date[1]+'-'+date[0] +' '+time,
            dataTime = new Date(newtime);

            dataTime.setMinutes(dataTime.getMinutes() + ( inpt2[0]*60 + (inpt2[1]*1) )) ;
            var datestring = dataTime.getDate()
                + "-" + (dataTime.getMonth()+1)
                + "-" + dataTime.getFullYear()
                + " " +dataTime.getHours() + ":" + dataTime.getMinutes();
            $('#time2').text(datestring +' ->Finaliza');
        });
    //<!-- Script estetico -->
/*
$('#datetimepicker').datetimepicker().on('dp.change', function(e){console.log('ola')});
var today = new Date('2017-01-26 04:00');
console.log(today);
today.setHours(today.getHours() + 4);
var datestring = today.getDate()  + "-" + (today.getMonth()+1) + "-" + today.getFullYear() + " " +
today.getHours() + ":" + today.getMinutes();
console.log(datestring);*/