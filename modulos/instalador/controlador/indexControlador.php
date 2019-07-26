<?php
/* Clase indexControlador.php */
namespace Instalador\Controlador;

use Blockpc\Clases\Controlador;
use Blockpc\Clases\Sesion;

final class indexControlador extends Controlador
{
    private $_token;
	private $_plantilla;

    public function __construct() {
        $this->construir();
        $this->_token = $this->genToken();
		$this->_vista->asignar('error', '');
		$this->_vista->asignar('mensaje', '');
		$this->_plantilla = PLANTILLA_POR_DEFECTO;
    }
	
	public function index()
	{
		try {
			$this->_vista->asignar('titulo', 'Instalador - Inicio');
		} catch(\Exception $e) {
			$error = $this->cargarHTML('error', ['error' => $e->getMessage()], $this->_plantilla);
            $this->_vista->asignar('error', $error);
		}
		$this->_vista->setCSS(['inicio']);
		$this->cargarPagina($this->_vista->renderizar('index', 'instalador', $this->_plantilla));
	}
	
	public function instalacion()
	{
		try {
			$this->_vista->asignar('titulo', 'Instalador - Instalación');
		} catch(\Exception $e) {
			$error = $this->cargarHTML('error', ['error' => $e->getMessage()], $this->_plantilla);
            $this->_vista->asignar('error', $error);
		}
		$this->_vista->setCSS(['inicio']);
		$this->cargarPagina($this->_vista->renderizar('instalacion', 'instalador', $this->_plantilla));
	}
	
	public function configuracion()
	{
		try {
			$this->_vista->asignar('titulo', 'Instalador - Configuración');
		} catch(\Exception $e) {
			$error = $this->cargarHTML('error', ['error' => $e->getMessage()], $this->_plantilla);
            $this->_vista->asignar('error', $error);
		}
		$this->_vista->setCSS(['inicio']);
		$this->cargarPagina($this->_vista->renderizar('configuracion', 'instalador', $this->_plantilla));
	}
	
}