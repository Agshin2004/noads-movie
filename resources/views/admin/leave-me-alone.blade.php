<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404? Admin? Who's asking?</title>
    <style>
        body {
            background-color: #0d0d0d;
            color: #39ff14;
            font-family: 'Courier New', monospace;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            text-align: center;
        }
        h1 {
            font-size: 3em;
            margin-bottom: 0.2em;
        }
        p {
            font-size: 1.2em;
            max-width: 600px;
            margin: 10px;
        }
        img {
            margin-top: 30px;
            max-width: 300px;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>
    <h1>👁️ So You Wanted /admin?</h1>
    <p>This page doesn't exist. Or does it? just leave me alone, let people watch movies</p>
    <img src="https://i.imgur.com/YLmxUDz.jpeg" alt="weird doll">
    <p>Go back now. GO BACK!!!!!!</p>
    <p><a href="{{ route('index') }}" style="color:#ff004f;">Escape to Safety ></a></p>
</body>
</html>
