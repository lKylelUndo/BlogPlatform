<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = htmlspecialchars($_POST["title"]);
    $content = htmlspecialchars($_POST["content"]);

    if (!empty($title) && !empty($content)) {
        try {
            require_once "dbh.php";
            $query = "INSERT INTO posts (title, content) VALUES (:title, :content);";
            $stmt = $pdo->prepare($query);

            $stmt->execute([
                ":title" => $title,
                ":content" => $content
            ]);

            $pdo = null;
            $stmt = null;

            echo json_encode([
                "status" => "success", 
                "message" => "Successfully submitted!"
            ]);
            exit();
            
        } catch (PDOException $e) {
            echo json_encode([
                "status" => "error", 
                "message" => "Database error: " . $e->getMessage()
            ]);
            exit();
        }

    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "The input fields should not be empty!"
        ]);
        exit();
    }

} else {
    echo json_encode([
        "status" => "error", 
        "message" => "Invalid request method."
    ]);
    exit();
}
