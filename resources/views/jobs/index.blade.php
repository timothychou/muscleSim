@extends('app')

@section('content')

    <h1> Jobs </h1>
        <div class="Table">
            <div class="Title">
                <p> Running Jobs</p>
            </div>

            <div class="Heading">
                <div class="Cell">
                    <p> ID</p>
                </div>

                <div class="Cell">
                    <p>Download Input</p>
                </div>

                <div class="Cell">
                    <p>Name</p>
                </div>

                <div class="Cell">
                    <p>Job Type</p>
                </div>

                <div class="Cell">
                    <p>Parameters</p>
                </div>

            </div>

            @foreach($unFinishedJobs as $job)
                <div class="Row">
                    <div class="Cell">
                        <p> {{ $job->id }} </p>
                    </div>

                    <div class="Cell">
                        <a href="{{ url('/jobs', $job->id) }}"> download</a>
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




        {!! Form::open(['url' => 'jobs/overlay', 'method' => 'get']) !!}
        <div class="Table">
            <div class="Title">
                <p>Finished Jobs</p>
            </div>

            <div class="Heading">
                <div class="Cell">
                    <p>Overlay</p>
                </div>

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

                    <div class="Cell">
                        <a href="{{ url('/jobs', $job->id) }}"> download</a>
                    </div>

                    <div class="Cell">
                        <a href="{{ url('/jobs/output', $job->id) }}"> download</a>
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

                    <div class="Cell">
                        <!--
                        Correct way to delete stuff
                        {!! Form::open(['method' => 'DELETE', 'route' => ['jobs.destroy', $job->id]]) !!}
                            <div class="form-group">
                                 {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            </div>
                        {!! Form::close() !!}
                        /-->

                        <!-- HTTP has a DELETE method, so it's probably better to use that, but we can't nest forms
                        , so.... -->
                        <a class="btn btn-danger" href="{{ url('/jobs/destroy', $job->id) }}">Delete</a>
                    </div>
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
