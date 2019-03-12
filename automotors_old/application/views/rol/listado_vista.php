<table id="tt" class="easyui-datagrid"  
        title="Load Data" iconCls="icon-save"
        rownumbers="true" pagination="true" singleSelect="true" toolbar="#toolbar"
        data-options="onBeforeSelect:function(){return false;}," >
    <thead>
        <tr>
            <th field="rol" width="80">Rol</th>
            <th field="nombre_rol" >Nombre de rol</th>
            <th field="estado"  align="right">Estado</th>
            <th field="desc_estado" align="right">Descripción</th>
            <th data-options="field:'ACCION'" formatter="BotonesAccion">Accion</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
	<?php if(isset($acc_registrar) && $acc_registrar == 'R_I'):?>
    	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="nuevo_registro()">Nuevo Registro</a>
    <?php endif;?>
</div>
    <script type="text/javascript">
    datos=<?= $datos_lista ?>;

        (function($){
            function pagerFilter(data){
                if ($.isArray(data)){    //
                    data = {
                        total: data.length,
                        rows: data
                    }
                }
                var target = this;
                var dg = $(target);
                var state = dg.data('datagrid');
                var opts = dg.datagrid('options');
                if (!state.allRows){
                    state.allRows = (data.rows);
                }
                if (!opts.remoteSort && opts.sortName){
                    var names = opts.sortName.split(',');
                    var orders = opts.sortOrder.split(',');
                    state.allRows.sort(function(r1,r2){
                        var r = 0;
                        for(var i=0; i<names.length; i++){
                            var sn = names[i];
                            var so = orders[i];
                            var col = $(target).datagrid('getColumnOption', sn);
                            var sortFunc = col.sorter || function(a,b){
                                return a==b ? 0 : (a>b?1:-1);
                            };
                            r = sortFunc(r1[sn], r2[sn]) * (so=='asc'?1:-1);
                            if (r != 0){
                                return r;
                            }
                        }
                        return r;
                    });
                }
                var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
                var end = start + parseInt(opts.pageSize);
                data.rows = state.allRows.slice(start, end);
                return data;
            }
 
            var loadDataMethod = $.fn.datagrid.methods.loadData;
            var deleteRowMethod = $.fn.datagrid.methods.deleteRow;
            $.extend($.fn.datagrid.methods, {
                clientPaging: function(jq){
                    return jq.each(function(){
                        var dg = $(this);
                        var state = dg.data('datagrid');
                        var opts = state.options;
                        opts.loadFilter = pagerFilter;
                        var onBeforeLoad = opts.onBeforeLoad;
                        opts.onBeforeLoad = function(param){
                            state.allRows = null;
                            return onBeforeLoad.call(this, param);
                        }
                        var pager = dg.datagrid('getPager');
                        pager.pagination({
                            onSelectPage:function(pageNum, pageSize){
                                opts.pageNumber = pageNum;
                                opts.pageSize = pageSize;
                                pager.pagination('refresh',{
                                    pageNumber:pageNum,
                                    pageSize:pageSize
                                });
                                dg.datagrid('loadData',state.allRows);
                            }
                        });
                        $(this).datagrid('loadData', state.data);
                        if (opts.url){
                            $(this).datagrid('reload');
                        }
                    });
                },
                loadData: function(jq, data){
                    jq.each(function(){
                        $(this).data('datagrid').allRows = null;
                    });
                    return loadDataMethod.call($.fn.datagrid.methods, jq, data);
                },
                deleteRow: function(jq, index){
                    return jq.each(function(){
                        var row = $(this).datagrid('getRows')[index];
                        deleteRowMethod.call($.fn.datagrid.methods, $(this), index);
                        var state = $(this).data('datagrid');
                        if (state.options.loadFilter == pagerFilter){
                            for(var i=0; i<state.allRows.length; i++){
                                if (state.allRows[i] == row){
                                    state.allRows.splice(i,1);
                                    break;
                                }
                            }
                            $(this).datagrid('loadData', state.allRows);
                        }
                    });
                },
                getAllRows: function(jq){
                    return jq.data('datagrid').allRows;
                }
            })
        })(jQuery);
 
        
        
        $(function(){
            //$('#dg').datagrid({data:getData()}).datagrid('clientPaging');
            $('#tt').datagrid({data:<?= $datos_lista ?>}).datagrid('clientPaging');
        });

        //prototipar esto
    function BotonesAccion(value,row){
        if(row.menu_padre=="")
            return;

        //var accionVer = 'window.location.href = \'<?= base_url() ?>rol/detalle_form/'+row.rol+'\'';
        var accionEditar = 'window.location.href = \'<?= base_url() ?>rol/actualizar_form/'+row.rol+'\'';
        var accionEliminar='eliminar(\''+row.rol+'\',\''+row.nombre_rol+'\')';
        var accionActivar='activar(\''+row.rol+'\',\''+row.nombre_rol+'\')';

        //var btnVer='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+ accionVer +'"><span class="l-btn-text"></span><span class="l-btn-icon icono-magnifier">&nbsp;</span></span>';
        btnVer="";
        var btnEditar='<span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+accionEditar+'"><span class="l-btn-text"></span><span class="l-btn-icon icono-pencil">&nbsp;</span></span>';
        var btnEliminar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+accionEliminar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-remove">&nbsp;</span></span>';
        var btnActivar=' <span class="l-btn-left l-btn-icon-left" style="cursor: pointer;" onclick="'+accionActivar+'"><span class="l-btn-text"></span><span class="l-btn-icon icon-ok">&nbsp;</span></span>';
        
        acc_editar = '<?= $acc_editar ?>';
        acc_eliminar = '<?= $acc_eliminar ?>';
        acc_activar = '<?= $acc_activar ?>';
        var menusRole = '';
        if(acc_editar != '0') {
			menusRole += btnEditar;
		}
		if(acc_eliminar != '0') {
			menusRole += btnEliminar;
		}
		if(acc_activar != '0') {
			menusRole += btnActivar;
		}
        
        return menusRole;
    }
    
    function eliminar(id,nombre) {
        var r = confirm("Desea eliminar el registro\nId: "+id+"\nNombre: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>rol/eliminar/"+id;
        } 
    }
    
    function activar(id,nombre) {
        var r = confirm("Desea activar el registro\nId: "+id+"\nNombre: "+nombre);
        if (r == true) {
            window.location.href = "<?= base_url() ?>rol/activar/"+id;
        } 
    }

    function nuevo_registro() {
       window.location.href = "<?= base_url() ?>rol/insertar_form"; 
    }
    </script>