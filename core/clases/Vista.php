<?php
/* Clase Vista.php */
namespace Blockpc\Clases;

final class Vista extends Plantilla {
    private $_variables;
    private $_js;
    private $_css;

    public function __construct() {
        parent::__construct();
        $this->_variables = [];
        $this->_js = '';
        $this->_css = '';
    }

    /**
     * FUNCION renderizar
     * Genera una Vista
     * @param string $vista Una vista
     * @param string $id Un ID de menú
     * @param string $plantilla Una plantilla de HTML
     * @return Devuelve el string con la vista generada
     **/
    public function renderizar(string $vista, string $id = null, string $plantilla = PLANTILLA_POR_DEFECTO) {
        $this->setPlantilla($plantilla);
        $rutaVista = $this->_rutas['vista'] . $vista . ".phtml";
        if ( !is_readable($rutaVista) ) {
            throw new ErrorBlockpc("1070/{$vista}");
        }
        $this->asignar('app_name', APP_NAME);
        $this->asignar('app_version', APP_VERSION);
        $this->asignar('app_sistema', APP_SISTEMA);
        $this->asignar('app_fecha', APP_FECHA);
        $this->asignar('url_base', URL_BASE);
        $this->asignar('url_assets', URL_BASE . 'assets/');
        $this->asignar('ruta_css', $this->_archivos['css']); # Ruta a CSSs de Plantilla
        $this->asignar('ruta_vendor', $this->_archivos['vendor']);
        $this->asignar('ruta_img', $this->_archivos['img']);
        $this->asignar('ruta_js', $this->_archivos['js']);
        $this->asignar('vista_img', $this->_rutas['img']); # Ruta a IMGs de módulos
        $this->asignar('vista_css', $this->_css);
        $this->asignar('vista_js', $this->_js);
        $this->asignar('menu_plantilla', $this->configurarMenu($id));
        ob_start();
        include_once($this->_cabecera);
        include_once($rutaVista);
        include_once($this->_footer);
        $contenido = ob_get_contents();
        ob_get_clean();
        return $contenido;
    }
  
    /**
     * FUNCION setImagen
     * Agrega una imagen a una vista
     * Devuelve URL hacia la imagen
     **/
    public function setImagen(string $imagen)
	{
		$url = $this->_rutas['img'] . $imagen;
		$archivo = RUTA_MODULOS . 'vista' . DS . $this->_controlador . DS . 'img' . DS . $imagen;
		if ( !file_exists($archivo) )
			throw new ErrorBlockpc("La imagen <b>{$imagen}</b> no existe");
		return $url;
	}
  
    /**
     * FUNCION setCSS
     * Agrega CSS a las vistas
     * Devuelve el array con los archivos CSS relacionados a una vista
     **/
    public function setCSS(array $css)
    {
        if ( is_array($css) && count($css) ) {
            for ( $i = 0; $i < count($css); $i++ ) {
                $url = $this->_rutas['css'] . $css[$i] . '.css';
                $archivo = RUTA_MODULOS . 'vista' . DS . $this->_controlador . DS . 'css' . DS . $css[$i] . '.css';
                if ( !file_exists($archivo) )
                    throw new ErrorBlockpc("1080/{$css[$i]}.css"); // Se esperaba un arreglo
                $this->_css .= "<link rel='stylesheet' href='{$url}' />\n";
            }
        } else {
            throw new ErrorBlockpc("1081"); // Se esperaba un arreglo
        }
    }
  
    /**
     * FUNCION setJs
     * Agrega metodos de javascript a las vistas
     * Devuelve el array con los archivos javascript relacionados a una vista
     **/
    public function setJS(array $js)
    {
        if ( is_array($js) && count($js) ) {
            for ( $i = 0; $i < count($js); $i++ ) {
                $url = $this->_rutas['js'] . $js[$i] . ".js";
                $archivo = RUTA_MODULOS . 'vista' . DS . $this->_controlador . DS . 'js' . DS . $js[$i] . '.js';
                if ( !file_exists($archivo) )
                    throw new ErrorBlockpc("1090/{$js[$i]}.js"); // Se esperaba un arreglo
                $this->_js .= "<script src='{$url}'></script>\n";
            }
        } else {
            throw new ErrorBlockpc("1091"); // Se esperaba un arreglo
        } 
    }
  
    /**
	 * FUNCION setURL
	 * Agrega scripts externos de javascript a las vistas
	 * Devuelve el array con los archivos javascript relacionados a una vista
	 **/
	public function setURL(array $url, string $tipo = 'js')
    {
		if ( is_array($url) && count($url) ) {
			for ( $i = 0; $i < count($url); $i++ ) {
                if ( $tipo === "js" ) {
                  $this->_js .= "<script src='{$url[$i]}'></script>\n";
                } else if ( $tipo === "css" ) {
                  $this->_css .= "<link rel='stylesheet' href='{$url[$i]}' />\n";
                } else {
                  throw new ErrorBlockpc("1094/{$tipo}"); // Se esperaba un arreglo
                }
			}
		} else {
			throw new ErrorBlockpc("1091"); // Se esperaba un arreglo
		} 
	}
  
    /**
     * FUNCION asignar
     * Asigna variables a una vista
     * @param string $buscar string a buscar
     * @param string $reemplazar string a reemplazar
     **/
    public function asignar($buscar, $reemplazar)
    {
        if ( array_key_exists($buscar, $this->_variables) ) {
            throw new ErrorBlockpc("Error 1060. {$buscar} no se puede asignar.");
        }
        if ( !empty($buscar) ) {
            $this->_variables[strtoupper($buscar)] = $reemplazar;
        }
    }
  
    /**
	 * FUNCION getVariables
     * Retorna las variables de una vista
     * @return array
     **/
    public function getVariables()
    {
        return $this->_variables;
    }

	/**
	 * FUNCION setWidgets
     * Retorna las variables de una vista
     * @return array
     **/
    public function setWidgets($widget, $metodo, $opciones = array())
    {
        if ( !is_array($opciones) ) {
            $opciones = array($opciones);
        }
        $rutaWidget = RUTA_WIDGETS . $widget . 'Widget.php';
        if ( is_readable($rutaWidget) ) {
            $claseWidget = "Widgets\\{$widget}Widget";
            if ( !class_exists($claseWidget) ) {
                throw new ErrorBlockpc("7003/{$claseWidget}");
            }
            if ( is_callable($claseWidget, $metodo) ) {
                if ( count($opciones) ) {
                    return call_user_func_array( array(new $claseWidget, $metodo), $opciones);
                } else {
                    return call_user_func(array(new $claseWidget, $metodo));
                }
            }
            throw new ErrorBlockpc("7004/{$metodo}");
        }
        throw new ErrorBlockpc("7002/{$widget}");
    }
}