<?php


namespace App\Session;


class Session
{
	public static function set($key, $value)
	{
		$_SESSION[ $key ] = $value;
	}

	public static function get($key)
	{
		return $_SESSION[ $key ];
	}

	public static function has($key): bool
	{
		return isset($_SESSION[ $key ]);
	}

	public static function remove($key)
	{
		unset($_SESSION[ $key ]);
	}

	public static function flash($key)
	{
		if (self::has($key)) return null;

		$value = self::get($key);
		self::remove($key);

		return $value;
	}
}