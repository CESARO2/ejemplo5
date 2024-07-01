<?php
ob_start();
session_start();
?>
<html>
<head>
<script> 
var miPopup;

function abreBuscarCategoria() { 
    miPopup = window.open("frmBuscarCategoria.php","miwin","width=410,height=350,scrollbars=yes");
    miPopup.focus();
} 
</script> 
</head>
<body>
<?php
include_once('clsProducto.php');
include_once('clsCategoria.php');
?>

<center>
<b> REGISTRO DE PRODUCTOS  </b>
<form id="form1" name="form1" method="post" action="frmProducto.php">
  <table width="400" border="1">
    <tr>
      <td width="80"> </td>
      <td width="225">	  
        <input name="txtIdProducto" type="hidden"  value="<?php echo isset($_GET['pid_producto']) ? $_GET['pid_producto'] : ''; ?>" id="txtIdProducto" />
      </td>
    </tr>
    <tr>
      <td width="80">Descripción</td>
      <td width="225">	  
        <input name="txtDescripcion" type="text"  value="<?php echo isset($_GET['pdescripcion']) ? $_GET['pdescripcion'] : ''; ?>" id="txtDescripcion" />
      </td>
    </tr>    
     <tr>
      <td width="80">Precio</td>
      <td width="225">	  
        <input name="txtPrecio" type="text" value="<?php echo isset($_GET['pprecio']) ? $_GET['pprecio'] : ''; ?>" id="txtPrecio" />
      </td>
    </tr>
	
    <tr>
    <td width="80">Stock</td>
    <td width="225">
        <input name="txtStock" type="number" value="<?php echo isset($_GET['pstock']) ? $_GET['pstock'] : ''; ?>" id="txtStock" />
    </td>
    </tr>

    <tr>
      <td width="80">Categoría</td>
      <td width="225">	          
        <input name="txtNombreCat" type="text" value="<?php echo isset($_SESSION['nombre_cat']) ? $_SESSION['nombre_cat'] : ''; ?>" id="txtNombreCat" />
        <a href="#" onClick="abreBuscarCategoria()">Buscar</a>	
        <input name="txtIdCategoria" type="text" readonly="true" size="3" value="<?php echo isset($_SESSION['id_categoria']) ? $_SESSION['id_categoria'] : ''; ?>" id="txtIdCategoria" />
      </td>
    </tr>
		 
    <tr>
      <td colspan="2">
        <input type="submit" name="botones"  value="Nuevo" />
        <input type="submit" name="botones"  value="Guardar" />
        <input type="submit" name="botones"  value="Modificar" />
        <input type="submit" name="botones"  value="Eliminar" />
        <input type="submit" name="botones"  id="botones" value="Buscar"/>
     </td>
    </tr>
  
    <tr>
      <!-- Búsqueda por código y nombre -->
      <td colspan="2">
        Buscar por       
		<input name="grupo" type="radio" value="1" <?php if (!empty($_POST['grupo']) && $_POST['grupo']=="1") echo "checked"; elseif (!isset($_POST['grupo'])) echo "checked"; ?> />
Código
<input type="radio" name="grupo" value="2" <?php if (!empty($_POST['grupo']) && $_POST['grupo']=="2") echo "checked"; ?> />
Categoria

        <input name="txtBuscar" type="text" id="txtBuscar" value="<?php echo isset($valor) ? $valor : ''; ?>" size="33"/>   
      </td>
    </tr>
    
      <!-- Búsqueda por stock -->
      <tr>
    <td colspan="2">
        Buscar por       
        <input name="grupo" type="radio" value="1" <?php if (!empty($_POST['grupo']) && $_POST['grupo'] == "1") echo "checked"; elseif (!isset($_POST['grupo'])) echo "checked"; ?> />
        Código
        <input type="radio" name="grupo" value="2" <?php if (!empty($_POST['grupo']) && $_POST['grupo'] == "2") echo "checked"; ?> />
        Categoría
        <input type="radio" name="grupo" value="3" <?php if (!empty($_POST['grupo']) && $_POST['grupo'] == "3") echo "checked"; ?> />
        Stock
        <br/>
        Stock Inicial: <input name="stockInicial" type="number" id="stockInicial" value="<?php echo isset($_POST['stockInicial']) ? $_POST['stockInicial'] : ''; ?>" size="5"/>
        Stock Final: <input name="stockFinal" type="number" id="stockFinal" value="<?php echo isset($_POST['stockFinal']) ? $_POST['stockFinal'] : ''; ?>" size="5"/>
        <br/>
        <input name="txtBuscar" type="text" id="txtBuscar" value="<?php echo isset($valor) ? $valor : ''; ?>" size="33"/>
    </td>
