<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";

    //Set up debugging and Silex path
    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    //Set path to MySQL
    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    //Set path for Twig
    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    //Path to the homepage
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Take user stylists input and post to homepage
    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist($_POST['stylist_name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Clear all stylists from homepage
    $app->post("/delete_stylists", function() use ($app) {
        Stylist::deleteAll();
        $stylists = [];
        return $app['twig']->render('index.html.twig', array('stylists' => $stylists));
    });

    //Path from stylist links on homepage to stylist.html.twig
    $app->get("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => Client::getAll()));
    });

    //Take user input for clients and post to stylist.html.twig
    $app->post("/clients", function() use ($app) {
        $client_name = $_POST['client_name'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($client_name, $id = null, $stylist_id);
        $client->save();
        return $app['twig']->render('stylist.html.twig', array('stylist' => Stylist::find($stylist_id), 'clients' => Client::getAll()));
    });

    //Clear all clients from stylist page
    $app->post("/delete_clients", function() use ($app) {
        Client::deleteAll();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getALL()));
    });

    return $app;
 ?>
