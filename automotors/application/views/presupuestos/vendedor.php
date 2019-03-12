<link type="text/css" rel="stylesheet" href="<?= base_url()?>assets/grocery_crud/themes/flexigrid/css/flexigrid.css" />

<div id="p" class="easyui-panel" title="Presupuesto Vendedor " style="width:100%;padding:10px; height: 100%;display: table;">
    <!--<div class="easyui-layout" data-options="fit:true" style="height: auto;">-->
    <form action="" method="post">
        <!--<div data-options="region:'north',split:true" style="height: auto; padding: 10px; display: table;">
        	
        </div>-->
        <!--<div data-options="region:'center'" style="width:500px; display: table; overflow: auto;">-->
        <!--<div id="p" class="easyui-panel" title="Basic Panel" style="width:700px;height:200px;padding:10px;">-->
        	<!--<div style="display: table-row;">-->
        		<table width="50%" style="padding-left: 20px;">
        			<tr>
        				<td>
        					<select id="cmb" class="easyui-combobox" name="gestion" label="Gestion:" labelPosition="top" style="width:40%;" 
        						data-options="onSelect: function(rec){
        								//$('#tbm').combobox('disable');
							        	//alert(rec.value);
							        	//var url = 'http://localhost/monterrey/public_html/presupuestos/ajaxReq/'+rec.id;
            							//$('#tbm').combobox('reload', url);
							        }">
						        <option value="2017" >2017</option>
						        <option value="2018" <?= (isset($gestion) && $gestion == 2018) ? 'selected="true"' : ''?>>2018</option>
						        <option value="2019">2019</option>
						        <option value="2020">2020</option>
						    </select>
        				</td>
        				<td>
        					<a href="javascript:void(0)" class="btn btn-small" style="margin-left: 10px; text-decoration: none;" onclick="cmbGestion()">Cargar Item</a>
        				</td>
        				<td>
        					<input id="tbm" name="cod_item" class="easyui-combobox" label="Item:" labelPosition="top" data-options="valueField:'cod_item',textField:'cod_item',disabled:true">
        				</td>
        				<td rowspan="2">
        					<input name="boton" value="Consultar" type="submit" class="btn btn-large" style="margin-left: 10px;"/>
        					<!--<a href="excel" class="btn btn-success btn-lg">Export as EXCEL file</a>-->
        				</td>
        			</tr>
        		</table>
        	<br/>
        	<table id="dg" class="easyui-datagrid" title="Resultado" style="max-height: 650px;"
		            data-options="singleSelect:true,rownumbers:true">
		        <thead>
		            <tr>
		                <th data-options="field:'COD_PRESUPUESTADO_NIVEL1'">Cod</th>
		                <th data-options="field:'GESTION'">Gestion</th>
		                <th data-options="field:'COD_ITEM'">Cod Item</th>
		                <th data-options="field:'MEDIDA'">Medida</th>
		                <th data-options="field:'NOMBRE_ITEM'">Item</th>
		                <th data-options="field:'ENERO_VENTA'">Enero venta</th>
		                <th data-options="field:'ENERO_PRESUPUESTADO',editor:{type:'numberbox',options:{precision:2}}">Enero presupuestado</th>
		                <th data-options="field:'FEBRERO_VENTA'">Febrero venta</th>
		                <th data-options="field:'FEBRERO_PRESUPUESTADO'">Febrero presupuestado</th>
		                <th data-options="field:'MARZO_VENTA'">Marzo venta</th>
		                <th data-options="field:'MARZO_PRESUPUESTADO'">Marzo presupuestado</th>
		                <th data-options="field:'ABRIL_VENTA'">Abril venta</th>
		                <th data-options="field:'ABRIL_PRESUPUESTADO',width:100">Abril presupuestado</th>
		                <th data-options="field:'MAYO_VENTA',width:100">Mayo venta</th>
		                <th data-options="field:'MAYO_PRESUPUESTADO',width:100">Mayo presupuestado</th>
		                <th data-options="field:'JUNIO_VENTA',width:100">Junio venta</th>
		                <th data-options="field:'JUNIO_PRESUPUESTADO',width:100">Junio presupuestado</th>
		                <th data-options="field:'JULIO_VENTA',width:100">Julio venta</th>
		                <th data-options="field:'JULIO_PRESUPUESTADO',width:100">Julio presupuestado</th>
		                <th data-options="field:'AGOSTO_VENTA',width:100">Agosto venta</th>
		                <th data-options="field:'AGOSTO_PRESUPUESTADO',width:100">Agosto presupuestado</th>
		                <th data-options="field:'SEPTIEMBRE_VENTA',width:100">Septiembre venta</th>
		                <th data-options="field:'SEPTIEMBRE_PRESUPUESTADO',width:100">Septiembre presupuestado</th>
		                <th data-options="field:'OCTUBRE_VENTA',width:100">Octubre venta</th>
		                <th data-options="field:'OCTUBRE_PRESUPUESTADO',width:100">Octubre presupuestado</th>
		                <th data-options="field:'NOVIEMBRE_VENTA',width:100">Noviembre venta</th>
		                <th data-options="field:'NOVIEMBRE_PRESUPUESTADO',width:100">Noviembre presupuestado</th>
		                <th data-options="field:'DICIEMBRE_VENTA',width:100">Diciembre venta</th>
		                <th data-options="field:'DICIEMBRE_PRESUPUESTADO',width:100">Diciembre presupuestado</th>
		                <th data-options="field:'total_cantidad',width:100">Total cantidad</th>
		                <th data-options="field:'total_monto'">Total monto</th>
		                <th data-options="field:'ESTADO'">Estado</th>
		            </tr>
		        </thead>
		        <tbody>
		        <?php if(isset($resultado)) : ?>
		        	<?php foreach ($resultado as $item) : ?>
		        	<?php 
		        		/*echo '<pre>';
						echo($item['MEDIDA']);
						echo '</pre>';*/
					?>
		            <tr>
		                <td><?= $item['COD_PRESUPUESTADO_NIVEL1']?></td>
		                <td><?= $item['GESTION']?></td>
		                <td><?= $item['COD_ITEM']?></td>
		                <td><?= $item['MEDIDA']?></td>
		                <td><?= $item['NOMBRE_ITEM']?></td>
		                <td><?= $item['ENERO_VENTA']?></td>
		                <td><?= $item['ENERO_PRESUPUESTADO']?></td>
		                <td><?= $item['FEBRERO_VENTA']?></td>
		                <td><?= $item['FEBRERO_PRESUPUESTADO']?></td>
		                <td><?= $item['MARZO_VENTA']?></td>
		                <td><?= $item['MARZO_PRESUPUESTADO']?></td>
		                <td><?= $item['ABRIL_VENTA']?></td>
		                <td><?= $item['ABRIL_PRESUPUESTADO']?></td>
		                <td><?= $item['MAYO_VENTA']?></td>
		                <td><?= $item['MAYO_PRESUPUESTADO']?></td>
		                <td><?= $item['JUNIO_VENTA']?></td>
		                <td><?= $item['JUNIO_PRESUPUESTADO']?></td>
		                <td><?= $item['JULIO_VENTA']?></td>
		                <td><?= $item['JULIO_PRESUPUESTADO']?></td>
		                <td><?= $item['AGOSTO_VENTA']?></td>
		                <td><?= $item['AGOSTO_PRESUPUESTADO']?></td>
		                <td><?= $item['SEPTIEMBRE_VENTA']?></td>
		                <td><?= $item['SEPTIEMBRE_PRESUPUESTADO']?></td>
		                <td><?= $item['OCTUBRE_VENTA']?></td>
		                <td><?= $item['OCTUBRE_PRESUPUESTADO']?></td>
		                <td><?= $item['NOVIEMBRE_VENTA']?></td>
		                <td><?= $item['NOVIEMBRE_PRESUPUESTADO']?></td>
		                <td><?= $item['DICIEMBRE_VENTA']?></td>
		                <td><?= $item['DICIEMBRE_PRESUPUESTADO']?></td>
		                <td><?= $item['total_cantidad']?></td>
		                <td><?= $item['total_monto']?></td>
		                <td><?= $item['ESTADO']?></td>
		            </tr>
		        	<?php endforeach; ?>
		        <?php endif; ?>
		        </tbody>
		    </table>
        <!--</div>-->
        </form>
    <!--</div>-->
</div>
<script>
	$(function(){
        /*var dg = $('#dg').datagrid({
            data: data
        });*/
        $('#dg').datagrid();
        if(<?= isset($gestion) ? 'true' : 'false'?> ){
			cmbGestion();
			$('#tbm').combobox('setValue','<?= isset($cod_item) ? $cod_item : ""?>');
		}
		if(<?= isset($cod_item) ? 'true' : 'false'?> ){
			$('#dg').datagrid('enableCellEditing').datagrid('gotoCell', {
                index: 0,
                field: 'COD_PRESUPUESTADO_NIVEL1'
            });
		}
    });
	function cmbGestion() {
		$('#tbm').combobox('enable');
		$('#tbm').combobox('setValue','');
		gestion = $('#cmb').combobox('getValue');
		var url = 'http://localhost/monterrey/public_html/presupuestos/ajaxReq/' + gestion;
		$('#tbm').combobox('reload', url);
	}
</script>