@extends('app')

@section('content')

    <h1> Jobs </h1>





        {!! Form::open(['url' => 'jobs/overlay', 'method' => 'get']) !!}
        <div class="Table">
            <div class="Title">
                <p>Jobs</p>
            </div>

            <div class="Heading">
                <div class="Cell">
                    <p>Overlay</p>
                </div>
                <div class="Cell">
                    <p>Name</p>
                </div>

                <div class="Cell">
                    <p>Job type</p>
                </div>

                <div class="Cell">
                    <p> Parameters</p>
                </div>
            </div>

            @foreach ($jobs as $job)
                <div class="Row">
                    <div class="Cell">
                        {!! Form::checkbox(  $job->id , null) !!}
                    </div>
                    <div class="Cell">
                        <p> {{ $job->title }}</p>
                    </div>

                    <div class="Cell">
                        <p> {{ $job->simulation->name }}</p>
                    </div>

                    @foreach ($job->variables as $variable)
                        <div class="Cell">
                            <p> {{$variable->name }}: {{ $variable->value }}</p>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="form-group">
            {!! Form::submit('Overlay images', ['class' => 'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}


    <a href="jobs/create">New job</a>
@endsection

@section('footer')

    <style>
        .jobs-table
        {
            empty-cells: show;
            width:       100%;
            text-align:  left;
            padding:     100px;
        }
    </style>

    <style type="text/css">
        .Table
        {
            display: table;
        }
        .Title
        {
            display: table-caption;
            text-align: center;
            font-weight: bold;
            font-size: larger;

        }

        .Heading
        {
            display: table-row;
            font-weight: bold;
            text-align: center;
        }

        .Row
        {
            display: table-row;
        }

        .Cell
        {
            display: table-cell;
            border: solid;
            border-width: thin;
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $("td:empty").text("test");
        });
    </script>
@stop
