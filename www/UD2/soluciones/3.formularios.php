<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 3: Formularios</title>
</head>
<body>
    <h1>Actividad 3: Formularios</h1>
    <h2>Tarea 1: Formularios y Strings</h2>
    <form action="3.1 formulario Nombre.php" method="post">
        <p>Nombre: <input type="text" name="nombre"/></p>
        <p>Apellidos: <input type="text" name="apellidos"/></p>
        <button type="submit">Enviar</button>
    </form>
    <h2>Tarea 2: Envío de formularios</h2>
    <form action="3.2 formulario Bebida.php" method="post">
        <p>
            Bebida: 
            <select name="opcion">
                <option value="cocacola">Coca Cola</option>
                <option value="pepsi">Pepsi Cola</option>
                <option value="fanta">Fanta Naranja</option>
                <option value="trina">Trina Manzana</option>
            </select>
        </p>
        <p>Cantidad: <input type= "number" name="cantidad"/></p>
        <button type="submit">Solicitar</button>
    </form>
</body>
</html>