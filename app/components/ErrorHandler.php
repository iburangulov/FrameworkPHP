<?php

namespace App\components;

class ErrorHandler
{
	public function register(): void
	{
		set_error_handler([$this, 'errorHandler']);
		register_shutdown_function([$this, 'fatalErrorHandler']);
		set_exception_handler([$this, 'exceptionHandler']);
	}

	public function errorHandler(string $errno, string $errstr, string $errfile, string $errline): bool
	{
		$this->showError($errno, $errstr, $errfile, $errline);
		return true;
	}

	public function fatalErrorHandler()
	{
		$error = error_get_last();
		if (is_array($error) && in_array($error['type'],
				[E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])
		) {
			while (ob_get_level()) {
				ob_end_clean();
			}
			$this->showError($error['type'], $error['message'], $error['file'], $error['line']);
		}
	}

	public function exceptionHandler(\Throwable $exception): bool
	{
		$this->showError($exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
		return true;
	}

	private function showError(string $errno, string $errstr, string $errfile, string $errline): void
	{
		echo "<div style='font-family: monospace; font-size: 24px; background:#000; color: #ff0000; position: fixed; top: 0; left: 0;
height: 100vh; width: 100vw; display:flex; flex-direction: column; align-items: center; justify-content: center'>
		$errno: $errstr<br>File: $errfile<br>Line: $errline<br></div> ";
	}
}