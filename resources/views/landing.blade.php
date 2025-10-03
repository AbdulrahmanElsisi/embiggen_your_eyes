<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Space Explorer</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      color: white;
      text-align: center;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    h1 {
      font-size: 3rem;
      margin-bottom: 10px;
    }
    p {
      font-size: 1.2rem;
      margin-bottom: 30px;
    }
    a {
      text-decoration: none;
      padding: 12px 25px;
      background: #00c6ff;
      color: white;
      font-size: 1.2rem;
      border-radius: 8px;
      transition: 0.3s;
    }
    a:hover {
      background: #0072ff;
    }
  </style>
</head>
<body>
  <h1>🌌 Space Explorer</h1>
  <p>Discover the universe with interactive zoom and AI-powered search</p>
  <a href="{{ route('datasets.index') }}">Enter the Explorer</a>
</body>
</html>
