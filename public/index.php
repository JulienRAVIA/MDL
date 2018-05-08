<?php 

include_once '../bootstrap.php';

$router = new AltoRouter();
// Si il n'y à pas de virtual host et que le projet est dans www
// $router->setBasePath('/GSB/public');

// Page d'accueil et déconnexion
$router->addRoutes(array(
    array('GET','/', 'App\\Controllers\\HomeController@index', 'index'),
    array('POST','/avis', 'App\\Controllers\\HomeController@ajoutAvis', 'avis.add'),
    array('POST','/avis/nb', 'App\\Controllers\\HomeController@nombreAvis', 'avis.nombre'),
    array('POST','/resultats', 'App\\Controllers\\HomeController@resultatsAtelier', 'atelier.resultats'),
));

$match = $router->match();

if (!$match) { 
    App\View\View::redirect('/');
} else {
    list($controller, $action) = explode('@', $match['target']);
    $controller = new $controller;
    if (is_callable(array($controller, $action))) {
        try {
            call_user_func_array(array($controller, $action), array($match['params']));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo 'Error: can not call ' . get_class($controller) . '@' . $action;
        // here your routes are wrong.
        // Throw an exception in debug, send a 500 error in production
    }
}

?>