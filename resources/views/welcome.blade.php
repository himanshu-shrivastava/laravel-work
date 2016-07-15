@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome to the assignment portal</div>

                <div class="panel-body">
                    <div>Your Application's</div>
                    <div><p></p></div>
                    <div>
                        <p>Here is the requirement:</p>
                        <p>Create a simple authentication mechanism with Laravel 5.
                            Provide data models allowing a user to register the system using multiple authentication channels
                                and managing user identification from multiple networks.
                        </p>
                        <div>
                            <ul>
                                <li>Email Password registration</li>
                                <li>Facebook Oauth</li>
                                <li>Google Account Oauth</li>
                                <li>User basic bootstrap for the UI</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
