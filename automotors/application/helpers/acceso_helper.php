<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

function verificar_acceso($menu_id, $accion = false) {
	$CI = & get_instance();
	$menu = $CI->session->userdata('menu');

	if(isset($menu_id)) {
		foreach($menu as $item) {
			if($item['MENU'] == $menu_id) {
				if($accion) {
					$menuPadre = $CI->session->userdata('menu_padre');
					foreach($menuPadre[$item['NOMBRE_MENU_PADRE']] as $subMenu) {
						if($menu_id == $subMenu[2]) {
							foreach($subMenu['OPCIONES'] as $opcionMenu) {
								if($opcionMenu['menu_web_opcion'] == $accion) {
									return true;
								}
							}
							
						}
					}
				} else {
					return true;
				}
			}
		}
		return false;
	}
}

function cargarBreadCrumb($menuId, $accion = false, $item = false) {
	$CI = & get_instance();
//	$CI->load->library('breadcrumbs');
	// add breadcrumbs
	$CI->breadcrumbs->push('Inicio', '/');
	switch($menuId) {
		case '10002': {
			$Entidad = 'Usuario';
			$CI->breadcrumbs->push('Usuario', '/usuarios');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			} elseif ($accion == 'read') {
				$CI->breadcrumbs->push('Ver '.$Entidad, '/read');				
			} elseif ($accion == 'georeferencia') {
				$CI->breadcrumbs->push('Georeferenciar '.$Entidad, '/georeferencia');				
			}
		}
		break;
		case '10003': {
			$Entidad = 'Rol';
			$CI->breadcrumbs->push('Rol', '/rol');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10004': {
			$Entidad = 'Menu Web';
			$CI->breadcrumbs->push('Menu Web', '/menuweb');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10005': {
			$Entidad = 'Menu Mobile';
			$CI->breadcrumbs->push('Menu Mobile', '/menumobile');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10006': {
			$Entidad = 'Rol Menu Web';
			$CI->breadcrumbs->push('Rol Menu Web', '/rolMenuWeb');
		}
		break;
		case '10007': {
			$Entidad = 'Rol Menu Mobile';
			$CI->breadcrumbs->push('Rol Menu Mobile', '/rolMenuMobile');
		}
		break;
		case '10008': {
			$Entidad = 'Menu Web Opcion';
			$CI->breadcrumbs->push('Menu Web Opcion', '/menuWebOpcion');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10009': {
			$Entidad = 'Menu Mobile Opcion';
			$CI->breadcrumbs->push('Menu Mobile Opcion', '/menuMobOpcion');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10010': {
			$Entidad = 'Rol Menu Web Opcion';
			$CI->breadcrumbs->push('Rol Menu Web Opcion', '/rolMenuWebOpcion');
		}
		break;
		case '10011': {
			$Entidad = 'Rol Menu Mobile Opcion';
			$CI->breadcrumbs->push('Rol Menu Mobile Opcion', '/rolMenuMobileOpcion');
		}
		break;
		case '10022': {
			$Entidad = 'Zona';
			$CI->breadcrumbs->push('Zonas', '/zonas');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			} elseif ($accion == 'read') {
				$CI->breadcrumbs->push('Ver '.$Entidad, '/read');				
			}
		}
		break;
		case '10023': {
			$Entidad = 'Camion';
			$CI->breadcrumbs->push('Camiones', '/camiones');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			} elseif ($accion == 'read') {
				$CI->breadcrumbs->push('Ver '.$Entidad, '/read');				
			}
		}
		break;
		case '10024': {
			$Entidad = 'Sucursal';
			$CI->breadcrumbs->push('Sucursales', '/almacenes');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			} elseif ($accion == 'read') {
				$CI->breadcrumbs->push('Ver '.$Entidad, '/read');				
			} elseif ($accion == 'georeferencia') {
				$CI->breadcrumbs->push('Georeferenciar '.$Entidad." ($item)", '/georeferencia');				
			}
		}
		break;
		case '10025': {
			$Entidad = 'Personal';
			$CI->breadcrumbs->push('Personal', '/personal');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			} elseif ($accion == 'read') {
				$CI->breadcrumbs->push('Ver '.$Entidad, '/read');				
			} elseif ($accion == 'georeferencia') {
				$CI->breadcrumbs->push('Georeferenciar '.$Entidad." ($item)", '/georeferencia');
			} elseif ($accion == 'delete'){
				$CI->breadcrumbs->push('Inactivar '.$Entidad, '/inactivar');
			}
		}
		break;
		case '10026': {
			$Entidad = 'Almacen/Camiones';
			$CI->breadcrumbs->push('Almacen/Camiones', '/camiones');
		}
		break;
		case '10027': {
			$Entidad = 'Chofer/Camion';
			$CI->breadcrumbs->push('Chofer/Camion', '/camiones');
		}
		break;
		case '10028': {
			$Entidad = 'Encargado/Almacen';
			$CI->breadcrumbs->push('Encargado/Almacen', '/personal');
		}
		break;
		case '10042': {
			$Entidad = 'Reportes';
			$CI->breadcrumbs->push('Reportes VRS', '/reporte');
		}
		break;
		case '10029':{
			$Entidad = 'Medios Contacto';
			$CI->breadcrumbs->push('Medios Contacto ', '/mediosContacto');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10030':{
			$Entidad = 'Proveedores';
			$CI->breadcrumbs->push('Proveedores', '/proveedor');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			} elseif ($accion == 'georeferencia') {
				$CI->breadcrumbs->push('Georeferenciar '.$Entidad." ($item)", '/georeferencia');
			}
		}
		break;
		case '10031':{
			$Entidad = 'Ip';
			$CI->breadcrumbs->push('Ip', '/ip');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10032':{
			$Entidad = 'Acceso';
			$CI->breadcrumbs->push('Acceso', '/acceso');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10033':{
			$Entidad = 'Equipo';
			$CI->breadcrumbs->push('Equipo', '/equipo');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10034':{
			$Entidad = 'Personal-Equipo';
			$CI->breadcrumbs->push('Personal-Equipo', '/personalEquipo');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Asingar '.$Entidad, '/add');
			} elseif ($accion == 'query') {
				$CI->breadcrumbs->push('Consultar '.$Entidad, '/query');				
			}
		}
		break;
		case '10054':{
			$Entidad = 'Dominio';
			$CI->breadcrumbs->push('Dominio', '/dominio');
			if ($accion == 'addC') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/addC');
			}elseif ($accion == 'addD'){
				$CI->breadcrumbs->push('Registrar Detalle '.$Entidad, '/addD');
			}elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10062':{
			$Entidad = 'Datos Personal';
			$CI->breadcrumbs->push('Datos Personal', '/datospersonal');
			if ($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			}elseif ($accion == 'query') {
				$CI->breadcrumbs->push('Consultar '.$Entidad, '/query');
			}elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10063':{
			$Entidad = 'Planilla Mensual';
			$CI->breadcrumbs->push('Planilla Mensual', '/planilla');
			if ($accion == 'excel') {
				$CI->breadcrumbs->push('Exportar '.$Entidad, '/excel');
			}elseif ($accion == 'asiento') {
				$CI->breadcrumbs->push('Asiento '.$Entidad, '/asiento');
			}
		}
		break;
		case '10064':{
			$Entidad = 'Faltas';
			$CI->breadcrumbs->push('Faltas', '/falta');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10065':{
			$Entidad = 'Planilla CMO';
			$CI->breadcrumbs->push('Planilla CMO', '/planillacmo');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10066':{
			$Entidad = 'Planilla Total';
			$CI->breadcrumbs->push('Planilla Total', '/planillatotal');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10067':{
			$Entidad = 'Comision variable';
			$CI->breadcrumbs->push('Comision variable', '/comision');
			if($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			} elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10068':{
			$Entidad = 'Bonos - Deducciones';
			$CI->breadcrumbs->push('Bonos - Deducciones', '/bonodeduccion');
			if ($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			}elseif ($accion == 'query') {
				$CI->breadcrumbs->push('Consultar '.$Entidad, '/query');
			}elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}
		break;
		case '10081':{
			$Entidad = 'Cuentas Contables Planillas';
			$CI->breadcrumbs->push('Cuentas Contables Planillas', '/cuentacontableplanilla');
			if ($accion == 'detail') {
				$CI->breadcrumbs->push('Detalle '.$Entidad, '/detail');		
			}
		}
		break;
		case '10082':{
			$Entidad = 'Boletas';
			$CI->breadcrumbs->push('Boletas', '/boleta');
			if ($accion == 'Imprimir') {
				$CI->breadcrumbs->push($Entidad, '/imprimir');
			}
		}
		break;
		case '10083':{
			$Entidad = 'Boletas Individuales';
			$CI->breadcrumbs->push('Boletas Individuales', '/boleta_ind');
			if ($accion == 'Imprimir') {
				$CI->breadcrumbs->push($Entidad, '/imprimir');
			}
		}			
		break;
		case '10091':{
			$Entidad = 'Comprobante Egreso';
			$CI->breadcrumbs->push('Comprobante Egreso', '/comprobanteegreso');
			if ($accion == 'add') {
				$CI->breadcrumbs->push('Registrar '.$Entidad, '/add');
			}elseif ($accion == 'query') {
				$CI->breadcrumbs->push('Consultar '.$Entidad, '/query');
			}elseif ($accion == 'edit') {
				$CI->breadcrumbs->push('Editar '.$Entidad, '/edit');				
			}
		}	
		default:
		break;		
	}
	$breadCrumb = $CI->breadcrumbs->show();
	return $breadCrumb;
}
?>  