<?php 
//Carrega as configs
$config = include_once('includes/config.php');

//checka se é o form dando save
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
	//Já sobrepoem as novas configurações vindas do post
	$config = $_POST;
	$config['pipedrive'] = isset($_POST['pipedrive'])? true : false;
	$config['mailchimp'] = isset($_POST['mailchimp'])? true : false;
	$config['zenvia'] = isset($_POST['zenvia'])? true : false;

	//Salva no arquivo config.php o array
	file_put_contents('includes/config.php', '<?php return ' . var_export($config, true) . ';');
}
?>
<html>
	<head>
		<script src="includes/javascript/jquery-3.2.1.min.js"></script>
		<script src="includes/javascript/main.js"></script>
	</head>
	<body>
		<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
		  <input type="checkbox" name="pipedrive" value="pipedrive"<?php echo !empty($config['pipedrive'])? 'checked': ''  ?> onchange="toggleData(this)"  >PipeDrive<br>
		  <div class="data-pipedrive">
		  	<input type="text" name="pipedrive_api_token" value='<?php echo !empty($config['pipedrive_api_token'])?$config['pipedrive_api_token'] : "''"  ?>' > PipeDrive Api Token <br>
		  </div>

		  <input type="checkbox" name="mailchimp" value="mailchimp"<?php echo !empty($config['mailchimp'])? 'checked': ''  ?> onchange="toggleData(this)"> Mailchimp <br>
		  <div class="data-mailchimp ">
		  	<input type="text" name="mailchimp_apiKey" value='<?php echo !empty($config['mailchimp_apiKey'])?$config['mailchimp_apiKey'] : "''"  ?>' > Mailchimp Api Key <br>
		  	<input type="text" name="mailchimp_listId" value='<?php echo !empty($config['mailchimp_listId'])?$config['mailchimp_listId'] : "''"  ?>' > Mailchimp List Id <br>
		  </div>

		  <input type="checkbox" name="zenvia" value="zenvia"<?php echo !empty($config['zenvia'])? 'checked': ''  ?>  onchange="toggleData(this)"> Zenvia <br>
		  <div class="data-zenvia ">
		  	<input type="text" name="zenvia_auth" value=<?php echo !empty($config['zenvia_auth'])?$config['zenvia_auth'] : "''"  ?> > Zenvia Auth <br>
		  	<input type="text" name="zenvia_from" value=<?php echo !empty($config['zenvia_from'])?$config['zenvia_from'] : "''"  ?> > Zenvia From <br>
		  	<input type="text" name="zenvia_msg" value=<?php echo !empty($config['zenvia_msg'])?$config['zenvia_msg'] : "''"  ?> > Zenvia MSG <br>
		  	<input type="text" name="zenvia_aggregateId" value=<?php echo !empty($config['zenvia_aggregateId'])?$config['zenvia_aggregateId'] : "''"  ?> > Zenvia AggregateId <br>
		  </div>

		  <input type="submit" value="Salvar">
		</form>
	</body>

</html>