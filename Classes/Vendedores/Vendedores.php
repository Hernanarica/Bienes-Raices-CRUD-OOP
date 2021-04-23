<?php


namespace App\Vendedores;


use App\DB\DBConnection;
use PDO;

class Vendedores
{
	protected int    $id_vendedores;
	protected string $nombre;
	protected string $apellido;
	protected string $telefono;

	/**
	 * @return Vendedores[]
	 */
	public function getAll(): array
	{
		$db = DBConnection::getConnection();

		$query = "SELECT * FROM vendedores";
		$stmt  = $db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
	}

	/**
	 * @return int
	 */
	public function getIdVendedores(): int
	{
		return $this->id_vendedores;
	}

	/**
	 * @param int $id_vendedores
	 */
	public function setIdVendedores(int $id_vendedores): void
	{
		$this->id_vendedores = $id_vendedores;
	}

	/**
	 * @return string
	 */
	public function getNombre(): string
	{
		return $this->nombre;
	}

	/**
	 * @param string $nombre
	 */
	public function setNombre(string $nombre): void
	{
		$this->nombre = $nombre;
	}

	/**
	 * @return string
	 */
	public function getApellido(): string
	{
		return $this->apellido;
	}

	/**
	 * @param string $apellido
	 */
	public function setApellido(string $apellido): void
	{
		$this->apellido = $apellido;
	}

	/**
	 * @return string
	 */
	public function getTelefono(): string
	{
		return $this->telefono;
	}

	/**
	 * @param string $telefono
	 */
	public function setTelefono(string $telefono): void
	{
		$this->telefono = $telefono;
	}
}