@extends('app')

@section('content')


    <a href="/jobs/overlaySelect">back</a>

    <div id="graph_div"></div>

    <?php echo \Lava::render('LineChart', 'Graph', 'graph_div') ?>



@endsection