<?PHP
class OS_BR{
    private $agent = "";
    private $info = array();
    function __construct(){
        $this->agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
        $this->getBrowser();
    }
    function getBrowser(){
        $browser = array("Navigator"            => "/Navigator(.*)/i",
                         "Firefox"              => "/Firefox(.*)/i",
                         "Internet Explorer"    => "/MSIE(.*)/i",
                         "Microsoft Edge"       => "/Edge(.*)/i",                         
                         "Google Chrome"        => "/chrome(.*)/i",
                         "MAXTHON"              => "/MAXTHON(.*)/i",
                         "Opera"                => "/Opera(.*)/i",
                         );
        foreach($browser as $key => $value){
            if(preg_match($value, $this->agent)){
                $this->info = array_merge($this->info,array("Browser" => $key));
                $this->info = array_merge($this->info,array(
                  "Version" => $this->getVersion($key, $value, $this->agent)));
                break;
            }else{
                $this->info = array_merge($this->info,array("Browser" => "UnKnown"));
                $this->info = array_merge($this->info,array("Version" => "UnKnown"));
            }
        }
        return $this->info['Browser'];
    }
    function getVersion($browser, $search, $string){
        $browser = $this->info['Browser'];
        $version = "";
        $browser = strtolower($browser);
        preg_match_all($search,$string,$match);
        switch($browser){
            case "firefox": $version = str_replace("/","",$match[1][0]);
            break;
            case "internet explorer": $version = substr($match[1][0],0,4);
            break;
            case "opera": $version = str_replace("/","",substr($match[1][0],0,5));
            break;
            case "navigator": $version = substr($match[1][0],1,7);
            break;
            case "maxthon": $version = str_replace(")","",$match[1][0]);
            break;
            case "microsoft edge": $version = str_replace("/","",$match[1][0]);
            break;
            case "google chrome": $version = substr($match[1][0],1,10);
        }
        return $version;
    }
    function showInfo($switch){
        $switch = strtolower($switch);
        switch($switch){
            case "browser": return $this->info['Browser'];
            break;
            case "version": return $this->info['Version'];
            break;
            case "all" : return array($this->info["Version"], 
            $this->info['Browser']);
            break;
            default: return "Unknown";
            break;
        }
    }
}
$obj = new OS_BR();
?>

<!DOCTYPE html>
<html>
<head>
	<title>TUGAS 5 AUL_INDAH</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body style="background-color: #3f8ea8;">
	<div style="margin-top: 5%; margin-bottom: 1%; margin-right: 20%; margin-left: 25%; padding-bottom: 3% ;font-size: 50px; border-bottom: 5%; border: solid #333 1px; text-align: center;">	<h1>Haloo<?php session_start(); echo " ".$_SESSION['login']."!"; ?></h1>
		<script type="text/javascript">  var today = new Date();  var hour = today.getHours();
		if(hour >= 6 && hour < 12){   document.write ("GOOD MORNING")  }
		else if (hour>=12 && hour<18){   document.write ("GOOD AFTERNOON")  }
		else {   document.write ("GOOD EVENING")  } 
		</script>
	<br>
	</div>
	<<div>   
        <h1 style="text-align: center; color: #333; font-size: 15px; font-family:verdana;">the browser you are using is<br>
            <?php echo $obj->showInfo('browser')." versi ".$obj->showInfo('version'); ?>
        </h1><br>
        <h2 style="text-align: center; color: #333;">W h a t 's  y o u r  m a i n  f o c u s  t o d a y  ?</h2>
    </div>	
</body>
</html>