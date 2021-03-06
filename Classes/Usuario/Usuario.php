<?php

namespace App\Usuario;

use App\DB\DBConnection;
use Exception;

class Usuario
{
	protected int    $id;
	protected string $email;
	protected string $password;
	protected array  $propiedades_permitidas = ['id', 'email', 'password'];

	public function massAssigment($data)
	{
		foreach ($this->propiedades_permitidas as $prop) {
			if (isset($data[ $prop ])) {
				$this->$prop = $data[ $prop ];
			}
		}
	}

	/**
	 * @param string $email
	 * @return Usuario|null
	 */
	public function getByEmail(string $email): ?Usuario
	{
		$db = DBConnection::getConnection();

		$query = "SELECT * FROM usuarios WHERE email = ?";
		$stmt  = $db->prepare($query);
		$stmt->execute([$email]);

		if ($usuario = $stmt->fetchObject(self::class)) {
			return $usuario;
		}

		return null;
	}


	public function getByPk(string $pk): ?Usuario
	{
		$db = DBConnection::getConnection();

		$query = "SELECT * FROM usuarios WHERE id = ?";
		$stmt  = $db->prepare($query);
		$stmt->execute([$pk]);

		if ($usuario = $stmt->fetchObject(self::class)) {
			return $usuario;
		}

		return null;
	}


	/**
	 * @param $data
	 * @return bool
	 */
	public function register($data): bool
	{
		$db = DBConnection::getConnection();

		$query = "INSERT INTO usuarios(email, password)
					 VALUES(:email, :password)";

		$stmt  = $db->prepare($query);
		$exito = $stmt->execute([
			'email'    => $_POST[ 'email' ],
			'password' => password_hash($_POST[ 'password' ], PASSWORD_DEFAULT),
		]);

		if (!$exito) {
			return false;
		}

		$data[ 'id' ] = $db->lastInsertId();
		$this->massAssigment($data);

		return true;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId(int $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword(string $password): void
	{
		$this->password = $password;
	}
}