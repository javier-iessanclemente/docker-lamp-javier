<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de configuración de idioma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1>Formulario de añadido de usuarios</h1>
        </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

            <form action="cambiarI.php" method="post">
                <label>Idioma: </label>
                <select name="idioma" required>
                <?php 
                    if(isset($_COOKIE["idioma"])) {
                        $idioma= $_COOKIE["idioma"];
                    } 
                ?>
                    <option value="es" <?php if(isset($idioma) && $idioma == "es") { echo "selected=''"; }?>>Castellano</option>
                    <option value="gl" <?php if(isset($idioma) && $idioma == "gl") { echo "selected=''"; }?>>Gallego</option>
                    <option value="en" <?php if(isset($idioma) && $idioma == "en") { echo "selected=''"; }?>>Inglés</option>
                    <option value="des" <?php if(isset($idioma) && $idioma == "des") { echo "selected=''"; }?>>Desconocido</option>
                </select>
                <button class="btn btn-primary m-2" role="button" type="submit">Cambiar Idioma</button>
            </form>

        </div>
    </main>
    <?php
        include("footer.php");
    ?>
</body>
</html>