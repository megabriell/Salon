    var datacol = new Array('./controllers/invoice_controller.php',
        [
            {'data':'ID'},
            {'data':'Col1'},
            {'data':'Col2'},
            {'data':{
                    '_': "Col3.display",
                    'sort': "Col3.order"
                }
            },
            {'data':'Col4'},
            {'data':'btns'}
        ],
        '',
        {getData:''}
    );
    tableSimple('#dataTable0',datacol,[true,true,25],'',false);
    
    function add(id){
        $.post("./views/invoice/new.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }

    function view(id){
        $.post("./views/invoice/view.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }

    function edit(id){
    	$.post("./views/invoice/edit.php?",{id:id}).done(function( data ){$('#subContent').html(data);});
    }