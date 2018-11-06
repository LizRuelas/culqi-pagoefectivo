
$("#response-panel").hide();
Culqi.publicKey = 'pk_test_p6nYVGxww8ZdUfCL';
Culqi.options({
  style: {
    logo: 'https://doplex.store/wp-content/uploads/2018/10/logo-doplex-240_2.png'
  },
  installments: true
});

Culqi.settings({
  title: 'Titulo',
  currency: 'PEN',
  description: 'Deuda a Culqi',
  amount: 2500,
  order : orden
 });


$('#miBoton').on('click', function (e) {
  Culqi.open();
  e.preventDefault();
});

function culqi() {
  if (Culqi.token) {
    $(document).ajaxStart(function(){
      run_waitMe();
    });
    $.ajax({
         type: 'POST',
         url: 'http://localhost/culqi-pagoefectivo/culqi-php/examples/02-create-charge.php',
         data: { token: Culqi.token.id , cuota: Culqi.token.metadata.installments },
         datatype: 'json',
         success: function(data) {
           var result = "";
           if(data.constructor == String){
               result = JSON.parse(data);
           }
           if(data.constructor == Object){
               result = JSON.parse(JSON.stringify(data));
           }
           if(result.object === 'charge'){
            resultdiv(result.outcome.user_message);
            Culqi.close();
           }
           if(result.object === 'error'){
               resultdiv(result.user_message);
               console.log(result.merchant_message);
           }
         },
         error: function(error) {
           resultdiv(error)
         }
      });
  } else if (Culqi.order) {
		 console.log("Order confirmada");
     console.log(Culqi.order);
		 resultpe(Culqi.order);
		 //alert('Se ha elegido el metodo de pago en efectivo:' + Culqi.order);
	}
  else if (Culqi.closeEvent){
		console.log(Culqi.closeEvent);
	}
  else {
    $('#response-panel').show();
    $('#response').html(Culqi.error.merchant_message);
    $('body').waitMe('hide');
  }
};

function run_waitMe(){
  $('body').waitMe({
    effect: 'orbit',
    text: 'Procesando pago...',
    bg: 'rgba(255,255,255,0.7)',
    color:'#28d2c8'
  });
}

function resultdiv(message){
  $('#response-panel').show();
  $('#response').html(message);
  $('body').waitMe('hide');
}
