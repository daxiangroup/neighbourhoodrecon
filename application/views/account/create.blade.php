@layout('layouts/master')

@section('content')
  <h2>Account Create</h2>

  {{ Form::open('account/create', 'POST', array('id'=>'frm-accountCreate')) }}

	{{ Form::label('frm-accountCreate-firstName', 'First Name') }}
  {{ Form::text('frm-accountCreate-firstName', '', array('id'=>'frm-accountCreate-firstName')) }}<br />
	{{ Form::label('frm-accountCreate-lastName', 'Last Name') }}
  {{ Form::text('frm-accountCreate-lastName', '', array('id'=>'frm-accountCreate-lastName')) }}<br />
	{{ Form::label('frm-accountCreate-email', 'Email Address') }}
  {{ Form::text('frm-accountCreate-email', '', array('id'=>'frm-accountCreate-firstName')) }}<br />
	{{ Form::label('frm-accountCreate-password', 'Password') }}
  {{ Form::password('frm-accountCreate-password', array('id'=>'frm-accountCreate-password')) }}<br />
	{{ Form::label('frm-accountCreate-password2', 'Confirm Password') }}
  {{ Form::password('frm-accountCreate-password2', array('id'=>'frm-accountCreate-password2')) }}<br />

  {{ Form::submit('Create Account!') }}

  {{ Form::close() }}

@endsection