<?php
$api_endpoint = $_ENV["API_ENDPOINT"] ?: "http://localhost:5000/upload";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"]["tmp_name"];

    // Crear una instancia de CURLFile para el archivo CSV
    $file = new CURLFile($file, 'text/csv', 'file');

    // Configurar los datos para la solicitud POST
    $post_data = array(
        'file' => $file,
    );

    // Configurar las opciones de cURL
    $curl_options = array(
        CURLOPT_URL => $api_endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $post_data,
    );

    // Inicializar cURL y ejecutar la solicitud
    $curl = curl_init();
    curl_setopt_array($curl, $curl_options);
    $response = curl_exec($curl);

    // Verificar si la solicitud fue exitosa
    if ($response === false) {
        echo "Error en la solicitud cURL: " . curl_error($curl);
    } else {
        // La respuesta es exitosa, puedes hacer algo con la respuesta
       // echo '<img src="data:image/png;base64,' . base64_encode($response) . '" alt="Imagen">';
    }

    // Cerrar la sesión cURL
    curl_close($curl);
}
?>
<!-- Resto del código HTML -->


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Link Extractor</title>
    <style media="screen">
      html {
        background: #EAE7D6;
        font-family: sans-serif;
      }
      body {
        margin: 0;
      }
      h1 {
        padding: 10px;
        margin: 0 auto;
        color: #EAE7D6;
        max-width: 600px;
      }
      h1 a {
        text-decoration: none;
        color: #EAE7D6;
      }
      h2 {
        background: #082E41;
        color: #EAE7D6;
        margin: -10px;
        padding: 10px;
      }
      p {
        margin: 25px 5px 5px;
      }
      section {
        max-width: 600px;
        margin: 10px auto;
        padding: 10px;
        border: 1px solid #082E41;
      }
      div.header {
        background: #082E41;
        margin: 0;
      }
      div.footer {
        background: #082E41;
        margin: 0;
        padding: 5px;
      }
      .footer p {
        margin: 0 auto;
        max-width: 600px;
        color: #EAE7D6;
        text-align: center;
      }
      .footer p a {
        color: #24C2CB;
        text-decoration: none;
      }
      .error {
        color: #DA2536;
      }
      form {
        display: flex;
      }
      input {
        font-size: 20px;
        padding: 3px;
        height: 40px;
      }
      input.text {
        box-sizing:border-box;
        flex-grow: 1;
        border-color: #082E41;
      }
      input.button {
        width: 150px;
        background: #082E41;
        border-color: #082E41;
        color: #EAE7D6;
      }
      table {
        width: 100%;
        text-align: left;
        margin-top: 10px;
      }
      table th, table td {
        padding: 3px;
      }
      table th:last-child, table td:last-child {
        width: 70px;
        text-align: right;
      }
      table th {
        border-top: 1px solid #082E41;
        border-bottom: 1px solid #082E41;
      }
      table tr:last-child td {
        border-top: 1px solid #082E41;
        border-bottom: 1px solid #082E41;
      }
    </style>
  </head>
  <body>
    <div class="header">
      <h1><a href="/">Grafica - Pandas</a></h1>
    </div>

    <section>
      <form action="/" method="post" enctype="multipart/form-data">
        <input type="file" name="file" accept=".csv">
        <br>
        <input class="button" type="submit" value="Subir Archivo">
      </form>
    </section>
    <br>
    <section>
    <div>
          <?php if($response){
       echo '<img src="data:image/png;base64,' . base64_encode($response) . '" alt="Imagen" style="max-width: 100%; height: auto;">';

      }
      
      ?>
    </div>
    </section>
    
    <!-- Resto del código PHP y HTML sigue aquí -->
  </body>
</html>
