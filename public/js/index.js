var turno, turnos;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function buscarMedicos(item) {
    $.ajax({
        type: "POST",
        url: "/buscarMedicos",
        data: { codigoMedico: item },
        dataType: 'JSON',
        success: function(response) {
            $.each(response, function(index, item) {
                $("#medico").append(`<option value="${item.codigoMedico}">${item.nombreMedico}</option>`);
            });
        },
    });
}

function buscarTurnos() {
    $("#btnBuscarTurnos").prop("disabled", true);
    $.ajax({
        type: "POST",
        url: "/buscarTurnos",
        data: {
            codEspecialidad: $("#especialidad").val(),
            codMedico: $("#medico").val(),
            jornada: $("#jornada").val()
        },
        dataType: 'JSON',
        success: function(response) {
            clearHtml();
            turnos = response;
            $.each(response, function(index, item) {
                $("#turnos").append(draw(item));
            });
            $("#btnBuscarTurnos").prop("disabled", false);
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

function confirmarCita() {
    $("#btnConfirmar").prop("disabled", true);
    $.ajax({
        type: "POST",
        url: "/asignarTurno",
        data: { id_turno: turno.id_turno },
        dataType: 'JSON',
        success: function(response) {
            $(".alert").prop("hidden", false);
            $(".table tr")[3].hidden = false;
            $(".table td")[3].textContent = response.consultorio;
            $("#btnConfirmar").prop("disabled", false);
        },
    });
}

$('body').on('click', '.fadeInUp', function(e) {
    turno = turnos.find(x => x.id_turno == e.currentTarget.id);

    /* Agregar detalles del turno al modal */
    $("#modalAsignaTurnoLabel").text(`Confirmar turno de ${turno.nombre_tur}`);
    $(".table td")[0].textContent = turno.fecha_turno;
    $(".table td")[1].textContent = turno.nombre_spc;
    $(".table td")[2].textContent = turno.nombre_med;

    $("#modalAsignaTurno").modal('show');
});