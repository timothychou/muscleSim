@extends('app')

@section('content')

    <h1>Online Muscle Sim</h1>
    <h2><a href="/auth/login" style="right:10; top:0">Login</a></h2>
    <hr/>

    <body>

    <p>Welcome to OnlineMuscleSim.org!
    </p>

    <p>This is a beta release of a website that will allow anyone with a web browser to run simulations of cardiac
        muscle contraction. We envision this as a valuable tool for hypothesis generation and to aid in interpreting
        experimental results. At present, this website only runs one type of simulation - a single contraction of an
        unloaded isolated cardiac cell. The simulation outputs the sarcomere length over time in response to a single
        input calcium transient. The user can vary different parameters such as the cross bridge attachment and
        detachment rates, calcium affinity of troponin C, and cooperativity between neighboring thin filament regulatory
        units. Each simulation is saved to the user’s account, and results can easily be downloaded or overlaid in a
        convenient online plotting window.</p>

    <p>
        To get started, please use the link above to register for a free account. Please note that due to the
        preliminary nature of this project, user accounts and data may be erased without warning. Please also note
        that results are provided without warranty or guarantee of accuracy.
    </p>

    <p>
        Questions or comments should be directed to Stuart Campbell (contact
        <a href="http://seas.yale.edu/faculty-research/faculty-directory/stuart-campbell">here</a>).
    </p>
    </body>




@stop

