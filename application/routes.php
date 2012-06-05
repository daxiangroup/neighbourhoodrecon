<?php

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| These are the public routes of the application.
|
*/

Route::get('/', function()
{
    return View::make('home.index');
});

Route::get('account/create', function()
{
    return View::make('account/create');
});
Route::post('account/create', array('before'=>'csrf', function()
{
    $input = Input::all();

    // Validate the user input to ensure we have everything we need/want
    $validation = new Services\UserValidator($input);

    // If validation fails, send the user back to the account create form with
    // error messages.
    if ($validation->fails())
    {
        Input::flash();
        return Redirect::to('account/create')
            ->with_errors($validation->errors());
    }

    // Create a user object with the (now validated) user data, hashing the 
    // password.
    $user = new Entities\User($input, array('hash_password'=>TRUE));

    // Try to save the new user object to the repo.
    $success = Repositories\UserRepository::save($user);
    // If we weren't successful saving the account, we need to let the user know
    // and redirect them back to the create form.
    if ( ! $success)
    {
        Session::flash('errorMessage', 'There was a problem saving your account');
        return Redirect::to('account/create');        
    }

    $credentials = array('username'=>$user->get('email'), 'password'=>$input['password']);
    if (Auth::attempt($credentials))
    {
        Session::flash('successMessage', 'You posted an account creation successfully!');
        return Redirect::to('account/dashboard');
    }

    return Redirect::to('login');
}));

/*
|--------------------------------------------------------------------------
| Private Routes
|--------------------------------------------------------------------------
|
| These routes require a user to be logged in before they are valid
|
*/

Route::group(array('before' => 'auth'), function()
{
    Route::get('account/dashboard', function()
    {
        return View::make('account/dashboard');
    });

    Route::get('account/edit', function()
    {
        $user = new Entities\User(Auth::user()->id);
        return View::make('account/edit')
            ->with('input', $user->get_table_array());
    });
});




/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
    return Response::error('404');
});

Event::listen('500', function()
{
    return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|       Route::filter('filter', function()
|       {
|           return 'Filtered!';
|       });
|
| Next, attach the filter to a route:
|
|       Router::register('GET /', array('before' => 'filter', function()
|       {
|           return 'Hello World!';
|       }));
|
*/

Route::filter('before', function()
{
    // Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
    // Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
    if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
    if (Auth::guest()) return Redirect::to('login');
});