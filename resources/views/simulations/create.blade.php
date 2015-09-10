@extends('app')

@section('head')

<h1> Create Simulation </h1>
@endsection
@section('content')
    {!! Form::open(['url' => 'simulations', 'files' => 'true']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('parameters', 'Parameters:') !!}
        {!! Form::file('thumbnail') !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Create Simulation', ['class' => 'btn btn-primary form-control']) !!}
    </div>


    {!! Form::close() !!}

@endsection