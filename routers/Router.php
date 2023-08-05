<?php
class Router {
    private $routes = [];

    public function addRoute($url, $handler) {
        $this->routes["/shop2/index.php/$url"] = $handler;
    }

    public function dispatch($url) {
        if (array_key_exists($url, $this->routes)) {
            $handler = $this->routes[$url];
            call_user_func($handler);
        } else {
            return [
                "status"=> "404",
                "message"=> "page not found",
                "data"=> "",
            ];
        }
    }
}

?>