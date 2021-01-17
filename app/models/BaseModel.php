<?php
namespace App\models;

use App\components\DB;

abstract class BaseModel
{
	protected $tableName;

	public function __construct(string $tableName)
	{
		$this->setTable($tableName);
	}

	protected function setTable(string $tableName): void
	{
		$this->tableName = $tableName;
	}

	public function getById(int $id)
	{
		return DB::getById($this->tableName, $id);
	}

	public function find(string $row, string $value)
	{
		return DB::search($this->tableName, $row, $value);
	}
}