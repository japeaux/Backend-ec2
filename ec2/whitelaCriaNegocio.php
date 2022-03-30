
<html lang="en">
<head>
    <meta charset="utf-8" />

<script>
function CriaNegocio(){

    var chkNome = document.getElementById("chkNome");
	var chkNomeNegocio = document.getElementById("chkNomeNegocio");
	var chkContato = document.getElementById("chkContato");
	var chkEmail = document.getElementById("chkEmail");
	var chkTipodoNegocio = document.getElementById("chkTipodoNegocio");
	var chkProd = document.getElementById("chkProd").checked;
	var chkServ = document.getElementById("chkServ").checked;
	var chkRamo = document.getElementById("chkRamo");
	var chkLocal = document.getElementById("chkLocal");
	var chkHorariodeAtendimento = document.getElementById("chkHorariodeAtendimento");

	// var login = document.forms[0];
 //  	var txt = "";
 //  	var i;
 //  	for (i = 0; i < login.length; i++) {
 //    	if (login[i].checked) {
 //      		txt = txt + login[i].value + " ";
 //   	 	}
 //    	if (chkOutro == true){
	//     	otherValue.style.display = "block";
	//   	}else{
	//     	otherValue.style.display = "none";
	//   	}
 //  	}
  	// document.getElementById("order").value = "You ordered with: " + txt;
  	window.location.href = "https://app.diwoapp.com.br/whitela/whitelaCriaLogin.html?nomenegocio=chkNomeNegocio";
}


</script> 

<script>
function ClickProd() {
	var chkAuxProd = document.getElementById("chkProd").checked;
	//var chkAuxServ = document.getElementById("chkServ").checked;
	if (chkAuxProd == true){
    	document.getElementById("chkServ").checked = false;
  	}

}
function ClickServ() {
	//var chkAuxProd = document.getElementById("chkProd").checked;
	var chkAuxServ = document.getElementById("chkServ").checked;
	if (chkAuxServ == true){
    	 document.getElementById("chkProd").checked = false;
  	}

}

</script>


</head>
<body >

	<form >
	  <fieldset>
	  <legend> Bem vindo ao facilitatron, por favor preencha os campos que faremos o seu app </legend>
	    <div >
	      <label > Nome </label>
	      <input type = "text" id = "chkNome"   >
	    </div>
	    <div >
	      <label > Nome do negócio </label>
	      <input type = "text" id = "chkNomeNegocio"  >
	    </div>
	    <div >
	      <label > Número de contato </label>
	      <input type = "text" id = "chkContato"   >
	    </div>
	    <div>
	      <label > Email </label>
	      <input type = "text" id = "chkEmail" >
	    </div>
	    <div>
	      <label > Seu negócio fornece  </label>
	    </div>

	    <div>
	      <input type = "checkbox" id = "chkProd" value = "Produto" onclick="ClickProd()">
	      <label> Produto </label>
	    </div>
	    <div>
	      <input type = "checkbox" id = "chkServ" value = "Servico" onclick="ClickServ()">
	      <label > Serviço </label>
	    </div>


	    <br><br>
	    <!-- <input type="text" id="order" size="50"> -->

	    <input type="button" onclick="CriaNegocio()" value="Próximo">

	  </fieldset>
	</form>

	


</body>
</html>
