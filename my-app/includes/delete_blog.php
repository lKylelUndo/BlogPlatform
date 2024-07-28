<?php
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["titleId"])) {
    $titleId = $_GET["titleId"];

    try {
        require_once "dbh.php";
        $query = "DELETE FROM posts WHERE id=:titleId;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ":titleId" => $titleId
        ]);

        $pdo = null;
        $stmt = null;

        header("Location: ../index.php");
        die();

    } catch (\Throwable $th) {
        header("Location: ../index.php");
        die();
    }

} else {
    header("Location: ../index.php");
    die();
}