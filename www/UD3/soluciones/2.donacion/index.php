<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD3 1.Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php 
        include("header.php");
        ?>
        
        <div class="row">
            <?php 
            include("menu.php");
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php
                $conPDO= new PDO()
                ?>
            </main>
            <?php
            include("footer.php");
            ?>
        </div>
    </div>
</body>
</html>