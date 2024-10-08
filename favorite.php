<?php
include_once 'dashboard.php';  // Include dashboard.php, which in turn includes header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite</title>
    <link rel="stylesheet" href="fonts-awesome/css/all.css">
    <link rel="stylesheet" href="styless/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styless/home.css"> 
</head>
<body>
<div id="main" class="content">
    <div class="notes-container">
        <div id="mainGeader" class="notes-header">
            <h1><span class="favorites-header">Favorite Notes</span></h1>
        </div>  
        <div class="notes-grid" id="notesGrid">
            <?php
            include 'includes/db_conn.php';
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; 
            $query = "SELECT * FROM tbl_notes WHERE id = '$userId' AND favorite = 1 AND archived = 0 ORDER BY n_id DESC";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {    
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="note">' .
                        '<div class="note-actions"> 
                    <i class="fas fa-ellipsis-h"></i>
                    <ul class="actions-dropdown">
                    <li><a href="javascript:void(0)" onclick="openEditNoteModal(' . $row['n_id'] . ')">View Note</a></li>  
                    <li><a href="archive.php?id=' . $row['n_id'] . '" class="delete-note">Delete Note</a></li> 
                    </ul>
                    </div>' .  
                    '<h3>' . $row['n_title'] . '</h3>' . 
                    '<p>' . $row['n_content'] . '</p>' . 
                    '<p class="date"> Modified Date: ' . $row['n_date'] . '</p>' . 
                    '</div>'; 
                }   
            } else { 
                echo '<div class="no-notes">' .
                    '<i class="bx bx-note"></i>' . 
                    '<p>No favorite notes found.</p>' .
                    '</div>';
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</div>
<div id="editNoteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditNoteModal()">&times;</span>
        <h2>View Note</h2>
        <form id="editNoteForm">
            <input type="hidden" id="editNoteId" value="">
            <div class="form-group">
                <label for="editTitle" style="border: 1px solid #ccc; padding: 10px;">Title:</label>
                <input type="text" id="editTitle" name="title"  style="padding: 10px 10px">
            </div>
            <div class="form-group">
                <label for="editContent" style="border: 1px solid #ccc; padding: 10px;">Content:</label>
                <textarea id="editContent" name="content" rows="10" cols="50" ></textarea>
            </div>
        </form>
    </div>
</div>
<script src="js/script.js"></script>
</body>
</html>
