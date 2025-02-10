<?php
session_start();
require 'db_connection.php';
?>
<html>

<head>
    <title>InstaClone</title>
    <style>
        body {
            text-align: center;
        }

        table {
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        th,
        td {
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
    <div id="imageModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.8); z-index: 999;">
        <span onclick="document.getElementById('imageModal').style.display='none'"
            style="position:absolute; top:20px; right:20px; font-size: 30px; color:white; cursor:pointer;">&times;</span>
        <img id="modalImg" style="max-width:100%; max-height:100%; margin:auto; display:block; padding-top:60px;">
    </div>

    <h1>InstaClone</h1>

    <?php
    if (isset($_SESSION["logged_user"])) {
        echo "<p>Welcome to your feed, " . $_SESSION["logged_user"] . "</p>";
        //Menu items will be here

        //obtener numero de gente que me sigue
        $followers_count = getPeopleFollowingMe($_SESSION["logged_id"]);
            
        //obtener numero de gente que yo sigo
        $following_count = getPeopleIFollow($_SESSION["logged_id"]);

        echo "<p>Followers: $followers_count - Following: $following_count - <a href=\"people.php\">Manage followers</a> - <a href=\"profile.php?userid=".$_SESSION["logged_id"]."\">Your profile</a> - <a href=\"logout.php\">Log out</a></p>";
        //Upload form may be here
    
        //Photo grid will be here
        //query que en la tabla followers haga un where del usuario actual, y lo que devuelva, buscar el following_id en la tabla photos
        $sql = 'SELECT ph.user_id, us.username, ph.file_path, ph.caption, ph.created_at FROM instagram_clone.photos ph JOIN users us ON ph.user_id = us.id WHERE user_id IN (SELECT following_id FROM instagram_clone.followers WHERE follower_id = '.$_SESSION["logged_id"].') ORDER BY created_at DESC';
        $result = execQuery(getDbConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            $trcount = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                if ($trcount == 0) {
                    echo "<tr>";
                }
                echo '<td>';
                echo '<a href="javascript:void(0)" onclick="openModal(\'' . 'download.php?file='.$row["file_path"] . '\')">';
                echo '<img src=download.php?file='.$row["file_path"].' width = 200px><br>';
                echo '</a>';
                echo '<p><a href=profile.php?userid='.$row["user_id"].'>' . htmlspecialchars($row['username']) . '</a></p>';
                echo '<p>' . htmlspecialchars($row['caption']) . '</p>';
                echo '<p>' . htmlspecialchars($row['created_at']) . '</p>';
                echo '</td>';
                $trcount += 1;
                if ($trcount == 3) {
                    echo "</tr>";
                    $trcount = 0;
                }
            }
            echo "</table>";
        }
    }else{
        header('Location: index.php');
        exit();
    }
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