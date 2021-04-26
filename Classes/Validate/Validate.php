<?php


namespace App\Validate;


use App\Exception\InvalidRuleException;

/**
 * Class Validate
 *
 * Se encarga de validar los datos
 * ingresados y notificar si hay errores
 * o si los datos son correctos.
 *
 * @package App\Validate
 */
class Validate
{
	/** @var array Valores que voy a validar. */
	protected array $campos = [];
	/** @var array reglas con las que voy a validar los datos. */
	protected array $reglas = [];
	/** @var array errores que voy guardando de los datos que no pasen la validación */
	protected array $errores = [];

	/**
	 * Validate constructor.
	 * @param array $campos
	 * @param array $reglas
	 * @throws InvalidRuleException
	 */
	public function __construct(array $campos, array $reglas)
	{
		$this->campos = $campos;
		$this->reglas = $reglas;

		$this->validate();
	}

	/**
	 *Valida los campos con las reglas provistas.
	 * @throws InvalidRuleException
	 */
	public function validate()
	{
		foreach ($this->reglas as $nombreCampo => $reglasCampo) {
			$this->applyRules($nombreCampo, $reglasCampo);
		}
	}

	/**
	 * Aplica la regla de validación
	 *  a un campo.
	 *
	 * @param $nombreCampo
	 * @param $reglasCampo
	 * @throws InvalidRuleException
	 */
	public function applyRules($nombreCampo, $reglasCampo)
	{
		foreach ($reglasCampo as $regla) {
			$this->executeRule($nombreCampo, $regla);
		}
	}

	/**
	 * Ejecuta la validación de la regla
	 * a un campo.
	 *
	 * @param $nombreCampo
	 * @param $regla
	 * @throws InvalidRuleException
	 */
	public function executeRule($nombreCampo, $regla)
	{
//		Ver sección "Reglas de validación".
		if (!str_contains($regla, ':')) {
//		creamos el metodo de forma dinámica.
			$metodo = "_{$regla}";

			if (!method_exists($this, $metodo)) {
				throw new InvalidRuleException("No existe la regla de validación {$regla}");
			}
//		ejecutamos el metodo pasandole el campo
			$this->$metodo($nombreCampo);
		} else {
			$partes   = explode(':', $regla);
			$metodo   = "_{$partes[0]}";
			$cantidad = preg_replace("[^A-Za-z0-9]", '', $partes[ 1 ]);

			if (!method_exists($this, $metodo)) {
				throw new InvalidRuleException("No existe la regla de validación {$regla}");
			}
			if (!is_numeric($cantidad)) {
				throw new InvalidRuleException("No existe la regla de validación {$regla}");
			}

			$this->_min($nombreCampo, $partes[ 1 ]);
		}
	}

	/**
	 * @return bool
	 */
	public function passes(): bool
	{
		return count($this->errores);
	}

	/**
	 * retorna los errores de validación ocurridos.
	 *
	 * @return array
	 */
	public function getErrores(): array
	{
		return $this->errores;
	}

	/**
	 * Agrega el mensaje de error para el $campo.
	 *
	 * @param $campo
	 * @param $mensaje
	 */
	public function addError($campo, $mensaje)
	{
//		si el campo no existe como error entra.
		if (!isset($this->errores[ $campo ])) {
			$this->errores[ $campo ] = [];
		}

//		Pusheo los mensajes distintos mensajes de error.
		$this->errores[ $campo ][] = $mensaje;
	}

	/*
	 |-------------------------------------------------------------------------------------------------
	 | Reglas de validación
	 |-------------------------------------------------------------------------------------------------
	 |Para poder agregar en un futuro más reglas de validación.
	 |Vamos a definir cada regla como un método(_method) protegido para que solo sea
	 |de uso interno.
	 |Nota: El "_" servirá para dar a entender que ese método es de uso interno
	 |y para no causar confusión a la hora de llamar más métodos.
	 |Si el método recibe parámetros extra, serán pasados como argumento.
	*/

	/**
	 * Verifica que el campo no esté vacío.
	 *
	 * @param $campo
	 */
	public function _required($campo)
	{
		$valor = $this->campos[ $campo ];
		if (empty($valor)) {
			$this->addError($campo, "El campo {$campo} no puede estar vacío.");
		}
	}

	/**
	 * Verifica que el campo sea un número.
	 *
	 * @param $campo
	 */
	public function _numeric($campo)
	{
		$valor = $this->campos[ $campo ];
		if (!is_numeric($valor)) {
			$this->addError($campo, "El campo {$campo} debe ser un número.");
		}
	}

	/**
	 * Verifica que el campo tenga determinada
	 * cantidad de letras.
	 *
	 * @param $campo
	 * @param $cantidad
	 */
	public function _min($campo, $cantidad)
	{
		$valor = $this->campos[ $campo ];
		if (strlen($valor) < $cantidad) {
			$this->addError($campo, "El campo {$campo} debe tener al menos {$cantidad} caracteres.");
		}
	}
}