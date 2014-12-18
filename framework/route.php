<?php namespace Framework;

use App;

class Route
{
    public $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    /**
     * Split the Controller@View structure into the object and then the function
     * that will control the view.  Then call the function and it will handle
     * the request.
     *
     * @param $url
     */
    public function route($url)
    {
        // redirect them to the index page if they didn't include a route
        if (empty($url)) {
            $redirect = new Redirect();
            return $redirect->to("index");
        }
        $route = $this->routes[$url];
        // return a 404 response if the route isn't defined
        if (is_null($route)) {
            $this->response404();
        }
        // slice up Controller@function value of the key.  We can assume that this
        // exists since it is set by the developer.
        $delimiter = strpos($route, '@');
        $controller = "App\\" . substr($route, 0, $delimiter);
        $function = substr($route, $delimiter + 1);
        $obj = new $controller;
        $obj->$function();
    }

    /**
     * Set a 404 response code and then echo 404.
     */
    public function response404()
    {
        echo "404";
        header(':', true, 404);
        header('X-PHP-Response-Code: 404', true, 404);
        exit();
    }
}