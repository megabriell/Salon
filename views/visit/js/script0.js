    var datacol = new Array('./controllers/calendar_controller.php',
        [
            {'data':'ID'},
            {'data':'Col1'},
            {'data':'Col2'},
            {'data':'Col3'},
            {'data':'Col4'},
            {'data':'Col5'},
            {'data':{
                    '_': "Col6.display",
                    'sort': "Col6.order"
                }
            },
            {'data':'btns'}
        ],
        '',
        {getData:''}
    );
    tableSimple('#dataTable0',datacol,[true,true,25],'',false,[6,'desc']);
    
    function add(id){
        $.post("./views/visit/new.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }

    function edit(id){
    	$.post("./views/visit/edit.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }

    function viewDate(id){
        var modal = $('#events-modal'),
        modal_body = modal.find('.modal-body')
        $.ajax({
            url: './controllers/calendar_controller.php?id_event='+id,
            dataType: "html", async: false, success: function(data) {
                modal_body.html(data);
                modal.modal({keyboard: true, backdrop:true});
            }
        });
    }