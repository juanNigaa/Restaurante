<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta</title>
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
        }

        h1 {
            color: #007bff;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            max-width: 800px;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #fec400;
            color: #ffffff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f4f6f9;
        }

        p a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Carta restaurante</h1>
    <?php
         include("conexion.php");
         $consulta = "SELECT * FROM pedidos";
         $result = mysqli_query($conn, $consulta);
     
         echo mysqli_error($conn);
         if (mysqli_num_rows($result) > 0) {
             echo "<table>";
             echo "<tr><th>Comida</th><th>Precio</th><th>Cantidad</th><th>Imagen</th></tr>";
             while ($row = mysqli_fetch_array($result)) {
                 echo "<tr>";
                 echo "<td>" . $row['Comida'] . "</td>";
                 echo "<td>" . $row['Precio'] . "€</td>";
                 echo "<td>" . $row['Cantidad'] . "</td>";
                 echo "<td><img src='" . $row['Imagen'] . "' alt='Imagen de " . $row['Comida'] . "' width='100' height='100'></td>";
                 echo "</tr>";
             }
             echo "</table>";
         } else {
             echo "<p class='no-data'>No hay trabajadores registrados en el sistema.</p>";
         }
    ?>
    <p><a href="usuario.php">Volver al inicio usuario</a></p>
</body>
</html>
