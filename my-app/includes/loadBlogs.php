<?php
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    try {
        require_once "dbh.php";
        $query = "SELECT * FROM posts;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($results)) {  
            foreach($results as $result) {
                echo "<div class='shadow p-4 mt-4'>";
                    echo date('F j, Y g:i A', strtotime($result["created_at"]));
                    echo "<hr>";
                        echo "<div class='d-flex align-items-center justify-content-between'>";
                            echo "<h3 id='title-section' class='title-section fs-2'>".htmlspecialchars($result['title'])."</h3>" . "<span>" . "<i data-title-id='".$result["id"]. "'id='edit-btn' class='bi bi-pencil-square fs-5 me-3'></i>" . "<span>" . "<span>" . "<i data-title-id='".$result["id"]."'id='delete-btn' class='bi bi-trash text-danger fs-5'></i>" . "<span>";
                        echo "</div>";
                    
                        echo "<p id='content-section' class='fs-5 mt-2'>".htmlspecialchars($result['content'])."</p>";
            
                        echo "<p id='comment-section' class='bg-light  rounded p-3'></p>";
            
                        echo "<form id='commentForm' class='mt-3'>";
                            echo "<input id='comment' name='comment' class='form-control' type='text' placeholder='Comments...'/>";
                            echo "<input id='post_id' type='hidden' name='post_id' value='".$result["id"]."'/>";
                            echo "<button class='btn btn-outline-primary mt-3'>Comment Out</button>";
                        echo "</form>";
                echo "</div>";
            }
            
        } else {
            echo "There are no blogs at the moment :(";
        }

        $pdo = null;
        $stmt = null;


    } catch (\Throwable $th) {
        header("Location: ../index.php");
        die();
    }

} else {
    header("Location: ../index.php");
    die();
}