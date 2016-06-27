<!DOCTYPE html>
<html>
<head>
<title>天気予報</title>
<meta charset="utf-8">
</head>
<body>
<p><a href="http://weather.livedoor.com/forecast/rss/primary_area.xml">地域とIDの定義表</a></p>
<form method="GET" action="./weather.php">
<input type="text" name="cityCode" required>
<input type="submit" value="検索" style="display:inline">
</form>
<hr>
<?php
if(isset($_GET["cityCode"])){
	$code = $_GET["cityCode"];
	$url = 'http://weather.livedoor.com/forecast/webservice/json/v1';
	$query = ['city' => $code];
	$proxy = array("http" => array("proxy" => "tcp://proxy.kmt.neec.ac.jp:8080", "request_fulluri" => true));
			
	$proxy_context = stream_context_create($proxy);
    $response = file_get_contents(
	    $url . '?' . http_build_query($query),
        false);

    $result = json_decode($response, true);

    print("<p>" . $result["location"]["city"] . "</p>");
    foreach($result["forecasts"] as $forecast){
    	print("<p>" . $forecast["date"] . "<img style='display:inline;' src='" . $forecast["image"]["url"] . "'>" . $forecast["telop"] . "</p>");
    }
}
?>
</body>
</html>