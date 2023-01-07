const app = document.getElementById('typewriter')
;

const typewriter = new Typewriter(app,{
    loop:true,
    delay:70
});

typewriter
    .typeString('Escola Politècnica Superior de Enginyeria de Manresa')
    .pauseFor(100)
    .start();

function editItem(url){
    location.href = url;
//    <a href='editMachine.php?id=".$machine->getId()."'class = 'btn btn-warning'> E </a>
        //<a href='actions.php?action=deleteMachine&id=".$machine->getId()."'class = 'btn btn-danger'> X </a>
}

function deleteItem(url){
    location.href = url;
}

// A $( document ).ready() block.
$( document ).ready(function() {
    console.log( "ready!" );
});

// A $( document ).ready() block.
$( document ).ready(function() {
    $('#deleteModalCenter').on('show.bs.modal', function (event) {
        console.log("aaaa");
         var button = $(event.relatedTarget) // Button that triggered the modal
         var name = button.data('name');
         var type = button.data('type');
         var url = button.data('url');
         var modal = $(this)
         modal.find('.modal-body').html('Estàs apunt d\'eliminar  '+ type +' <b>'+name+'</b>.<br><br><div style="text-align:center">Desitges continuar?</div>');
         modal.find('.button-save').on( "click", function(){ deleteItem(url); });
        });
});

function changeBookingDate(el){
    machineId = $('select[name=machineId] option').filter(':selected').val()
    $.get( "hourSelector.php?date=" + el.value + "&machineId=" + machineId, function( data ) {
        $( ".__booking_hour__" ).html(data);
    });
}