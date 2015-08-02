
@extends('app')

@section('content')

    <h1>Select parameters for {{ $name }}</h1>

    <hr/>

    <!-- redirect to jobs once the form is submitted, maybe change to some progress page later -->
    {!! Form::open(['url' => 'jobs']) !!}

    @foreach ($parameters as $parameter)

        <div class="form-group">
            {!! Form::label($parameter, $parameter . ':') !!}
            {!! Form::text($parameter, null, ['class' => 'form-control']) !!}
        </div>
    @endforeach

    <!-- submit button -->
    <div class="form-group">
        {!! Form::submit('Create job', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
@endsection

@section('footer')
    @include('errors/list')

@endsection