@layout('layouts/master')

<pre>
<?php print_r($errors); ?>
<?php echo 'test: '.print_r($errors->first('email'),true); ?>
</pre>

@section('content')
    <h2>Account Create</h2>

    {{ Form::open('account/create', 'POST', array('id'=>'frm-accountCreate')) }}

    @if (Session::get('errorMessage'))
        Uh Oh! Error: {{ Session::get('errorMessage') }}<br /><br />
    @endif

    @include('account.form-user')

    {{ Form::submit('Create Account!') }}

    {{ Form::token(); }}
    {{ Form::close() }}

@endsection