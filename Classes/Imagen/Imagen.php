<?php

namespace App\Imagen;

use App\DB\DBConnection;

class Imagen
{
	protected string $tmpName;
	protected string $originalName;
	protected string $mimeType;
	protected int    $size;
	protected string $filename;
	protected string $extension;

	/**
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->tmpName      = $data[ 'tmp_name' ];
		$this->originalName = $data[ 'name' ];
		$this->mimeType     = $data[ 'type' ];
		$this->size         = $data[ 'size' ];
	}

	/**
	 * Guarda el archivo en el $path indicado.
	 * Retorna el nombre del archivo generado.
	 *
	 * @param string $path
	 * @return string
	 */
	public function guardar(string $path): string
	{
		$this->filename = $this->generarNombre($this->originalName);
		move_uploaded_file($this->tmpName, $path . $this->filename);
		return $this->filename;
	}

	/**
	 * Genera un nombre para el archivo.
	 *
	 * @param string $originalName
	 * @return string
	 */
	protected function generarNombre(string $originalName): string
	{
		$this->extension = $this->obtenerExtension($originalName);
		return date('Y-m-d_H-i-s') . "." . $this->extension;
	}

	/**
	 * Retorna la extensión del $nombre del archivo.
	 *
	 * @param $nombre
	 * @return string
	 */
	protected function obtenerExtension($nombre): string
	{
		$ultimoPunto = strrpos($nombre, '.');
		return substr($nombre, $ultimoPunto + 1);
	}
}