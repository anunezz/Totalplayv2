<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Painani</title>
    <style type="text/css">
        .header{
        background: #9f1e47;
        padding:10px;
    }
    .cintillo{
        background: #b69262;
        padding:2px;
    }
    .cuerpo{
        background: #f9f9f9;
        padding:50px;
    }
    .contenido{
        background:#f9f9f9;
        padding:10px;
    }
    .footer{
        background:#f9f9f9;
    }
    .break-word{
        word-break: break-all;
    }
    p{
        padding: 2px;
    }
    </style>
</head>
<body
    style="margin: 0;
        padding: 0;
        font-family: 'Montserrat',
        sans-serif;
        width: 100%;
        background-image: url({{ $message->embed(public_path('img/sre_white.png'))}});">

    <div class="header">
        <div style="text-align: left; padding:5px;">
                <img  width="10%" height="10%" src="{{ $message->embed(public_path().'/img/logo.png') }}" alt="">
        </div>
    </div>


<section>
    <div style="margin: 5%;">

        <p>
        Estimado usuario le informamos que se acaban de vencer 3 trámites.
        <br>
        </p>

    </div>
    <br>
    <div style="text-align:center; margin: 2%;">
        <img src="{{ $message->embed(public_path('img/logo_sre_red.png'))}}" width="20%">
    </div>
</section>
</body>
</html>





