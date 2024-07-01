<html>
<head>
</head>
<body>
<?php
include_once('clsCategoria.php');

// Procesamiento de la acción según el botón presionado
if(isset($_POST['botones'])) {
    switch($_POST['botones']) {
        case "Nuevo":
            // Aquí podrías inicializar datos para un nuevo registro si fuera necesario
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

// Función para guardar una nueva categoría
function guardar()
{
    if(isset($_POST['txtNombre']) && !empty($_POST['txtNombre'])) {
        $obj = new Categoria();
        $obj->setNombre($_POST['txtNombre']);
        
        if ($obj->guardar()) {
            echo "Categoría Guardada..!!!";
        } else {
            echo "Error al guardar la Categoría";
        }
    } else {
        echo "El nombre es obligatorio..!!!";
    }
}

// Función para modificar una categoría existente
function modificar()
{
    if(isset($_POST['txtIdCategoria']) && isset($_POST['txtNombre']) && !empty($_POST['txtNombre'])) {
        $obj = new Categoria();
        $obj->setIdCategoria($_POST['txtIdCategoria']);
        $obj->setNombre($_POST['txtNombre']);
        
        if ($obj->modificar()) {
            echo "Categoría modificada..!!!";
        } else {
            echo "Error al modificar la categoría..!!!";
        }
    } else {
        echo "El nombre es obligatorio...!!!";
    }
}

// Función para eliminar una categoría existente
function eliminar()
{
    if(isset($_POST['txtIdCategoria']) && !empty($_POST['txtIdCategoria'])) {
        $obj = new Categoria();
        $obj->setIdCategoria($_POST['txtIdCategoria']);
        
        if ($obj->eliminar()) {
            echo "Categoría eliminada";
        } else {
            echo "Error al eliminar la categoría";
        }
    } else {
        echo "Para eliminar la categoría, debe especificar el código..!!!";
    }
}

// Función para buscar categorías según el criterio ingresado
function buscar()
{
    if(isset($_POST['txtBuscar']) && !empty($_POST['txtBuscar'])) {
        $obj = new Categoria();
        $resultado = $obj->buscarPorNombre($_POST['txtBuscar']);
        mostrarRegistros($resultado);
    } else {
        echo "Debe ingresar un criterio de búsqueda..!!!";
    }
}

// Función para mostrar los registros encontrados en una tabla
function mostrarRegistros($registros)
{
    echo "<table border='1' align='left'>";
    echo "<tr> <td>Código</td> <td>Nombre</td> <td><center>*</center></td></tr>";
    while($fila = mysqli_fetch_object($registros)) {
        echo "<tr>";
        echo "<td>$fila->id_categoria</td>";
        echo "<td>$fila->nombre</td>";
        echo "<td><a href='frmCategoria.php?pid_categoria=$fila->id_categoria&pnombre=$fila->nombre'>[Editar]</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<b> REGISTRO DE CATEGORIAS  </b>
<form id="form1" name="form1" method="post" action="frmCategoria.php">
  <table width="400" border="0">
    <tr>
      <td>
        <input name="txtIdCategoria" type="hidden" value="<?php echo isset($_GET['pid_categoria']) ? $_GET['pid_categoria'] : ''; ?>" id="txtIdCategoria" />
      </td>
    </tr>
    <tr>
      <td width="80">Nombre</td>
      <td width="225">
        <input name="txtNombre" type="text" value="<?php echo isset($_GET['pnombre']) ? $_GET['pnombre'] : ''; ?>" id="txtNombre" />
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="submit" name="botones" value="Nuevo" />
        <input type="submit" name="botones" value="Guardar" />
        <input type="submit" name="botones" value="Modificar" />
        <input type="submit" name="botones" value="Eliminar" />
        <input type="submit" name="botones" id="botones" value="Buscar"/>
      </td>
    </tr>
  </table>
</form>

<?php
// Mostrar resultados de búsqueda si se han encontrado registros
if(isset($_POST['botones']) && $_POST['botones'] == "Buscar") {
    if(isset($_POST['txtBuscar']) && !empty($_POST['txtBuscar'])) {
        $obj = new Categoria();
        $resultado = $obj->buscarPorNombre($_POST['txtBuscar']);
        mostrarRegistros($resultado);
    } else {
        echo "Debe ingresar un criterio de búsqueda..!!!";
    }
}

?>
</body>
</html>
