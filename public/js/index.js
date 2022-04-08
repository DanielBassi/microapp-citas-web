var turnos;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function buscarTurnos() {
    $.ajax({
        type: "POST",
        url: "/buscarTurnos",
        data: {},
        dataType: 'JSON',
        success: function(response) {
            clearHtml();
            turnos = response;
            $.each(response, function(index, item) {
                $("#turnos").append(draw(item));
            });
        },
    });
}

function clearHtml() {
    $("#turnos").html("");
}

function draw(turno) {
    return '<div id="' + turno.id_turno + '" class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp; cursor: pointer;">\
                <div class="team-item position-relative rounded overflow-hidden">\
                    <div class="team-text bg-light text-center p-4">\
                        <h6>' + turno.nombre_med + '</h6>\
                        <p class="text-primary">' + turno.fecha_turno + '</p>\
                    </div>\
                </div>\
            </div>';
}

$('body').on('click', '.fadeInUp', function(e) {
    let turno = turnos.find(x => x.id_turno == e.currentTarget.id);
    if (window.confirm("¿Esta seguro que desea asignar el turno de la fecha " + turno.fecha_turno + "?")) {
        $.ajax({
            type: "POST",
            url: "/asignarTurno",
            data: { id_turno: turno.id_turno },
            dataType: 'JSON',
            success: function(response) {
                console.log(response);
            },
        });
    }
});