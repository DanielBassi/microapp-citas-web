@extends('layout.master')
@section('title', 'Agendar mi cita')
@section('content')
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5">
                    <h3 class="mb-4">Seleccione las caracteristicas de su cita</h3>
                    <form>
                        <div class="row g-3">
                            <div class="col-12 col-sm-3">
                                <label>Especialidad</label>
                                <select id="especialidad" class="form-select border-0" style="height: 55px;"
                                    onchange="buscarMedicos( this.value )">
                                    <option disabled selected="">Escoger especialidad</option>
                                    <option value="999">Medicina general</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-3">
                                <label>Médico</label>
                                <select id="medico" class="form-select border-0" style="height: 55px;">
                                </select>
                            </div>
                            <div class="col-12 col-sm-3">
                                <label>Jornada</label>
                                <select id="jornada" class="form-select border-0" style="height: 55px;">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-3 py-4">
                                <button type="button" onclick="buscarTurnos();" class="btn btn-primary w-100 py-3"
                                    type="button" id="btnBuscarTurnos">Buscar turnos</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="row g-4" id="turnos">

            </div>
        </div>
    </div>
@endsection
