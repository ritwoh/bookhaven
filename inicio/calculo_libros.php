<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $horas_por_dia = $_POST['horas_por_dia'];
    $paginas_por_hora = $_POST['paginas_por_hora'];
    $paginas_por_libro = $_POST['paginas_por_libro'];

    $total_paginas_por_dia = $horas_por_dia * $paginas_por_hora;
    $total_paginas_por_anio = $total_paginas_por_dia * 365;
    $total_libros_por_anio = floor($total_paginas_por_anio / $paginas_por_libro);

    echo "<div class='message'>";
    echo "<h2>Resultados de la calculadora de libros</h2>";
    echo "<p>Lees aproximadamente $total_paginas_por_dia páginas por día.</p>";
    echo "<p>En un año, leerás aproximadamente $total_paginas_por_anio páginas.</p>";
    echo "<p>Eso equivale a unos $total_libros_por_anio libros al año.</p>";
    echo "</div>";
}
?>
