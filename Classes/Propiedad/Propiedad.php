<?php

namespace App\Propiedad;

use App\DB\DBConnection;
use PDO;
use JsonSerializable;
use Exception;

class Propiedad implements JsonSerializable
{
	protected int    $id_propiedades;
	protected string $titulo;
	protected float  $precio;
	protected string $imagen;
	protected string $descripcion;
	protected int    $habitaciones;
	protected int    $wc;
	protected int    $estacionamiento;
	protected string $fecha_creacion;
	protected int    $fk_id_vendedores;
	/**
	 * Lista de propiedades que voy a mapear
	 * con mi base de datos y a auto asignar data
	 * que llega de mi formulario.
	 *
	 * @var array|string[]
	 */
	protected array $propiedades_permitidas = [
		'titulo',
		'precio',
		'imagen',
		'descripcion',
		'habitaciones',
		'wc',
		'estacionamiento',
		'fecha_creacion',
		'fk_id_vendedores'
	];


	public function jsonSerialize()
	{
		return [
			'id_propiedades'   => $this->getIdPropiedades(),
			'titulo'           => $this->getTitulo(),
			'precio'           => $this->getPrecio(),
			'imagen'           => $this->getImagen(),
			'descripcion'      => $this->getDescripcion(),
			'habitaciones'     => $this->getHabitaciones(),
			'wc'               => $this->getWc(),
			'estacionamiento'  => $this->getEstacionamiento(),
			'fecha_cracion'    => $this->getFechaCreacion(),
			'fk_id_vendedores' => $this->getFkIdVendedores(),
		];
	}

	/**
	 * Auto asigna de forma masiva la data
	 * del formulario a mis propiedades
	 * siempre y cuando existan.
	 *
	 * @param array $data
	 */
	public function massAssigment(array $data)
	{
		foreach ($this->propiedades_permitidas as $prop) {
			if (isset($data[ $prop ])) {
				$this->$prop = $data[ $prop ];
			}
		}
	}

	/**
	 * @return Propiedad[]
	 */
	public function getAll(): array
	{
		$db = DBConnection::getConnection();

		$query = "SELECT * FROM propiedades";
		$stmt  = $db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
	}

	/**
	 * @param array $data
	 * @return bool
	 * @throws Exception
	 */
	public function create(array $data): bool
	{
		$db = DBConnection::getConnection();

		$query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc,fecha_creacion, estacionamiento, fk_id_vendedores)
					 VALUES(:titulo, :precio, :imageName, :descripcion, :habitaciones, :wc, :fecha_creacion ,:estacionamiento, :fk_id_vendedores)";

		$stmt  = $db->prepare($query);
		$exito = $stmt->execute([
			'titulo'           => $data[ 'titulo' ],
			'precio'           => $data[ 'precio' ],
			'imageName'        => $data[ 'imagen' ],
			'descripcion'      => $data[ 'descripcion' ],
			'habitaciones'     => $data[ 'habitaciones' ],
			'wc'               => $data[ 'wc' ],
			'fecha_creacion'   => $data[ 'fecha_creacion' ],
			'estacionamiento'  => $data[ 'estacionamiento' ],
			'fk_id_vendedores' => $data[ 'fk_id_vendedores' ],
		]);

		if (!$exito) {
			throw new Exception('Hubo un error al intentar crear la propiedad.');
		}

		$this->setIdPropiedades($db->lastInsertId());
		$this->massAssigment($data);
		return true;
	}


	/**
	 * @param $pk
	 * @param $imageName
	 * @return bool
	 */
	public function delete($pk, $imageName): bool
	{
		$db   = DBConnection::getConnection();
		$path = '../test-images/';

		$query = "DELETE FROM propiedades WHERE id_propiedades = ?";
		$stmt  = $db->prepare($query);
		$exito = $stmt->execute([$pk]);

		if (!$exito) {
			return false;
		}

		unlink($path . "{$imageName}");
		return true;
	}

	public function getByPk($pk)
	{
		$db = DBConnection::getConnection();

		$query = "SELECT * FROM propiedades WHERE id_propiedades = ?";
		$stmt  = $db->prepare($query);
		$stmt->execute([$pk]);
		return $stmt->fetchObject(self::class);
	}


	/**
	 * @return int
	 */
	public function getIdPropiedades(): int
	{
		return $this->id_propiedades;
	}

	/**
	 * @param int $id_propiedades
	 */
	public function setIdPropiedades(int $id_propiedades): void
	{
		$this->id_propiedades = $id_propiedades;
	}

	/**
	 * @return string
	 */
	public function getTitulo(): string
	{
		return $this->titulo;
	}

	/**
	 * @param string $titulo
	 */
	public function setTitulo(string $titulo): void
	{
		$this->titulo = $titulo;
	}

	/**
	 * @return float
	 */
	public function getPrecio(): float
	{
		return $this->precio;
	}

	/**
	 * @param float $precio
	 */
	public function setPrecio(float $precio): void
	{
		$this->precio = $precio;
	}

	/**
	 * @return string
	 */
	public function getImagen(): string
	{
		return $this->imagen;
	}

	/**
	 * @param string $imagen
	 */
	public function setImagen(string $imagen): void
	{
		$this->imagen = $imagen;
	}

	/**
	 * @return string
	 */
	public function getDescripcion(): string
	{
		return $this->descripcion;
	}

	/**
	 * @param string $descripcion
	 */
	public function setDescripcion(string $descripcion): void
	{
		$this->descripcion = $descripcion;
	}

	/**
	 * @return int
	 */
	public function getHabitaciones(): int
	{
		return $this->habitaciones;
	}

	/**
	 * @param int $habitaciones
	 */
	public function setHabitaciones(int $habitaciones): void
	{
		$this->habitaciones = $habitaciones;
	}

	/**
	 * @return int
	 */
	public function getWc(): int
	{
		return $this->wc;
	}

	/**
	 * @param int $wc
	 */
	public function setWc(int $wc): void
	{
		$this->wc = $wc;
	}

	/**
	 * @return int
	 */
	public function getEstacionamiento(): int
	{
		return $this->estacionamiento;
	}

	/**
	 * @param int $estacionamiento
	 */
	public function setEstacionamiento(int $estacionamiento): void
	{
		$this->estacionamiento = $estacionamiento;
	}

	/**
	 * @return string
	 */
	public function getFechaCreacion(): string
	{
		return $this->fecha_creacion;
	}

	/**
	 * @param string $fecha_creacion
	 */
	public function setFechaCreacion(string $fecha_creacion): void
	{
		$this->fecha_creacion = $fecha_creacion;
	}

	/**
	 * @return int
	 */
	public function getFkIdVendedores(): int
	{
		return $this->fk_id_vendedores;
	}

	/**
	 * @param int $fk_id_vendedores
	 */
	public function setFkIdVendedores(int $fk_id_vendedores): void
	{
		$this->fk_id_vendedores = $fk_id_vendedores;
	}
}