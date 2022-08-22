<?php
/**
 * @author : Gaellan
 * @author : Marine Sanson
 */

class Router {

    //analyse le chemin dans routes.txt
    private function parseRequest(string $request)
    {
        $route = [];

        $routeData = explode("/", $request);

        $route["path"] = "/".$routeData[1];

        if(count($routeData) > 2)
        {
            $route["parameter"] = $routeData[2];
        }
        else
        {
            $route["parameter"] = null;
        }

        return $route;
    }

// renvoie un tableau avec les différentes routes et enventuellement les parametres
    public function route(array $routes, string $request)
    {
        $requestData = $this->parseRequest($request);

        $routeFound = false;

        foreach($routes as $route)
        {
            $controller = $route["controller"];
            $method = $route["method"];
            $parameter = $route["parameter"];

            if($route["path"] === $requestData["path"])
            {
                if($route["parameter"] && $requestData["parameter"] !== null)
                {
                    $routeFound = true;
                    
                    $bm = new BasketManager();
                    $cm = new CategoryManager();
                    $mm = new MediaManager();
                    $nm = new NewsManager();
                    $pm = new ProductManager();
                    $rm = new RecipeManager();
                    $um = new UserManager();
                    $vm = new VarietyManager();

                    $ctrl = new $controller();
                    $ctrl->init($bm, $cm, $mm, $nm, $pm, $rm, $um, $vm);
                    $ctrl->$method($requestData["parameter"]);
                }
                else if(!$route["parameter"] && $requestData["parameter"] === null)
                {
                    $routeFound = true;
                    
                    $bm = new BasketManager();
                    $cm = new CategoryManager();
                    $mm = new MediaManager();
                    $nm = new NewsManager();
                    $pm = new ProductManager();
                    $rm = new RecipeManager();
                    $um = new UserManager();
                    $vm = new VarietyManager();

                    $ctrl = new $controller();
                    $ctrl->init($bm, $cm, $mm, $nm, $pm, $rm, $um, $vm);
                    $ctrl->$method();
                }
            }
        }
        // exception au cas où il n'ai pas trouvé de route
        if(!$routeFound)
        {
            throw new Exception("Route not found", 404);
        }
    }
}
