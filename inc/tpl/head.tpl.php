<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Greifmasters Tournament Management</title>
<link rel="stylesheet" type="text/css" href="/greifmasters/style.css">


<script src="/greifmasters/javascripts/prototype.js" type="text/javascript"></script>
<script src="/greifmasters/javascripts/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="/greifmasters/javascripts/scriptaculous.js" type="text/javascript"></script>
<!--<script src="/greifmasters/javascripts/display.js" type="text/javascript"></script>-->
<script src="/greifmasters/javascripts/time.js" type="text/javascript"></script>
<script>jQuery.noConflict();</script>
<?php if (isset($header)){echo $header;}?>

</head>
<body onload="init();" onunload="StopTimer();">
<audio id="horn" src="/greifmasters/horn.wav" autobuffer="true">No audio</audio>
<div id="pageframe">
