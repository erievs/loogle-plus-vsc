<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h1>User Registration</h1>
    <form action="register.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="google_id">Google ID:</label>
        <input type="text" name="google_id" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
