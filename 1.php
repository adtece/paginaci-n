<?php

require_once "autoloader2.php";

$connection = new Connection();
$conn = $connection->getConn();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>

<body>
    <table class="redTable">
        <thead>
            <tr>
                <td colspan="8">
                  
                </td>
            </tr>
        </thead>
        <tbody>
            <?php   
            $conn = new mysqli('db', 'root', 'test', "ap21");
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        
            $query = 'SELECT * From Investment';
            $result = mysqli_query($conn, $query);
            
            $registro_total = mysqli_num_rows($result); // Total de registros
            $registro_pagina = 10; // Cantidad de registros por página
            $pagina = ceil($registro_total / $registro_pagina); // Total de páginas
            $pagActiva = isset($_GET["pagina"]) ? $_GET["pagina"] : 1; // Página actual
            $primerregistro = ($pagActiva - 1 ) * $registro_pagina; // Primer registro en la página actual
            $ultimoRegistro = min($primerregistro + $registro_pagina, $registro_total); // Último registro en la página actual

            echo '<table class="table table-striped">';
            echo '<tr>
                    <th>Id</th>
                    <th>Company</th>
                    <th>Investment</th>
                    <th>Date</th>
                    <th>Active</th>
                    <th colspan="2">Actions</th>
                </tr>';

            // Iterar sobre los registros de la página actual
            for ($i = $primerregistro; $i < $ultimoRegistro; $i++) {
                $result->data_seek($i);
                $value = $result->fetch_array(MYSQLI_ASSOC);

                echo '<tr>';
                foreach ($value as $element) {
                    echo '<td>' . $element . '</td>';
                }
                echo '<td><a href="insertar.php?id="><img src="mas.png" width="25" height="25"></a></td>';
                echo '<td><a href="delete.php?Id=' . $value['Id'] . '"><img src="del_icon.png" width="25" height="25"></a></td>';
                echo '<td><a href="edit.php?id=' . $value['Id'] .'"><img src="edit_icon.png" width="25" height="25"></a></td>';
                echo '</tr>';
            }
            echo '</table>';
        
            // Generar enlaces de paginación
            for ($i = 1; $i <= $pagina; $i++) {
                echo '<a href="index.php?pagina=' . $i . '">' . $i . '</a>';
            }

            $result->close();
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>

</html>