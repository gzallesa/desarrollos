<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Vista{

	protected $CI;

	public function __construct() {
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
		$this->CI->load->helper('form');
		$this->CI->load->model("menuwebopcion_model");
	}

	public function SetView($view, $data=null) {
		$data['menu_html'] = $this->_GenerarMenu();
		$this->CI->load->view("MasterPage/head",$data);
		$this->CI->load->view($view);
		$this->CI->load->view("MasterPage/footer");
	}

	public function SetLogin($datos = false) {
		if($datos) {
			$this->CI->load->view("login/login_vista", $datos);
		} else {
			$this->CI->load->view("login/login_vista");
		}
	}

	private function _GenerarMenu() {
		$menu_usuario = $this->CI->session->menu;
		$menu_html="";
		if($menu_usuario!=null) {
			$m_padreActual=$menu_usuario[0]["NOMBRE_MENU_PADRE"]!=null?$menu_usuario[0]["NOMBRE_MENU_PADRE"]:$menu_usuario[0]["NOMBRE_MENU"];
			$menu_padre[$m_padreActual]=array();
			foreach($menu_usuario as $menu ) {       
				/*if($menu["NOMBRE_MENU_PADRE"]!=null) {
				if(!array_key_exists($menu["NOMBRE_MENU_PADRE"], $menu_padre))
				{
				$m_padreActual=$menu["NOMBRE_MENU_PADRE"];
				$menu_padre[$m_padreActual]=array();
				}
				}*/
				$mm_padreActual=$menu["NOMBRE_MENU_PADRE"]!=null?$menu["NOMBRE_MENU_PADRE"]:$menu["NOMBRE_MENU"];

				if(!array_key_exists($mm_padreActual, $menu_padre)){
					$m_padreActual=$mm_padreActual;
					$menu_padre[$m_padreActual]=array();
				}
                    
				if($m_padreActual!=$menu["NOMBRE_MENU_PADRE"]){
					$m_padreActual=$menu["NOMBRE_MENU_PADRE"];
				}
				if($m_padreActual!=null) {
					$con = $this->CI->menuwebopcion_model->GetMenuWebOpcionAsignadosArray($menu["ROL_MENU_WEB"], $menu["MENU"]);	
			        /*foreach($con as  $val) {
			            $cadena.='<li value="'.$val['menu_web_opcion'].'">'.$val['nombre_opcion'].'</li>';
			        }*/
					array_push($menu_padre[$m_padreActual] , array($menu["NOMBRE_MENU"], $menu["DESCRIPCION"], $menu["MENU"], $menu["ROL_MENU_WEB"], "OPCIONES" => $con));					
				}
			}
			
			$this->CI->session->set_userdata(array('menu_padre' => $menu_padre));

			foreach($menu_padre as $key => $submenu){
				$menu_html.='<div title="'.$key.'" data-options="iconCls:\'icono-grid\',collapsed:false,collapsible:false" style="overflow:auto;padding:10px;">';
				foreach($submenu as $_menu) {
					if(substr($_menu[1], 0, 4) == 'http') {
						$menu_html.='<p><a target="_blank" href=\''.($_menu[1]!=null?$_menu[1]:'#').'\' style="color:#0099FF;">'.$_menu[0].'</a></p>';
					} else {
						$menu_html.='<p><a href=\''.base_url().($_menu[1]!=null?$_menu[1]:'#').'\' style="color:#0099FF;">'.$_menu[0].'</a></p>';
					}
				}
				$menu_html.='</div>';
			}
		}
		return $menu_html;
	}
}
?>