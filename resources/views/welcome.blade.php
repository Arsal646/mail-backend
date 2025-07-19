<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
    <style>
        /* Reset basic styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Helvetica Neue', sans-serif;
  background: #f9f9f9;
  color: #333;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  text-align: center;
  padding: 20px;
}

.container {
  max-width: 500px;
  width: 100%;
}

h1 {
  font-size: 2.5rem;
  margin-bottom: 10px;
}

p {
  margin-bottom: 30px;
  font-size: 1.1rem;
  color: #555;
}

.subscribe-form {
  display: flex;
  gap: 10px;
  flex-direction: column;
}

.subscribe-form input {
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
}

.subscribe-form button {
  padding: 12px;
  background-color: #333;
  color: #fff;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.subscribe-form button:hover {
  background-color: #555;
}

footer {
  margin-top: 40px;
  font-size: 0.9rem;
  color: #999;
}

    </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
          <div class="container">
    <h1>Coming Soon</h1>
    <p>We're working hard to launch our new website. Stay tuned!</p>
    
    <form class="subscribe-form">
      <input type="email" placeholder="Enter your email" required />
      <button type="submit">Notify Me</button>
    </form>

    <footer>
      &copy; 2025 YourCompany. All rights reserved.
    </footer>
  </div>
    </body>
</html>
