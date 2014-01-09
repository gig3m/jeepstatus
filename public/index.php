<?php
require '../vendor/autoload.php';
require '../vots.php';

$redis = new Predis\Client();

////////////////////////
// Setup
////////////////////////

//Instantiate Slim
$app = new \Slim\Slim(array(
    'templates.path' => '../views',
));

//Twig hates the config array above
$app->view(new \Slim\Extras\Views\Twig());

//Do Dependancy Injection
$env = $app->environment();
$env['redis'] = $redis;

////////////////////////
// Routes
////////////////////////

//Redirect POST to get URL for bookmarking
$app->post('/status', function () use ($app) {

    $last = $_POST['last'];
    $vin  = $_POST['vin'];

    if (!$last || !$vin)
    {
        $data['error'] = "You didn't fill out both form fields!!??!?";
        $app->render('error.twig', $data);  
    }
    else
    {
        //Remove whitespace, take last 8 for people that can't read
        $last = preg_replace("/ /","+",trim($last));
        $vin  = substr(trim($vin), -8);

        //Do something
        $app->redirect("/status/$last/$vin/");      
    }


});

//Status 
$app->get('/status/:last/:vin/', function ($last, $vin) use ($app) {

    //Get environment and DI
    $env = $app->environment();
    $redis = $env['redis'];

    //Check redis cache for record
    if ($cached = $redis->get($vin))
    {
        //decode redis/JSON and pass it to VOTS class
        $jeep = new VOTSService(json_decode($cached, TRUE));


        $data = array(
            'statusCode' => $jeep->getStatusCode(),
            'statusDesc' => $jeep->getStatusDesc(),
            'statusExplanation' => $jeep->getStatusExplanation()
        );

        //Do something
        $app->render('response.twig', $data);
    }

    //redis has no key, lets go fetch Chrysler's response
    else 
    {
        $jeep = new VOTSService();
        $jeep->getJSON($last, $vin);
        if ($jeep->isValid())
        {
            $data = array(
                'statusCode' => $jeep->getStatusCode(),
                'statusDesc' => $jeep->getStatusDesc(),
                'statusExplanation' => $jeep->getStatusExplanation()
            );

            //put json into redis on key=vin for caching
            $redis->set($vin, json_encode($jeep::$decoded));
            $redis->expire($vin,60*20); //cache for 20 minutes

            //Do something
            $app->render('response.twig', $data);
        }
        else
        {
            //set an error message to display, courtesy of Chrysler
            $data = array(
                'error' => $jeep->getError()
            );
            $app->render('error.twig', $data);        
        }
    }

});

// Debug Decoded
$app->get('/debug/:last/:vin/', function ($last, $vin) use ($app) {

    $jeep = new VOTSService();
    $jeep->getJSON($last, $vin);
    if ($jeep->isValid())
    {
        $data = array(
            'JSON' => $jeep::$raw
        );

        //Do something
        $app->render('debug.twig', $data);
    }
    else
    {
        //set an error message to display, courtesy of Chrysler
        $data = array(
            'error' => $jeep->getError()
        );
        $app->render('error.twig', $data);        
    }
});



// Changelog
$app->get('/changelog', function () use ($app) {

    //Do something
    $app->render('changelog.twig');

});

// Home
$app->get('/', function () use ($app) {

    //Do something
    $app->render('home.twig');

});

////////////////////////
// Go Go
////////////////////////

$app->run();