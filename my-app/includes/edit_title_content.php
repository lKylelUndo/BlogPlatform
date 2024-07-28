<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["titleId"])) {

    if (!empty($_POST["editedTitle"]) OR !empty($_POST["editedContent"])) {
        $titleId = htmlspecialchars($_POST["titleId"]);
        $editedTitle = htmlspecialchars($_POST["editedTitle"]);
        $editedContent = htmlspecialchars($_POST["editedContent"]);

        try {
            require_once "dbh.php";

            $query = "UPDATE posts SET title=:editedTitle, content=:editedContent WHERE id = :taskId";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ":editedTitle" => $editedTitle,
                ":editedContent" => $editedContent,
                ":taskId" => $titleId
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

} else {
    header("Location: ../index.php");
    die();
}