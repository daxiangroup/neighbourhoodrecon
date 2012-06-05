@layout('layouts/master')

@section('content')
    <h2>Account Dashboard</h2>

    <p>Here's a whole bunch of stuff that you can do. All of it fun!</p>
    {{ HTML::link('account/edit', 'Edit your account') }}

@endsection