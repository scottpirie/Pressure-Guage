<html>
    <head>
	<script type="text/javascript" src="dygraph.js"></script>
	<link rel="stylesheet" href="dygraph.css" />
	<style type="text/css">
	    #graphdiv2 {
		position: absolute;
		left: 10px;
		right: 10px;
		top: 100px;
		bottom: 10px;
	    }
	</style>
    </head>

    <body>

	<?php
	    $db=mysql_connect("db753524123.db.1and1.com", "dbo753524123", "Abcd1234!") or die("Could not connect");    //connection to database
	    mysql_select_db("db753524123", $db) or die("select failed");    // Select db.
	    $result = mysql_query("SELECT datetime,value from Test ORDER BY datetime DESC LIMIT 1");
	    while($r = mysql_fetch_array($result)) {
		$dt=date('Y/m/d H:i:s',(strtotime($r['datetime'])-10800));
		$v=$r['value'];
		$ht=$v*0.15608 - 115.07;
		$pt=$ht/24*100;
		echo "<H2><CENTER>Jarvis Water Tank Level</CENTER></H2>";
		echo "<B><font size=\"+1\">Currently the tank is: </B> ";
		echo round ($pt,1);
		echo "<B>% full</b> (";
		echo round($ht,1);
		echo " ft) <B> At: </B>";
		echo $dt;
		echo "</font>";
	    }
	?>

	<div id="graphdiv2" ></div>
	<script type="text/javascript">
	g2 = new Dygraph( document.getElementById("graphdiv2"),
		<?php
		    $db=mysql_connect("db753524123.db.1and1.com", "dbo753524123", "Abcd1234!") or die("Could not connect");    //connection to database
		    mysql_select_db("db753524123", $db) or die("select failed");    // Select db.
		    $result = mysql_query("SELECT datetime,value from Test WHERE datetime > \"2018-10-20\"");
		    echo "[";                                  // start of the 2 dimensional array
		    while($r = mysql_fetch_array($result)) {
			    $a=$r['datetime'];
			    $dt=date('Y/m/d H:i:s',(strtotime($r['datetime'])-10800));
			    $dt= '"'.$dt.'"';
			    $h=$r['value'];
			    $ht=$h*0.15608 - 115.07;
			    if (($ht > 0) && ($ht < 30)) 
				    echo "["."new Date($dt)".",".$ht."],";       //displaying a row of the 2-d array
		    }
		    echo "]";
		?>, 
		{
		    // Chart Options
		    legend: 'always',
		    ylabel: 'Water Level in Ft',
		    showRangeSelector: true,
		    rollPeriod: 1,
		    showRoller: false,
		    fillGraph: true,
		    colors: ['#000080'],
		}
	);
	</script>
    </body>
</html>
