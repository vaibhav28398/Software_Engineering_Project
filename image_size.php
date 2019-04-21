<?php
if(!function_exists('getResponseHeader')){
function getResponseHeader($header, $response) {
  if(is_array($response) || is_object($response)){
  foreach ($response as $key => $r) {
     // Match the header name up to ':', compare lower case
     if (stripos($r, $header . ':') === 0) {
        list($headername, $headervalue) = explode(":", $r, 2);
        return trim($headervalue);
     }
  }}
}
}
if(!function_exists('check_url')){
  function check_url($url) {
   $headers = @get_headers( $url);
   $headers_for_http_code = (is_array($headers)) ? implode( "\n ", $headers) : $headers;
   echo "<td>".getResponseHeader("Content-Length",$headers)."</td>";
   return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers_for_http_code);
}
}
function image_size($image)
{
	list($width, $height, $type, $attr) = getimagesize($image); 
	echo "<td>" . $width . "</td>"; 
	echo "<td>" . $height . "</td>"; 
	echo "<td>" . $type . "</td>";
  if($width*$height>40000) 
	echo "<td>Warning</td>";
  else
  echo "<td>Feasible</td>"; 
}
$domain=$_GET['domain'];
echo"<tr>";
echo"<td>".$domain."</td>";
if (check_url($domain))
  {
    echo "<td>Html</td>";
    echo "<td>Active</td>";
  }
else
  {
    echo "<td>N/A</td>";
    echo "<td>Broken</td>";
    die();
  }
echo"</tr>";
$html = file_get_contents($domain);
$dom = new DOMDocument;
@$dom->loadHTML($html);
$images_names = $dom->getElementsByTagName('img');
foreach ($images_names as $image)
{
  ob_flush();
  flush();
  echo"<tr>";
	$src_link=$image->getAttribute('src');
  echo"<td>".$src_link."</td>";
	if(strpos($src_link,'http://')===0||strpos($src_link,'https://')===0)
    {
      //do nothing
    }
    else 
    {
      if(substr($domain,-1)=='/')
        $src_link=$domain.$src_link;
      else
        $src_link=$domain."/".$src_link;      
    }
	image_size($src_link);
  echo"</tr>";
}
?>