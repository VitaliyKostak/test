<?php 
class Router 
{
	private $routes;
	// Файл з роутами
	public function __construct()
	{
		$routesPath = 'config/routes.php';
		$this->routes = require($routesPath);
	}
	// URL строка
	private function getUrl()
	{
		return @$_GET['route'];
	}

	public function run()
	{
		
		$route = $this->getUrl();
		$availabilityPage = false;
		foreach ($this->routes as $uriPattern =>$path)
		{
		    
			// Зрівняння $uriPattern і $route
			if (preg_match("#^$uriPattern$#", $route)) 
			{
				// Внутрішній путь із зовнішнього
				$internalRoute = preg_replace("~^$uriPattern$~", $path, $route);
				//Визначення контроллера
				$segments = explode('/', $internalRoute);
				$controllerName = array_shift($segments).'Controller';
				$controllerName = ucfirst($controllerName);
				// Визначення імені action
				$actionName = 'action'.ucfirst(array_shift($segments));
				$parameters = $segments;
				// Підключення файлу контроллера
				$controllerFile = 'controllers/ControllersForPages/'. $controllerName. '.php';
				if (file_exists($controllerFile)) 
				{
					include_once($controllerFile);
					// Створення об'єкту і виклик методу
					$controllerObject = new $controllerName();
					$result = $controllerObject->$actionName($parameters);
					if (null == $result)
					{
						$availabilityPage = true;
						break;
					}
					
				}
				
			}	
		}
		if ($availabilityPage == false)
		{
			header("HTTP/1.0 404 Not Found");
			echo 'Такої сторінки не існує';
		}
		
 	}
}
 ?>
