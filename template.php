<?php

// Include the database connection file
require 'db_connection.php';

?>
<html>
<head>
    <title>InstaClone</title>
    <style>
		body {
			text-align:center;
		}
        table {
            margin-left:auto;
            margin-right:auto;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
            text-align: left;
        }
        
        p {
            margin: 2px;
        }
    </style>
</head>
<body>
<!-- THIS IS FOR OPENING IMAGES FULL SIZE. DO NOT TOUCH -->
<div id="imageModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.8); z-index: 999;">
    <span onclick="document.getElementById('imageModal').style.display='none'" style="position:absolute; top:20px; right:20px; font-size: 30px; color:white; cursor:pointer;">&times;</span>
    <img id="modalImg" style="max-width:100%; max-height:100%; margin:auto; display:block; padding-top:60px;">
</div>

<h1>InstaClone</h1>

<?php

//Menu items will be here

//Upload form may be here

//Photo grid will be here


//Example of single photo
$photo = [
    'file_path' => 'example.jpg',
    'username' => 'alice_smith',
    'caption' => 'Exploring the beach',
    'date' => '03/01/2025 16:45'
];
echo "<table><tr>";
    echo '<td>';
    echo '<a href="javascript:void(0)" onclick="openModal(\''.$photo['file_path']. '\')">';
    echo '<img src="'.$photo['file_path']. '" width = 200px><br>';
    echo '</a>';
    echo '<p><a href=#>'.htmlspecialchars($photo['username']).'</a></p>';
    echo '<p>'.htmlspecialchars($photo['caption']).'</p>';
    echo '<p>'.htmlspecialchars($photo['date']).'</p>';
    echo '</td>';
echo "</tr></table>";
?>

<!-- THIS IS FOR OPENING IMAGES FULL SIZE. DO NOT TOUCH -->
<script>
    function openModal(imgPath) {
        var modal = document.getElementById('imageModal');
        var modalImg = document.getElementById('modalImg');
        modal.style.display = "block";
        modalImg.src = imgPath;
    }
</script>
</body>
</html>



