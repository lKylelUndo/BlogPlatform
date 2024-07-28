<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $commentData = htmlspecialchars($_POST["comment"]);
    $postId = htmlspecialchars($_POST["post_id"]);

    try {
        require_once "dbh.php";
        $query = "INSERT INTO comments (post_id, comment) VALUES (:post_id, :comment);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ":post_id" => $postId,
            ":comment" => $commentData
        ]);

        $stmt = null;
        $pdo = null;

        header("Location: ../index.php");
        die();

    } catch (\Throwable $th) {
        echo "Error: " . $th->getMessage();
        die();
    }
}
else {
    header("Location: ../index.php");
    die();
}