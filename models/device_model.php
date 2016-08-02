<?php
class Device_Model extends Model
{
    public function __construct()
    {    
        parent::__construct();
    }
    public function addDevice()
    {
    	$sth = $this->database->prepare("INSERT INTO devices VALUES(NULL, :grp, :ip, :cmt, :tmo, :prop)");
        $sth->execute(array(
                        ':grp' => $_POST['grp'],
                        ':ip' => $_POST['ip'],
                        ':cmt' => $_POST['community'],
                        ':tmo' => $_POST['timeout'],
                        ':prop' =>  json_encode($_POST['prop'])
                    ));
        $sth->closeCursor();      
    }
    public function editDevice()
    {
    	$sth = $this->database->prepare("UPDATE devices SET Properties = :prop, Community = :cmt, Timeout = :tmo WHERE DeviceIP = :ip");
        $sth->execute(array(
                        ':prop' =>  json_encode($_POST['prop']),
                        ':ip' => $_POST['ip'],
                        ':cmt' => $_POST['community'],
                        ':tmo' => $_POST['timeout']
                    ));
        $sth->closeCursor();      
    }
    public function Count()
    {
		$sth = $this->database->prepare("SELECT COUNT(DeviceId) FROM devices");
        $sth->execute();
        $cnt = $sth->fetch(PDO::FETCH_LAZY);
        echo $cnt[0];
        $sth->closeCursor();
	}
    public function deleteDevice()
    {
    	$ip =  $_POST['ip'];
    	$sth = $this->database->prepare("DELETE FROM devices WHERE DeviceIP = '$ip'");
        $sth->execute();
        if($sth->rowCount()==0)
        	echo "Device with IP-Adress $ip was not deleted";
        $sth->closeCursor();      
    }
    public function groups()
    {
        $sth = $this->database->prepare("SELECT GroupId, GroupName FROM Groups");
        $sth->execute();
        $count = $sth->rowCount();
        if ($count > 0) {
            while ($row = $sth->fetch(PDO::FETCH_LAZY)) {
                echo '<option value="'.$row['GroupId'].'">' . $row['GroupName'] . "</option>";
            }
        }
        $sth->closeCursor();
    }
    public function editForm()
    {
    	$ip =  $_POST['ip'];
		$sth = $this->database->prepare("SELECT * FROM devices WHERE DeviceIP = '$ip'");
        $sth->execute();
        $count = $sth->rowCount();
        if ($count > 0) {
            $row = $sth->fetch(PDO::FETCH_LAZY);
            $prop = json_decode($row['Properties']);
			echo '
			<table>
			<tr>
			<td>
			<label for="">
       			 <b>
         	  		 Community 
       		 	</b>
    			</label>
    			</td><td><input id="community" type="text" placeholder="Community name" value="'.$row['Community'].'"/></td>
    			</tr>
    			<tr>
    			<td>
    			<label for="">
       		 	<b>
       		    	 Timeout  
        		</b>
        		</label></td><td><input id="timeout" type="text" placeholder="Timeout(ms)" value="'.$row['Timeout'].'"/></td>
        		</tr>
        		</table>
			<h2>
      		  Properties <img id="add" src="public/images/add.png" alt="" />
   			</h2>
    		<ol>';
    		$countProp=1;
    		for ($i= 0; $i < count($prop); $i+=2)
    		{
				echo '<li id="p'.$countProp.'">
            	<input id="pname" type="text" placeholder="Name property" value="'.$prop[$i].'" />
            	<label for="">
             	   OID:
            	</label><input id="oid" type="text" placeholder="Fill in OID" value="'.$prop[$i+1].'"/><img class="del" src="public/images/del.png" alt="p'.$countProp.'" />
        </li>';
        $countProp++;
			}
       		
			echo '</ol>
			<input id="target" type="submit" value="Edit" />
			<input id="delete" type="submit" value="Delete" />';
            }
            else
            {
				echo 'Not found device';
			}
        $sth->closeCursor();
	}
}
?>