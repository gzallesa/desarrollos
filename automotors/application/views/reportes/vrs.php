<link type="text/css" rel="stylesheet" href="<?= base_url()?>assets/grocery_crud/themes/flexigrid/css/flexigrid.css" />

<div id="p" class="easyui-panel" title="Reporte VRS " style="width:100%;padding:10px; height: 80%;">
    <div class="easyui-layout" data-options="fit:true" style="height: auto;">
    <form action="" method="post">
        <!--<div data-options="region:'north',split:true" style="height: auto; padding: 10px; display: table;">
        	
        </div>-->
        <div data-options="region:'center'" style="width:500px;height: auto; display: table;">
        	<!--<div style="display: table-row;">-->
        		<table width="50%" style="padding-left: 10px;">
        			<tr>
        				<td>
        					<select class="easyui-combobox" name="gestion" label="Gestion:" labelPosition="top" style="width:90%;">
						        <option value="2017">2017</option>
						        <option value="2018">2018</option>
						        <option value="2019">2019</option>
						        <option value="2020">2020</option>
						    </select>
        				</td>
        				<td>
        					<input id="tbm" name="meses[]" class="easyui-tagbox" label="Mes" value="" labelPosition="top" style="width:90%;" data-options='
					        valueField: "label",
							textField: "value",
							data: <?= $meses ?>,
					        hasDownArrow: true,
					        prompt: "Seleccione mes" '/>
        				</td>
        				<td rowspan="2">
        					<input name="boton" value="Buscar" type="submit" class="btn btn-large" style="margin-left: 10px;"/>
        					<a href="excel" class="btn btn-success btn-lg">Export as EXCEL file</a>
        				</td>
        			</tr><tr>
        				<td>
        					<input name="uv[]" class="easyui-tagbox" label="Unidad de venta" value="" labelPosition="top" style="width:90%;" data-options='
					        valueField: "label",
							textField: "value",
							data: <?= $uv ?>,
					        hasDownArrow: true,
					        prompt: "Seleccione unidad venta" '/>
        				</td>
        				<td>
        					<input name="eje[]" class="easyui-tagbox" label="Vendedor" value="" labelPosition="top" style="width:90%" data-options='
					        valueField: "label",
							textField: "value",
							data: <?= $eje ?>,
					        hasDownArrow: true,
					        prompt: "Seleccione vendedor" '>
        				</td>
        			</tr>
        		</table>
	        	<!--<div class="easyui-panel" style="width:45%;padding:30px 50px; display: table-cell;">-->
	        		
				    
	        	<!--</div>-->
	        	<!--<div class="easyui-panel" style="width:45%;padding:30px 60px; display: table-cell;">-->
	        	<!--</div>-->
        	<!--</div>-->
        	<!--<div style="display: table-cell;">-->
    		
    		<!--</div>-->
        	<!--<div style="display: table-row;">
        		
        	</div>-->
        	<br/>
        	<table id="tt" class="easyui-datagrid" title="Consolidado"
		            data-options="singleSelect:true,collapsible:true,method:'get'">
		        <thead>
		            <tr>
		                <th data-options="field:'cod',width:100">Codigo</th>
		                <th data-options="field:'tipo',width:200">Tipo</th>
		                <th data-options="field:'sum',width:200,align:'right'">Valor Final</th>
		            </tr>
		        </thead>
		        <tbody>
		        <?php if(isset($cp2)) : ?>
		        	<?php foreach ($cp2 as $item) : ?>
		            <tr>
		                <td><?= $item['cod']?></td>
		                <td><?= $item['tipo']?></td>
		                <td><?= $item['sum(valor_final_sus)']?></td>
		            </tr>
		        	<?php endforeach; ?>
		        <?php endif; ?>
		        </tbody>
		    </table>
		    <br/>
		    <br/>
		    <table id="tt" class="easyui-datagrid" title="Presupuestado"
		            data-options="singleSelect:true,collapsible:true,method:'get'">
		        <thead>
		            <tr>
		                <th data-options="field:'cod',width:100">Codigo</th>
		                <th data-options="field:'tipo',width:200">Tipo</th>
		                <th data-options="field:'sum',width:200,align:'right'">Valor $U$</th>
		            </tr>
		        </thead>
		        <tbody>
		        <?php if(isset($cp1)) : ?>
		        	<?php foreach ($cp1 as $item) : ?>
		            <tr>
		                <td><?= $item['cod']?></td>
		                <td><?= $item['tipo']?></td>
		                <td><?= $item['sum(valor_sus)']?></td>
		            </tr>
		        	<?php endforeach; ?>
		        <?php endif; ?>
		        </tbody>
		    </table>
        </div>
        </form>
    </div>
</div>