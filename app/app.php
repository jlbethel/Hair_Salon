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

    //Configuration to allow _method input to work
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

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
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    //Take user input for clients and post to stylist.html.twig
    $app->post("/add_clients", function() use ($app) {
        $client_name = $_POST['client_name'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($client_name, $stylist_id, $id = null);
        $client->save();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => Stylist::find($stylist_id), 'clients' => $stylist->getClients()));
    });

    //Clear all clients from stylist page and return home
    $app->post("/delete_clients", function() use ($app) {
        Client::deleteAll();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Path from stylist page to stylist edit page
    $app->get("/stylists/{id}/edit", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist_edit.html.twig', array('stylists' => $stylist));
    });

    //Route to allow the stylist update to work
    $app->patch("/stylists/{id}", function($id) use ($app) {
        $stylist_name = $_POST['stylist_name'];
        $stylist = Stylist::find($id);
        $stylist->update($stylist_name);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->delete("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Path from stylist page to client edit page
    $app->get("/clients/{id}/edit", function($id) use ($app) {
        $client = Client::find($id);
        return $app['twig']->render('client_edit.html.twig', array('clients' => $client));
    });

    //Route to allow the client update to work
    $app->patch("/clients/{id}", function($id) use ($app) {
        $client_name = $_POST['client_name'];
        $client = Client::find($id);
        $stylist = Stylist::find($id);
        $client->update($client_name);

        return $app['twig']->render('client_edit.html.twig', array('clients' => $client, 'stylist' => $stylist));
    });

    $app->delete("/delete_clients/{id}", function($id) use ($app) {
        $client = Client::find($id);
        $stylist = Stylist::find($client->getStylistID());
        $client->delete();
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    return $app;
 ?>
