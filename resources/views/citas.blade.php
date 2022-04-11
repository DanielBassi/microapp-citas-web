@extends('layout.master')
@section('title', 'Mis citas')
@section('content')
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5">
                    <h3 class="mb-4">Mis citas incumplidas</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>Código</th>
                            <th>Fecha</th>
                            <th>Especialidad</th>
                            <th>Médico</th>
                            <th>Sede</th>
                            <th>Consultorio</th>
                            <th>Acciones</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="row g-4 py-4">
            <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5">
                    <h3 class="mb-4">Mis citas futuras</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>Código</th>
                            <th>Fecha</th>
                            <th>Especialidad</th>
                            <th>Médico</th>
                            <th>Sede</th>
                            <th>Consultorio</th>
                            <th>Acciones</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
