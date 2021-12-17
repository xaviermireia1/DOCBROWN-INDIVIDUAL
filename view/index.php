<?php
    require_once '../services/connection.php';
    $localizaciones=$pdo->prepare("SELECT * FROM tbl_localizacion");
    $localizaciones->execute();
    $localizaciones=$localizaciones->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/stylesviewclient.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Inicio</title>
</head>
<body class="contenido_index">
    <input type="checkbox" id="active">
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="menu">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="reservasonlinecliente.php">Reservar Mesa</a></li>
            <li><a href="login.html">Iniciar sesion</a></li>
        </ul>
    </div>
    <div class="contenido_inicio">
        <h1>¿Quienes somos?</h1>
        <h2>Somos el restaurante DOC-BROWN ubicado en la zona alta de Barcelona</h2>
        <h3>Ven a disfrutar de la gastronomía de nuestro restaurante para vivir una experiencia inolvidable.</h3>
    </div>
    <div class="slideshow-container">
        <?php
        $total=count($localizaciones);
        $contador=0;
            foreach ($localizaciones as $row) {
                $contador++;
                echo "<div class='mySlides fade'>";
                echo "<div class='numbertext'>$contador / $total</div>";
                echo "<img src='{$row['img']}' style='width:100%;'>";
                echo "<div class='text'>{$row['nombre_localizacion']}</div>";
                echo "</div>";
            }
        ?>
    </div>
    <br>
    <div style="text-align:center">
    <?php
        for ($i=1; $i <= $total; $i++) { 
            ?>
            <span class="dot" onclick="currentSlide(<?php echo $i; ?>)"></span>  
            <?php     
        }
    ?>
    </div>
    <script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>
</body>
</html>