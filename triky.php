<?php
session_start();

if (!isset($_SESSION['casillas'])) {
    $_SESSION['casillas'] = array_fill(0, 9, "");
    $_SESSION['turno'] = "X";
    $_SESSION['ganador'] = "";
}

if (isset($_POST['casilla']) && $_SESSION['ganador'] == "") {
    $i = $_POST['casilla'];
    if ($_SESSION['casillas'][$i] == "") {
        $_SESSION['casillas'][$i] = $_SESSION['turno'];
        $_SESSION['turno'] = $_SESSION['turno'] == "X" ? "O" : "X";
    }
}

function verificarGanador($c) {
    $lineas = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8], // filas
        [0, 3, 6], [1, 4, 7], [2, 5, 8], // columnas
        [0, 4, 8], [2, 4, 6]             // diagonales
    ];
    foreach ($lineas as $l) {
        if ($c[$l[0]] != "" && $c[$l[0]] == $c[$l[1]] && $c[$l[1]] == $c[$l[2]]) {
            return $c[$l[0]];
        }
    }
    return "";
}

$_SESSION['ganador'] = verificarGanador($_SESSION['casillas']);

if (isset($_POST['reiniciar'])) {
    session_destroy();
    header("Location: triky.php");
    exit;
}

$casillas = $_SESSION['casillas'];
$turno = $_SESSION['turno'];
$ganador = $_SESSION['ganador'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego 3 en Raya</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>JUEGO 3 EN RAYA 💙</h1>

    <form method="post">
        <table>
            <tr>
                <?php for ($i = 0; $i < 9; $i++): ?>
                    <?php if ($i > 0 && $i % 3 == 0) echo "</tr><tr>"; ?>
                    <td class="<?= $casillas[$i] != "" ? 'filled' : '' ?>">
                        <?php if ($casillas[$i] == ""): ?>
                            <button type="submit" name="casilla" value="<?= $i ?>"></button>
                        <?php else: ?>
                            <?= $casillas[$i] ?>
                        <?php endif; ?>
                    </td>
                <?php endfor; ?>
            </tr>
        </table>

        <div class="status">
            <?php if ($ganador != ""): ?>
                Ganador: <?= $ganador ?>
            <?php else: ?>
                Turno de: <?= $turno ?>
            <?php endif; ?>
        </div>

        <button type="submit" name="reiniciar">Reiniciar Juego</button>
    </form>
</body>
</html>
