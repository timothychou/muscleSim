@extends('app')

@section('content')

    {!! Form::open(['url' => 'jobs/overlay', 'method' => 'get']) !!}

    <div class="form-group">
        {!! Form::label('x_variable', 'X variable:') !!}
        <!--
        TODO fix array so not hard coded

        /-->
        {!! Form::select('x_variable', ['SL' => 'SL','T' => 'T','Ca' => 'Ca'], 1, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('y_variable', 'Y variable:') !!}
        {!! Form::select('y_variable', ['SL' => 'SL','T' => 'T','Ca' => 'Ca'], 0, ['class' => 'form-control']) !!}
    </div>


    <div class="Table">
        <div class="Title">
            <p>Jobs</p>
        </div>

        <div class="Heading">
            <div class="Cell">
                <p>Overlay</p>
            </div>

            <!--
            <div class="Cell">
                <p>ID</p>
            </div>
            -->

            <div class="Cell">
                <p>Download Input</p>
            </div>

            <div class="Cell">
                <p>Download Output</p>
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

        @foreach ($finishedJobs as $job)
            <div class="Row">
                <div class="Cell">
                    {!! Form::checkbox(  $job->id , null) !!}
                </div>

                <!--
                        <div class="Cell">
                            <p> {{ $job->id }}</p>
                        </div>
                        -->

                <div class="Cell">
                    <a href="{{ url('/jobs', $job->id) }}"> Download</a>
                </div>

                <div class="Cell">
                    <a href="{{ url('/jobs/output', $job->id) }}"> Download</a>
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

                @for ($i = count($job->variables); $i < 2; $i++)
                    <div class=Cell">
                        <p>' '</p>
                    </div>
                @endfor

            </div>
        @endforeach
    </div>

    <div class="form-group">
        {!! Form::submit('Overlay images', ['class' => 'btn btn-primary form-control']) !!}
    </div>
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