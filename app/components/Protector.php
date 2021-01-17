<?php

namespace App\components;


class Protector
{
	public static function check($protectorsList): bool
	{
		if (is_null($protectorsList)) return true;
		return false;
	}
}