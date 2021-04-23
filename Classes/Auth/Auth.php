<?php

namespace App\Auth;

use App\Session\Session;
use App\Usuario\Usuario;

class Auth
{
	/**
	 * @param $email
	 * @param $password
	 * @return bool
	 */
	public function autenticate($email, $password): bool
	{
		$usuario = (new Usuario())->getByEmail($email);

		if ($usuario) {
			if (password_verify($password, $usuario->getPassword())) {
				Session::set('id', $usuario->getId());
				return true;
			}
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function isAuth(): bool
	{
		return Session::has('id');
	}

	public function logOut()
	{
		Session::remove('id');
	}

	/**
	 * @return Usuario|null
	 */
	public function getUsuario(): ?Usuario
	{
		if ($this->isAuth()) return (new Usuario())->getByPk(Session::get('id'));
		return null;
	}
}