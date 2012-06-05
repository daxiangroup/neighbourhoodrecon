@layout('layouts/master')

@section('content')
    <h2>Account Edit</h2>

    {{ Form::open('account/edit', 'POST', array('id'=>'frm-accountEdit')) }}

    @if (Session::get('errorMessage'))
        Uh Oh! Error: {{ Session::get('errorMessage') }}<br /><br />
    @endif

    @include('account.form-user')

    {{ Form::submit('Edit Account!') }}

    {{ Form::token(); }}
    {{ Form::close() }}

@endsection