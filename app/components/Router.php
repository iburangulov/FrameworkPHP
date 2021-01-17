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
		echo $this->internalRoute;
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
				return preg_replace('~^' . $routeKey . '$~', $routeValue['route'], $this->url);
			}
		}
	}


	/**
	 * @param string $path
	 * @param array $params
	 * Установка GET маршрута
	 */
	public
	static function get(string $path, array $params): void
	{
		self::$rotesList['get'][$path] = $params;
	}

	/**
	 * @param string $path
	 * @param array $params
	 * Установка POST маршрута
	 */
	public
	static function post(string $path, array $params): void
	{
		self::$rotesList['post'][$path] = $params;
	}

	/**
	 * @param string $path
	 * @param array $params
	 * Установка GET и POST маршрута
	 */
	public
	static function any(string $path, array $params): void
	{
		self::get($path, $params);
		self::post($path, $params);
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
//	/**
//	 * @param string $url
//	 * @return string
//	 * Возвращает полный адрес
//	 */
//	static function route(string $url): string
//	{
//		return ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . trim($url, '/');
//	}
//
//	/**
//	 * @param string $url
//	 * Редирект по адресу
//	 */
//	static function redirect(string $url): void
//	{
//		header('Location: ' . self::route($url));
//	}
//
//	/**
//	 *Редирект назад
//	 */
//	static function routeBack(): void
//	{
//		self::redirect($_SESSION['prev_page']);
//	}
//}