<?php

try {
  // Usando Composer (o puedes incluir las dependencias manualmente)
  require 'Requests-master/library/Requests.php';
  Requests::register_autoloader();
  require 'lib/culqi.php';

  // Configurar tu API Key y autenticación
  $SECRET_KEY = "sk_test_tGg70Nxa1NvzebK2";
  $culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

  // Creando Cargo a una tarjeta
  $order = $culqi->Orders->create(
      array(
        "amount" => 2500,
        "currency_code" => "PEN",
        "description" => 'Orden l',
        "order_number" => "#2-".rand(1,9999),
        "confirm" => false,
        "client_details" => array(
            "first_name"=> "Liz",
            "last_name" => "Ruelas",
            "email" => "liz.ruelas.borda@gmail.com",
            "phone_number" => "999999999"
         ),
        "expiration_date" => time() + 24*60*60  // Orden con un dia de validez

      )
  );
  // Respuesta
  // echo json_encode($order);

} catch (Exception $e) {
  echo $e;
}

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Culqi Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="waitMe.min.css"/>
  </head>
  <body>
    <div class="container">
      <h1>Culqi v2 + Checkout v3 + PagoEfectivo </h1><br><br>
      <a id="miBoton" class="btn btn-primary" href="#" >Pagar</a>
      <br/><br/><br/>
      <div class="panel panel-default" id="response-panel">
        <div class="panel-heading">Response</div>
        <div class="panel-body" id="response">
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="https://checkout.culqi.com/js/v3"></script>
    <script src="waitMe.min.js"></script>
    <script>
      var orden = '<?php echo $order->id ?>';
    </script>
    <script type="text/javascript" src="js/app.js" ></script>
  </body>
</html>
