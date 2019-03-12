<?php

class MenuMobOpcion_model extends CI_Model
{
    public function Combo($select=null)
    {
        $query= $this->db->query("call getMenuMobileTotal()");
        mysqli_next_result($this->db->conn_id);
        $cadena="";
        foreach($query->result_array() as  $val)
        {
            if ($val['menu'] == $select) {
			    $cadena.='<option value="'.$val['menu'].'" selected="true">'.$val['nombre_menu'].'</option>';
		    }else{
                $cadena.='<option value="'.$val['menu'].'">'.$val['nombre_menu'].'</option>';
            }
        }
        return $cadena;
    }
    public function Lista($id)
    {
        $query=$this->db->query("call getOpcionMobTotal(?)",array($id));
        mysqli_next_result($this->db->conn_id);
        return $query->result_array();
    }
    public function GetOpcionMenuMobile($menu,$id)
    {
        $query= $this->db->query("call getOpcionMobIndividual(?,?)",array($menu, $id));
        mysqli_next_result($this->db->conn_id);
        return $query->row_array();
    }
    public function Guardar($op,$id,$menu,$nombre,$descripcion)
    {
//        echo 'OP:'.$op.',';
//    	echo 'ID:'.$id.',';
//    	echo 'MENU:'.$menu.',';
//    	echo 'NOMBRE:'.$nombre.',';
//    	echo 'DESCR:'.$descripcion.',</b>';
//    	echo 'CALL:'.$descripcion.',</b>';
        $query= $this->db->query("call abm_menu_mob_opcion(?,?,?,?,?,?,@estado,@error)",array($op,$id,$menu,$nombre,$descripcion,$this->session->usuario));
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
    }
    
    public function lista_rmm() {
//        $query = $this->db->query("SELECT CONCAT(rol_menu_mobile,'_',menu) as llave, rol_menu_mobile, rol, menu FROM mon_rol_menu_mobile WHERE fecha_eliminacion is null");
		$query = $this->db->query("SELECT CONCAT(rmm.rol_menu_mobile,'_',rmm.menu) as llave, r.nombre_rol, mm.nombre_menu
									FROM mon_rol_menu_mobile rmm
									     INNER JOIN mon_rol r ON rmm.ROL = r.ROL
									     INNER JOIN mon_menu_mobile mm ON rmm.MENU = mm.MENU AND mm.estado = 'A'
									WHERE rmm.fecha_eliminacion is null");
        return $query->result_array();
    }
    
    public function GuardarRolMenuMobOpcion($operacion, $rmw, $mwo) {
        $query= $this->db->query("call abm_rol_menu_mobile_opcion(?,?,?,?,@estado,@error)",array($operacion, $rmw,$mwo,$this->session->usuario));
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
    }
    
    public function GetMenuMobOpcionAAsignar($id, $menu) {
        $query= $this->db->query("call getMenuMobOpcionAAsignar(?, ?)",array($id, $menu));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val)
        {
            $cadena.='<li value="'.$val['menu_mob_opcion'].'">'.$val['nombre_opcion'].'</li>';
        }

        return $cadena;
    }
    
    public function GetMenuMobOpcionAsignados($id, $menu) {
        $query= $this->db->query("call getMenuMobOpcionAsignados(?, ?)",array($id, $menu));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val) {
            $cadena.='<li value="'.$val['menu_mob_opcion'].'">'.$val['nombre_opcion'].'</li>';
        }
        return $cadena;
    }
}