</tr>
  </table>
</form>
</center>

<?php

function guardar()
{
    if(isset($_POST['txtDescripcion']) && !empty($_POST['txtDescripcion'])) {
        $obj = new Producto();
        $obj->setDescripcion($_POST['txtDescripcion']);
        $obj->setPrecio($_POST['txtPrecio']);
        $obj->setIdCategoria($_POST['txtIdCategoria']);
        $obj->setStock($_POST['txtStock']);

        if ($obj->guardar()) {
            echo "Producto Guardado..!!!";
        } else {
            echo "Error al guardar el Producto";
        }
    } else {
        echo "La descripción del producto es obligatoria..!!!";
    }
}	

function modificar()
{
    if(isset($_POST['txtIdProducto']) && !empty($_POST['txtIdProducto'])) {
        $obj = new Producto();
        $obj->setIdProducto($_POST['txtIdProducto']);
        $obj->setDescripcion($_POST['txtDescripcion']);
        $obj->setPrecio($_POST['txtPrecio']);
        $obj->setIdCategoria($_POST['txtIdCategoria']);
        $obj->setStock($_POST['txtStock']);

        if ($obj->modificar()) {
            echo "Producto modificado..!!!";
        } else {
            echo "Error al modificar el Producto..!!!";
        }
    } else {
        echo "El Código del producto es obligatorio...!!!";
    }
}

function eliminar()
{
    if(isset($_POST['txtIdProducto']) && !empty($_POST['txtIdProducto'])) {
        $obj= new Producto();
        $obj->setIdProducto($_POST['txtIdProducto']);		
        
        if ($obj->eliminar()) {
            echo "Producto eliminado...!!!";
        } else {
            echo "Error al eliminar el Producto";		
        }
    } else {
        echo "Para eliminar el producto, debe tener el id del producto..!!!";	
    }
}

function buscar()
{  
    $obj = new Producto();
   
    switch ($_POST['grupo']) {
        case 1:
            $resultado = $obj->buscarPorCodigo($_POST['txtBuscar']);
            mostrarRegistros($resultado);
            break;
           
        case 2: 
            $resultado = $obj->buscarPorDescripcion($_POST['txtBuscar']);
            mostrarRegistros($resultado);
            break;
        
        case 3:
            if (isset($_POST['stockInicial']) && isset($_POST['stockFinal'])) {
                $resultado = $obj->buscarPorRangoStock($_POST['stockInicial'], $_POST['stockFinal']);
                mostrarRegistros($resultado);
            } else {
                echo "Debe ingresar el stock inicial y final.";
            }
            break;
           
        default:
            echo "Debe seleccionar un grupo de búsqueda.";
            break;
    }
}

function mostrarRegistros($registros)
{
    echo "<table border='1' align='center'>";
    echo "<tr><td>IdProducto</td>";
    echo "<td>Descripción</td>";
    echo "<td>Precio</td>";
    echo "<td>Stock</td>"; // Añadir la columna de stock
    echo "<td><center>*</center></td></tr>";
    
    while($fila = mysqli_fetch_object($registros))
    {
        echo "<tr>";
        echo "<td>$fila->id_producto</td>";
        echo "<td>$fila->descripcion</td>";
        echo "<td>$fila->precio</td>";
        echo "<td>$fila->stock</td>"; // Mostrar el stock
        echo "<td><a href='frmProducto.php?pid_producto=$fila->id_producto&pdescripcion=$fila->descripcion&pprecio=$fila->precio&pstock=$fila->stock&pcategoria=$fila->nombre'> [Editar] </a> </td>";
        echo "</tr>";
    }
    
    echo "</table>";
}   

// Programa principal
if(isset($_POST['botones'])) {
    switch($_POST['botones']) {
        case "Nuevo":
            break;
            
        case "Guardar":
            guardar();
            break;
            
        case "Modificar":
            modificar();
            break;
            
        case "Eliminar":
            eliminar();
            break;
            
        case "Buscar":
            buscar();
            break;
            
        default:
            break;
    }
}

?>  
</body>
</html>
