<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Plantilla-Correo</title>
    <style>
        {
            * {
                font-family: "Poppins", sans-serif;
                font-weight: normal;
                font-style: bold;
            }

            body {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .Contenedor {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 50%;
                box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
                padding: 2%;
            }

            p {
                width: 80%;
            }

            .Logo {
                width: 40%;
                height: auto;
            }

            /* CSS */
            .BtnRedireccion {
                align-items: center;
                background-color: #fff;
                border: 2px solid #000;
                box-sizing: border-box;
                color: #000;
                cursor: pointer;
                display: inline-flex;
                fill: #000;
                font-family: Inter, sans-serif;
                font-size: 16px;
                font-weight: 600;
                height: 48px;
                justify-content: center;
                letter-spacing: -.8px;
                line-height: 24px;
                min-width: 140px;
                outline: 0;
                padding: 0 17px;
                text-align: center;
                text-decoration: none;
                transition: all .3s;
                user-select: none;
                -webkit-user-select: none;
                touch-action: manipulation;
            }

            .BtnRedireccion:focus {
                color: #171e29;
            }

            .BtnRedireccion:hover {
                border-color: #06f;
                color: #06f;
                fill: #06f;
            }

            .BtnRedireccion:active {
                border-color: #06f;
                color: #06f;
                fill: #06f;
            }

            @media (min-width: 768px) {
                .BtnRedireccion {
                    min-width: 170px;
                }
            }
        }
    </style>
</head>

<body>
    <div class="Contenedor">
        <h1>Cambio de solicitud</h1>        
        <p>Hubieron cambios en la solicitud se necesita de su aprobación nuevamente </p>
        <br>
        <a href="http://127.0.0.1:8000/requisiciones/user/{{$idRegistro}}/2">MÁS INFORMACIÓN</a>
    </div>
</body>

</html>