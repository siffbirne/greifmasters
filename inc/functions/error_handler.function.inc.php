<?php
function error_handler($level, $message, $file, $line, $context) 
{ 
	echo "<br><hr>Fehler in der Datei <b>$file</b> in Zeile <b>$line</b>.<br> 
	Fehlermeldung: <b>$message</b>";
	$datei=file($file);
	$zeile=htmlentities($datei[$line-1]);
	echo '<br>Zeile: <b>'.$zeile.'</b>';
	unset($datei);

	echo '<hr>Entstehungshistorie des Fehlers:';
	$o=(debug_backtrace());

	echo "<pre>";
	$max=sizeof($o)-1;

	for ($i=$max;$i>0;$i--)
	{
		if ($o[$i]['function']!='error_handler')	
		{
			//echo "<br>";print_r($o[$i]);
			echo 'In <b>'.$o[$i]['file'].'</b> Zeile <b>'.$o[$i]['line'].'</b> erfolgt der Funktionsaufruf => <b>';
			echo $o[$i]['function'].'(';
			if (isset($o[$i]['args']))
			{
				$args='';
				foreach ($o[$i]['args'] as $key=>$val)
				{
					if (is_array($key)) $args.=var_dump($a);
					else 
					{
						$args.=$val.',';
					}
				}
				$args=substr($args,0,-1);
				echo $args;
			}
			echo ')</b>.<br>';
		}
	}
	echo '</pre>Der letzte Aufruf verursachte den Fehler in der Zeile: <b>'.$zeile.'</b>';
	echo '<br>Variableninhalte zu diesem Zeitpunkt:<pre>';print_r($context);echo '</pre>';
	die();
} 

// Eigene Fehlerausgabe setzen
set_error_handler('error_handler'); 


?>