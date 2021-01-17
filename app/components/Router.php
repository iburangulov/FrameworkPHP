<?php

namespace App\components;

class Router
{
	private static $rotesList;//Список всех маршрутов
	private $url; //Адрес запроса
	private $method;//Метод запроса
	private $requestData;//Данные запроса
	private $routes;//Список маршрутов для метода
	private $internalRoute;//Полный внутренний маршрут
	private $routeName;//Имя маршрута
	private $routeProtectors;//Список защитников маршрута
	private $deniedUrl;//Адрес отправки при отказе доступа

	public function __construct()
	{
		$this->url = APP_CONFIG['request_url'];
		$this->method = APP_CONFIG['request_method'];
		switch ($this->method):
			case 'get':
				$this->requestData = APP_CONFIG['get_method_data'];
				break;
			case 'post':
				$this->requestData = APP_CONFIG['post_method_data'];
				break;
		endswitch;
		$this->routes = self::$rotesList[$this->method];
	}

	/**
	 *Основной метод
	 * -Поиск внутреннего маршута
	 * -Вызов требуемых защитников
	 * -Передача данных и управления контроллеру
	 */
	public function run(): void
	{
		$this->internalRoute = $this->routeSearch();
		if (Protector::check($this->routeProtectors)) $this->call();
		else self::redirect($this->deniedUrl);
	}

	/**
	 *Передача данных и управления контроллеру
	 */
	private function call():void
	{
		$data = explode('/', $this->internalRoute);
		$controllerClass = 'App\\controllers\\' . ucfirst(array_shift($data)) . 'Controller';
		$action = array_shift($data);
		$controller = new $controllerClass;
		call_user_func_array([$controller, $action], $data);
	}

	/**
	 * @return string
	 * Выполняет поиск корректного внутреннего маршрута и устанавливает
	 * в него параметры
	 */
	private function routeSearch(): string
	{
		foreach ($this->routes as $routeKey => $routeValue) {
			$routeKey = trim($routeKey, '/');
			if (preg_match('~^' . $routeKey . '$~', $this->url)) {
				$this->routeName = isset($routeValue['name']) ? $routeValue['name'] : null;
				if (isset($routeValue['protectors']))
				{
					$this->routeProtectors = is_array($routeValue['protectors']) ? $routeValue['protectors'] : array($routeValue['protectors']);
				} else $this->routeProtectors = null;
				$this->deniedUrl = isset($routeValue['denied']) ? $routeValue['denied'] : '';
				return preg_replace('~^' . $routeKey . '$~', $routeValue['route'], $this->url);
			}
		}
	}

	/**
	 * @param string $path
	 * @param array $params
	 * Установка GET маршрута
	 */
	public static function get(string $path, array $params): void
	{
		self::$rotesList['get'][$path] = $params;
	}

	/**
	 * @param string $path
	 * @param array $params
	 * Установка POST маршрута
	 */
	public static function post(string $path, array $params): void
	{
		self::$rotesList['post'][$path] = $params;
	}

	/**
	 * @param string $path
	 * @param array $params
	 * Установка GET и POST маршрута
	 */
	public static function any(string $path, array $params): void
	{
		self::get($path, $params);
		self::post($path, $params);
	}

	/**
	 * @param string $url
	 * @return string
	 * Возвращает полный адрес
	 */
	public static function route(string $url): string
	{
		return ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . trim($url, '/');
	}

	/**
	 * @param string $url
	 * Редирект по адресу
	 */
	public static function redirect(string $url): void
	{
		header('Location: ' . self::route($url));
	}
}



//
//	/**
//	 *    Установка глобальных данных текущего запроса
//	 */
//	private function defineApplicationData(): void
//	{
//		$methodData = array();
//		switch ($this->method):
//			case 'get':
//				$methodData = $_GET;
//				break;
//			case 'post':
//				$methodData = $_POST;
//				break;
//		endswitch;
//
//		define('APP_DATA', [
//			'request_url' => $this->url, //Внешний маршрут
//			'request_data' => $methodData, //Данные из метода запроса
//			'current_method' => $this->method, //Метод запроса
//			'current_route_name' => $this->currentRoute['name'], //Текущee имя маршрут
//			'current_route' => $this->currentRoute['path'], //Текущий маршрут
//			'current_protectors' => $this->currentRoute['protectors'] //Текущий массив защитников
//		]);
//	}
//
//	/**
//	 * Вызов управляющего контроллера
//	 */
//	public function call(): void
//	{
//		$controller = new $this->controller(); //Создание экземпляра контроллера
//		call_user_func_array([$controller, $this->action], $this->data); //Вызов метода управляющего контроллера и передача ему данных
//	}
//