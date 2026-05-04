<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Backend Form Example</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form div { margin-bottom: 10px; }
        label { display: inline-block; width: 80px; }
    </style>
</head>
<body>
    <form action="process.php" method="POST">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <button type="submit">Send via POST</button>
    </form>

</body>
</html>
