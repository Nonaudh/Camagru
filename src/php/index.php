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
    <h1>Submit Data to PHP Backend</h1>

    <h2>GET Request Example</h2>
    <form action="php/process.php" method="GET">
        <div>
            <label for="name_get">Name:</label>
            <input type="text" id="name_get" name="username_get" required>
        </div>
        <button type="submit">Send via GET</button>
    </form>

    <hr>

    <h2>POST Request Example</h2>
    <form action="php/process.php" method="POST">
        <div>
            <label for="name_post">Name:</label>
            <input type="text" id="name_post" name="username_post" required>
        </div>
        <div>
            <label for="email_post">Email:</label>
            <input type="email" id="email_post" name="email_post" required>
        </div>
        <button type="submit">Send via POST</button>
    </form>

</body>
</html>
