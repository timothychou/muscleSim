@extends('app')

@section('content')

    <h1>Home page</h1>
    <a href="/auth/login" style="right:10; top:0">login</a>
    <hr/>

    <body> This is a mock-up of what will eventually be a simulation scheduler to run simulations on lab hardware.
    The lab can be found <a href="http://seas.yale.edu/faculty-research/faculty-directory/stuart-campbell">here</a>.
    Users will be able to create an account and request jobs. They will be able to specify various parameters in the
    simulations, and will be notified when the computing has finished.</body>


@stop

