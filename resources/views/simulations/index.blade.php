@extends('app')



@section('content')
    <div class="Table">
        <div class="Heading">
            <div class="Cell">
                <p> ID </p>
            </div>

            <div class="Cell">
                <p> Name </p>
            </div>

            <div class="Cell">
                <p> Params </p>
            </div>

        </div>
        @foreach ($simulations as $simulation)
            <div class="Row">
                <div class="Cell">
                    <p> {{ $simulation->id }}</p>
                </div>
                <div class="Cell">
                    <p>{{ $simulation->name }} </p>
                </div>

                @foreach ($simulation->parameters as $parameter)
                    <div class="Cell">
                        <p> {{ $parameter->name }}: {{ $parameter->defaultVal }}</p>
                    </div>
                @endforeach
                <div class="Cell">
                    <a class="btn btn-danger" href="{{ url('/simulations/destroy', $simulation->id) }}">Delete</a>
                </div>
            </div>



        @endforeach

    </div>

    <a href="simulations/create">New Simulation</a>

@endsection

@section('footer')

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

@endsection