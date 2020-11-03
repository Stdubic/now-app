<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>NOW App Privacy Statement</title>
    <style type="text/css">
        .container {
            display: flex;
            flex-direction: column;
            margin: 6%;
        }
        img {
            align-self: center;
        }
        p {
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
        }
        h1 {
            text-align: center;
            font-family: 'Open Sans', sans-serif;
            font-size: 22px;
        }
        h2 {
            font-family: 'Open Sans', sans-serif;
            font-size: 18px;

        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>

<body>
<div class="container">

    <h1>NOW App Privacy Statement</h1>
    <?php $paragraphs = explode(PHP_EOL, $terms[0]); ?>

    @foreach($paragraphs as $paragraph)
        <p>{{{ $paragraph }}}</p>
    @endforeach


    <p>Edward Massey
        <br> NOW App
        <br> 066 4877750

    </p>
</div>
</body>

</html>