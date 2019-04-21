<!DOCTYPE html>
<?php 
	$domain=$_GET['domain'];
 ?>
<?php
//uncomment the folllowing if behind the proxy
//  $PROXY_HOST = "172.31.100.25"; // Proxy server address
// $PROXY_PORT = "3128";    // Proxy server port
// $PROXY_USER = "edcguest";    // Username
// $PROXY_PASS = "edcguest";   // Password
// // Username and Password are required only if your proxy server needs basic authentication

// $auth = base64_encode("$PROXY_USER:$PROXY_PASS");
// stream_context_set_default(
//  array(
//   'http' => array(
//    'proxy' => "tcp://$PROXY_HOST:$PROXY_PORT",
//    'request_fulluri' => true,
//    'header' => "Proxy-Authorization: Basic $auth"
//    // Remove the 'header' option if proxy authentication is not required
//   )
//  )
// );
 ?> 
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title><Table> Responsive</title>
  
  
  
      <link rel="stylesheet" href="css/style_table.css">

  
</head>

<body>
<?php
if(isset($_GET['link'])||isset($_GET['report']))
{
	echo "<h1><span class='blue'></span>Summary of Links<span class='blue'></span> </h1>
<h2><a>".$domain."</a></h2>

<table class='container'>
	<thead>
		<tr>
			<th><h1>Sites</h1></th>
			<th><h1>Size</h1></th>
			<th><h1>Type</h1></th>
			<th><h1>Status</h1></th>
		</tr>
	</thead>
	<tbody>";
	include 'dead_link.php';
	echo " 
	</tbody>
</table>";	
}
  
?>
<?php
if(isset($_GET['size'])||isset($_GET['report']))
{
	echo "<h1><span class='blue'></span>Summary of Images<span class='blue'></span> </h1>
<h2><a>".$domain."</a></h2>

<table class='container'>
	<thead>
		<tr>
			<th><h1>Source</h1></th>
			<th><h1>Height</h1></th>
			<th><h1>Width</h1></th>
			<th><h1>Type</h1></th>
			<th><h1>Status</h1></th>
		</tr>
	</thead>
	<tbody>";
	include 'image_size.php';
	echo " 
	</tbody>
</table>";	
}
  
?>
<?php
if(isset($_GET['rank'])||isset($_GET['report']))
{
	echo "<h1><span class='blue'></span>Rank Of Website<span class='blue'></span> </h1>
<h2><a>".$domain."</a></h2>

<table class='container'>
	<thead>
		<tr>
			<th><h1>Site</h1></th>
			<th><h1>Rank</h1></th>
			
		</tr>
	</thead>
	<tbody>";
	include 'rank.php';
	echo " 
	</tbody>
</table>";	
}
  
?>

</body>

</html>
