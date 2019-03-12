<?php
class Rol_model extends CI_Model {
	
    public function __construct() {
		$this->load->database();
	}

    public function Lista() {
        $query=$this->db->query("select mw.MENU_PADRE,mw2.NOMBRE_MENU AS 'MENU_PADRE_NOMBRE', mw.MENU, mw.NOMBRE_MENU,mw.DESCRIPCION, mw.USUARIO_CREACION, mw.FECHA_CREACION  from mon_menu_web as mw, mon_menu_web as mw2 where mw.MENU_PADRE=mw2.MENU and mw.ESTADO='A';");
        return $query->result_array();
    }
    
    public function Listar() {
        $query = $this->db->query("call getRolesTotal()");
        mysqli_next_result($this->db->conn_id);
        return $query->result_array();
    }
    
    public function GetRol($id) {
        $query= $this->db->query("call getRolIndividual(?)",array($id));
        mysqli_next_result($this->db->conn_id);
        return $query->row_array();
    }
    // funciones finales
    //menus web
    public function GetMenuWebAAsignar($id) {
        $query= $this->db->query("call getMenuWebAAsignar(?)",array($id));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val)
        {
            $cadena.='<li value="'.$val['menu'].'">'.$val['nombre_menu'].'</li>';
        }
        return $cadena;
    }
    
    public function GetMenuWebAsignados($id) {
        $query= $this->db->query("call GetMenuWebAsignados(?)",array($id));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val)
        {
            $cadena.='<li value="'.$val['menu'].'">'.$val['nombre_menu'].'</li>';
        }

        return $cadena;
    }
    
    public function Guardar($op,$id,$nombre) {
        $query= $this->db->query("call abm_rol(?,?,?,?,@estado,@error)",array($op,$id,$nombre,$this->session->usuario));
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
    }
    
    public function ComboRolesTotal($select=null) {
        $query= $this->db->query("call getRolesTotal()");
        mysqli_next_result($this->db->conn_id);
        $cadena="";
        foreach($query->result_array() as  $val)
        {
            if ($val['rol'] == $select) {
			    $cadena.='<option value="'.$val['rol'].'" selected="true">'.$val['nombre_rol'].'</option>';
		    }else{
                $cadena.='<option value="'.$val['rol'].'">'.$val['nombre_rol'].'</option>';
            }
        }
        return $cadena;
    }
    
    public function GuardarRolMenuWeb($operacion,$rol,$menu) {
        $query= $this->db->query("call abm_rol_menu_web(?,?,?,?,@estado,@error)",array($operacion, $rol,$menu,$this->session->usuario));
        //mysqli_next_result($this->db->conn_id);
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
    }
    
    //menus mobile
    public function GetMenuMobileAAsignar($id) {
        $query= $this->db->query("call getMenuMobileAAsignar(?)",array($id));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val)
        {
            $cadena.='<li value="'.$val['menu'].'">'.$val['nombre_menu'].'</li>';
        }

        return $cadena;
    }
    
    public function GetMenuMobileAsignados($id) {
        $query= $this->db->query("call GetMenuMobileAsignados(?)",array($id));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val)
        {
            $cadena.='<li value="'.$val['menu'].'">'.$val['nombre_menu'].'</li>';
        }

        return $cadena;
    }
    
    public function GuardarRolMenuMobile($operacion,$rol,$menu) {
        $query= $this->db->query("call abm_rol_menu_mobile(?,?,?,?,@estado,@error)",array($operacion, $rol,$menu,$this->session->usuario));
        //mysqli_next_result($this->db->conn_id);
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
    }
}