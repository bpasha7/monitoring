<?php
class Monitor_Model extends Model
{
    public function __construct()
    {    
        parent::__construct();
    }
    public function update()
    {
		$sth = $this->database->prepare("CALL GetDevice(".$_POST['deviceid'].")");
        $sth->execute();
        error_reporting(0);
        $row = $sth->fetch(PDO::FETCH_LAZY);
        if($row=="")
        	exit();
        $prop = json_decode($row['Properties']);
        	$state = true;
        	for($i=0;$i<count($prop);$i+=2)
        	{
				$result= snmpget($row['DeviceIP'], $row['Community'], $prop[$i+1], $row['Timeout']);
        		if($result)
        		{
                    $prop[$i + 1] = $result;
                    
        		}
        		else
        		{
					$state = false;	
					break;
				}			
			}
			if($state){
				$div .= '<span class="tooltiptext">';
                    for ($i = 0; $i < count($prop); $i += 2)
                    $div .= $prop[$i].': '.substr($prop[$i + 1], strpos($prop[$i + 1],":") + 1, strlen($prop[$i + 1])).'<br/>';
                    $div .= '</span>';
			}
		
			switch($row['GroupId'])
			{
				case 1:
	$div .= '<img class="refresh" src="public/images/refresh.png" deviceId="'.$row['DeviceId'].'" />
	<img class="printer" src="public/images/printer.png"/>
	<label>'.$row['DeviceIP'].'</label>';		
				break;
				case 2:
	$div .= '<img class="refresh" src="public/images/refresh.png" deviceId="'.$row['DeviceId'].'" />
	<img class="router" src="public/images/router.png"/>
	<label>'.$row['DeviceIP'].'</label>';
				break;
				case 3:
	$div .= '<img class="refresh" src="public/images/refresh.png" deviceId="'.$row['DeviceId'].'" />
	<img class="pc" src="public/images/pc.png"/>
	<label>'.$row['DeviceIP'].'</label>';
				break;
			}	
			//$div=createToolTip($prop);
			echo json_encode(array($div, $state));		
			//$div+=  '</div>';
	}
 	/*public function refresh()
 	{
		
	}*/
	private function parse($str, $row)
    {
		$s = $str;
		$p = array("/","*","+","-");
		$start = 0;
		$simple=TRUE;
		for($i = 0; $i < strlen($str); $i++){
			for($j = 0; $j < count($p); $j++){
				if($str[$i] == $p[$j] || $i == strlen($str) - 1){
					if($i == strlen($str) - 1)
						$c = substr($str,$start,$i - $start + 1);
					else
						{
							$c = substr($str,$start,$i - $start);
							$simple=FALSE;
						}
					$c = str_replace(array("(",")"), "", $c);
					$res = snmpget($row['DeviceIP'], $row['Community'], $c, $row['Timeout']);
					$res = substr($res, strpos($res,":")+1, strlen($res));
					if(!is_numeric($c))
						$s     = str_replace($c, $res ,$s);
					$start = $i + 1;
					$i = $start;
					
				}
			}
		}	
		//echo $s;
		if($simple)
			$p = snmpget($row['DeviceIP'], $row['Community'], $str, $row['Timeout']);
		else
			$p = eval('return '.$s.';');
		//print $p;
		return $p;
	}
    public function refresh()
    {
		$sth = $this->database->prepare("CALL GetDevices(".$_POST['from'].", ".$_POST['cnt'].", ".$_POST['grp'].")");
        $sth->execute();
        error_reporting(0);
        while ($row = $sth->fetch(PDO::FETCH_LAZY))
        {
        	$prop = json_decode($row['Properties']);
        	$state = true;
        	for($i=0;$i<count($prop);$i+=2)
        	{
        		
				//$result= snmpget($row['DeviceIP'], $row['Community'], $prop[$i+1], $row['Timeout']);
				$result = $this->parse($prop[$i+1], $row);
				//echo $result.'\\';
        		if($result)
        			$prop[$i+1] = $result;
        		else
        		{
        			//$prop[$i+1] = 'ytn';
					$state = false;	
					break;
				}			
			}
        	if($state)
        	{
				echo '<div id="d'.$row['DeviceId'].'" class="device_on">';
				createToolTip($prop);
			}		
        	else
        		echo '<div id="d'.$row['DeviceId'].'" class="device_off">';
			switch($row['GroupId'])
			{
				case 1:
	echo '<img class="refresh" src="public/images/refresh.png" deviceId="'.$row['DeviceId'].'" />
	<img class="printer" src="public/images/printer.png"/>
	<label>'.$row['DeviceIP'].'</label>';	
				break;
				case 2:
	echo '<img class="refresh" src="public/images/refresh.png" deviceId="'.$row['DeviceId'].'" />
	<img class="router" src="public/images/router.png"/>
	<label>'.$row['DeviceIP'].'</label>';
				break;
				case 3:
	echo '<img class="refresh" src="public/images/refresh.png" deviceId="'.$row['DeviceId'].'" />
	<img class="pc" src="public/images/pc.png"/>
	<label>'.$row['DeviceIP'].'</label>';
				break;
			}
			
			echo '</div>';
		}
	}
}
function createToolTip($prop)
{
	//$prop = json_decode($prop);
	echo '<span class="tooltiptext">';
	for ($i= 0; $i < count($prop); $i+=2)
	if(strpos($prop[$i+1],":"))
		echo $prop[$i].': '.substr($prop[$i+1], strpos($prop[$i+1],":")+1, strlen($prop[$i+1])).'<br/>';
	else 
		echo $prop[$i].': '.$prop[$i+1].'<br/>';
	echo '</span>';
}
?>