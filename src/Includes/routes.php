<?php

$router = app('router');

$router->get('webhook/facebook', function (){

    if (env('BOTOMATIC_FACEBOOK_CONFIRMATION') == true)
    {
        $all_request = app()->make(\Illuminate\Http\Request::class)->all();

        echo $all_request['hub_challenge'];
    }
});


/**
 * Facebook webhook
 */
$router->post('webhook/facebook', \Botomatic\Engine\Controllers\Webhook\Facebook::class);