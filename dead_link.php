<?php
// Get any header except the HTTP response...
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

  function check_url($url) {
   $headers = @get_headers( $url);
   $headers_for_http_code = (is_array($headers)) ? implode( "\n ", $headers) : $headers;
   echo "<td>".getResponseHeader("Content-Length",$headers)."</td>";
   return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers_for_http_code);
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
//Create a new DOM document
$dom = new DOMDocument;

@$dom->loadHTML($html);

$links = $dom->getElementsByTagName('a');

foreach ($links as $link){
  ob_flush();
  flush();
  echo"<tr>";
  $href_link=$link->getAttribute('href');
    if(strpos($href_link,'http://')===0||strpos($href_link,'https://')===0)
    {
      //do nothing
    }
    else 
    {
      
      if(substr($domain,-1)=='/'||strpos($href_link,'/')===0)
        $href_link=$domain.$href_link;
      else
        $href_link=$domain."/".$href_link;      
    }
    echo "<td>".$href_link."</td>";
    if (check_url($href_link))
      {
          echo "<td>Html</td>";
          echo "<td>Active</td>";
      }
      else
      {
        echo "<td>N/A</td>";
        echo "<td>Broken</td>";
      }
  echo "</tr>";
    
} ?>