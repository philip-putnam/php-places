<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Place.php";

    session_start();

    if (empty($_SESSION['places'])) {
      $_SESSION['places'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views/'
    ));

    $app->get("/", function() use ($app) {

        return $app['twig']->render('root.html.twig', array('places' => Place::getAll()));

    });

    $app->post("/add-places", function() use ($app) {
        $place = new Place($_POST['place']);
        $place->save();
        return $app['twig']->render('add-places.html.twig', array('newPlace' => $place));

    });


    return $app;
?>
