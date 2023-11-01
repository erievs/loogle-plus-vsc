<?php

function fetchLatestPosts($conn, $username) {
    $query = "SELECT content
              FROM posts
              WHERE username = ?
              ORDER BY created_at DESC"; // This assumes you have a 'post_date' column to determine the order

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $latestPosts = array();

    while ($row = $result->fetch_assoc()) {
        $latestPosts[] = $row['content'];

    }

    return $latestPosts;
}

    $queryFollowing = "SELECT u.username
                       FROM user AS u
                       INNER JOIN followers AS f ON u.username = f.following_id
                       WHERE f.follower_id = ?";
    $stmtFollowing = $conn->prepare($queryFollowing);
    $stmtFollowing->bind_param("s", $_SESSION['username']);
    $stmtFollowing->execute();
    $resultFollowing = $stmtFollowing->get_result();

    if ($resultFollowing->num_rows > 0) {
        while ($rowFollowing = $resultFollowing->fetch_assoc()) {
            $followingUsername = $rowFollowing['username'];

            $latestPosts = fetchLatestPosts($conn, $followingUsername);

            foreach ($latestPosts as $latestPost) {
                ?>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">
                                <a href="profile.php?username=<?php echo htmlspecialchars($followingUsername); ?>">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Default_pfp.svg/2048px-Default_pfp.svg.png" alt="Profile Picture" class="circle responsive-img" width="75px" height="75px">
</a>

                                    <div class="text-container">
                                        <b> <a href="profile.php?username=<?php echo htmlspecialchars($followingUsername); ?>">
                                        <b><?php echo htmlspecialchars($followingUsername); ?></b>

    </a></b>  
    <p><?php echo htmlspecialchars($latestPost); ?></p>

                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    } else {
        echo "<p>You are not following anyone yet.</p>";
    }
?>