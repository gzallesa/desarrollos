<?php

class MenuWebOpcion_model extends CI_Model
{
    public function Combo($select=null)
    {
        $query= $this->db->query("call getMenuWebTotal()");
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
        $query=$this->db->query("call getOpcionWebTotal(?)",array($id));
        mysqli_next_result($this->db->conn_id);
        return $query->result_array();
    }
    public function GetOpcionMenuWeb($menu,$id)
    {
        $query= $this->db->query("call getOpcionWebIndividual(?,?)",array($menu, $id));
        mysqli_next_result($this->db->conn_id);
        return $query->row_array();
    }
    public function Guardar($op,$id,$menu,$nombre,$descripcion)
    {
//    	echo 'OP:'.$op.',';
//    	echo 'ID:'.$id.',';
//    	echo 'MENU:'.$menu.',';
//    	echo 'NOMBRE:'.$nombre.',';
//    	echo 'DESCR:'.$descripcion.',</b>';
//    	echo 'CALL:'.$descripcion.',</b>';
        $query= $this->db->query("call abm_menu_web_opcion(?,?,?,?,?,?,@estado,@error)",array($op,$id,$menu,$nombre,$descripcion,$this->session->usuario));
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
    }
    
    public function lista_rmw() {
        $query = $this->db->query("SELECT CONCAT(rmw.rol_menu_web,'_',rmw.menu) as llave, rmw.menu, r.nombre_rol, mw.nombre_menu 
        							FROM mon_rol_menu_web rmw 
     									INNER JOIN mon_rol r ON rmw.ROL = r.ROL 
     									INNER JOIN mon_menu_web mw ON rmw.MENU = mw.MENU AND mw.estado = 'A'
     									WHERE rmw.fecha_eliminacion is null");
        return $query->result_array();
    }
    
    public function GetMenuWebOpcionAAsignar($id, $menu) {
        $query= $this->db->query("call getMenuWebOpcionAAsignar(?, ?)",array($id, $menu));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val)
        {
            $cadena.='<li value="'.$val['menu_web_opcion'].'">'.$val['nombre_opcion'].'</li>';
        }

        return $cadena;
    }
    
    public function GetMenuWebOpcionAsignados($id, $menu) {
        $query= $this->db->query("call getMenuWebOpcionAsignados(?, ?)",array($id, $menu));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val) {
            $cadena.='<li value="'.$val['menu_web_opcion'].'">'.$val['nombre_opcion'].'</li>';
        }
        return $cadena;
    }
    
    public function GuardarRolMenuWebOpcion($operacion, $rmw, $mwo) {
//    	echo 'OP: '.$operacion;
//    	echo '; RMW: '.$rmw;
//    	echo '; MWO: '.$mwo;
        $query= $this->db->query("call abm_rol_menu_web_opcion(?,?,?,?,@estado,@error)",array($operacion, $rmw,$mwo,$this->session->usuario));
        //mysqli_next_result($this->db->conn_id);
        $query=$this->db->query("select @estado, @error");
//        print_r($query);
        return $query->row_array();
    }
    
    public function GetMenuWebOpcionAsignadosArray($id, $menu) {
        $query= $this->db->query("call getMenuWebOpcionAsignados(?, ?)",array($id, $menu));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        return $con;
    }
}