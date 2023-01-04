<?php
require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("select id, nombre, descripcion, precio from productos");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C. MakeUp-Cosméticos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../css/estilo.css" rel="stylesheet">
</head>

<body>
    <!--Barra de navegación-->
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="../index.php" class="navbar-brand">
                    <!--<strong>C.C. MakeUp</strong>-->
                    <img src="../images/LogoBlanco.png" width="100%" height="50px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="cosmeticos.php" class="nav-link active">Cosméticos</a>
                        </li>
                        <li class="nav-item">
                            <a href="hogar.php" class="nav-link active">Hogar</a>
                        </li>
                        <li class="nav-item">
                            <a href="zapatos.php" class="nav-link active">Zapatos</a>
                        </li>
                        <li class="nav-item">
                            <a href="edredones.php" class="nav-link active">Edredones</a>
                        </li>
                        <li class="nav-item">
                            <a href="tecnologia.php" class="nav-link active">Tecnología</a>
                        </li>
                        <li class="nav-item">
                            <a href="contacto.php" class="nav-link">Contacto</a>
                        </li>
                    </ul>
                    <a href="../checkout.php" class="btn btn-primary">Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span></a>
                </div>
            </div>
        </div>

    </header>

    <!--Contenido-->
    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($resultado as $row) {
                    $id = $row['id'];
                    if ($id >= 1 && $id <= 15) {
                ?>

                        <div class="col">
                            <div class="card shadow-sm">

                                <?php

                                

                                $imagen = "../images/productos/cosmeticos/" . $id . "/principal.jpg";


                                if (!file_exists($imagen)) {
                                    $imagen = "../images/nofoto.png";
                                }
                                ?>
                                <img src="<?php echo $imagen; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                    <p class="card-text"><?php echo $row['descripcion']; ?></p>
                                    <h4 class="card-text"><?php echo "$" . number_format($row['precio'], 2, '.', ','); ?></h4>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="../details/details_cosmeticos.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                        </div>
                                        <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        function addProducto(id, token) {
            let url = '../clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)
            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json()).then(data => {
                if (data.ok) {
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
        }
    </script>

</body>

</html>