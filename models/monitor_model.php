<?php
class Monitor_Model extends Model
{
    public function __construct()
    {    
        parent::__construct();
    }
    public function update()
    {
		$sth = $this->database->prepare("SELECT * FROM Devices WHERE DeviceId = ".$_POST['deviceid']);
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
        			$prop[$i+1] = $result;
        		else
        		{
					$state = false;	
					break;
				}			
			}
		$div.= '<span class="tooltiptext">';
		for ($i= 0; $i < count($prop); $i+=2)
			$div.=  $prop[$i].': '.substr($prop[$i+1], strpos($prop[$i+1],":")+1, strlen($prop[$i+1])).'<br/>';
		$div.=  '</span>';
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
    public function refresh()
    {
		$sth = $this->database->prepare("SELECT * FROM Devices");
        $sth->execute();
        error_reporting(0);
        while ($row = $sth->fetch(PDO::FETCH_LAZY))
        {
        	$prop = json_decode($row['Properties']);
        	$state = true;
        	for($i=0;$i<count($prop);$i+=2)
        	{
				$result= snmpget($row['DeviceIP'], $row['Community'], $prop[$i+1], $row['Timeout']);
        		if($result)
        			$prop[$i+1] = $result;
        		else
        		{
					$state = false;	
					break;
				}			
			}
        	if($state)
        	{
				echo '<div id="d'.$row['DeviceId'].'" class="device_on">';
				createToolTip($prop);
				/*$sth = $this->database->prepare("UPDATE devices SET Properties = :prop WHERE DeviceIP = :ip");
        $sth->execute(array(
                        ':ip' => $_POST['ip'],
                        ':prop' =>  json_encode($_POST['prop'])
                    ));
        $sth->closeCursor();*/
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
		echo $prop[$i].': '.substr($prop[$i+1], strpos($prop[$i+1],":")+1, strlen($prop[$i+1])).'<br/>';
	echo '</span>';
}
?>