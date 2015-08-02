<!-- errors variable is automatically generated in views -->
@if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li> {{ $error }}</li>
        @endforeach
    </ul>
@endif

