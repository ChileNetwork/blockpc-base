<?php
/* navegacion.php */
function getMenus() {
	$menus = [
		[
		'id'     => 'inicio',
		'titulo' => '<i class="fas fa-xs fa-home mr-1" aria-hidden="true"></i> Inicio',
		'enlace' => URL_BASE
		],
		[
		'id'     => 'instalador',
		'titulo' => '<i class="fas fa-xs fa-cogs mr-1" aria-hidden="true"></i> Instalador',
		'enlace' => URL_BASE . 'instalador'
		]
	];
	return $menus;
}