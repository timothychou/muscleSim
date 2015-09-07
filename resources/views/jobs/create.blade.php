@extends('app')

@section('head')


@endsection
@section('content')

    @if (Session::has('floash_message'))
        <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
    @endif

    <h1>Create a new job</h1>

    <hr/>

    <!-- redirect to jobs once the form is submitted, maybe change to some progress page later -->
    {!! Form::open(['url' => 'jobs', 'files' => 'true']) !!}

    <!-- title area, should be optional -->
    <div class="form-group">
        {!! Form::label('title', 'Title:') !!}
        (optional)
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Simulation selection -->
    <div class="form-group">
        {!! Form::label('simulation_id', 'Simulation:') !!}
        {!! Form::select('simulation_id', $simulations, 1, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('variables', 'Variables:') !!}
        {!! Form::file('thumbnail') !!}

        <a href="exampleInput">download example file</a>
    </div>



    <div id="parametersDiv">not working</div>

    <!-- submit button -->
    <div class="form-group">
        {!! Form::submit('Create job', ['class' => 'btn btn-primary form-control']) !!}
    </div>


    {!! Form::close() !!}
@endsection

@section('footer')

    <script>

        $ (document).ready(function() {
            $.get('ajax/parameters',  {simulation_id: $('#simulation_id').val()}).done(function(data){
                $('#parametersDiv').html(data);

            });

            $('#simulation_id').change(function(){

                $.get('ajax/parameters',  {simulation_id: $('#simulation_id').val()}).done(function(data){
                    $('#parametersDiv').html(data);
                    /* debugging
                    alert("Data Loaded: " + data);
                    */
                });
            });
        });
    </script>

    @include('errors/list')

@endsection