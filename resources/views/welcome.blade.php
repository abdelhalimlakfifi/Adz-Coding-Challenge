<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel with Vue</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            /* align-items: center; */
            min-height: 100vh;
            margin: 0;
        }
        #app{
            width: 50%;
        }
    </style>
</head>
<body>
    <div id="app"></div> <!-- This is where your Vue app will mount -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
