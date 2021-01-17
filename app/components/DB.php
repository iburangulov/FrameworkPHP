<?php

namespace App\components;

use PDO;

class DB
{
	private static function getPDO(): PDO
	{
		$db_host = DB_CONFIG['db_host'];
		$db_name = DB_CONFIG['db_name'];
		$db_user = DB_CONFIG['db_user'];
		$db_pass = DB_CONFIG['db_pass'];
		$opt = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_CASE => PDO::CASE_NATURAL,
			PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
			PDO::ATTR_STRINGIFY_FETCHES => false,
			PDO::ATTR_EMULATE_PREPARES => true,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		];
		$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
		return new PDO($dsn, $db_user, $db_pass, $opt);
	}

	public static function getById(string $table, int $id)
	{
		$pdo = self::getPDO();
		$prep = $pdo->prepare("SELECT * FROM :table WHERE id = :id");
		return $prep->execute([
			'table' => $table,
			'id' => $id]);
	}

	public static function search(string $table, string $col, string $value, int $limit = 1)
	{
		$pdo = self::getPDO();
		$query = $pdo->prepare("SELECT * FROM `:t`");
		return $query->execute(['t' => $table]);
	}
}