<?php
class Oid_Model extends Model
{
    public function __construct()
    {    
        parent::__construct();
    }
    public function deleteOid()
    {
		$sth = $this->database->prepare('SELECT DeleteOid('.$_POST['oidid'].')');
        $sth->execute();
        $sth->closeCursor(); 
	}
    public function NewOid()
    {
    	$sth = $this->database->prepare("SELECT NewOid(:grp, :name, :oid)");
        $sth->execute(array(
                        ':grp' =>  $_POST['group'],
                        ':name' => $_POST['name'],
                        ':oid' => $_POST['oid']
                    ));
        $sth->closeCursor(); 
	}
	private function parseGroup($row)
    {
		switch($row['GroupId'])
			{
				case 1:
		echo '<li class="cl">
                    <div>
                        <p>
                            <a class="sc" onclick="return UnHide(this)">&#9658;</a>
                            <a><img src="public/images/printer.png" class="i" />'.$row['GroupName'].'</a>
                        </p>
                    </div>
                        <ul>';	
				break;
				case 2:
		echo '<li class="cl">
                    <div>
                        <p>
                            <a class="sc" onclick="return UnHide(this)">&#9658;</a>
                            <a><img src="public/images/router.png" class="i" />'.$row['GroupName'].'</a>
                        </p>
                    </div>
                        <ul>';
				break;
				case 3:
		echo '<li class="cl">
                    <div>
                        <p>
                            <a class="sc" onclick="return UnHide(this)">&#9658;</a>
                            <a><img src="public/images/pc.png" class="i" /> '.$row['GroupName'].'</a>
                        </p>
                    </div>
                        <ul>';
				break;
			}
	}
    public function showTree()
    {
		//echo 'tree';
		$sth = $this->database->prepare("SELECT * FROM oidtree");
        $sth->execute();
        $count = $sth->rowCount();
        //$select='<option value="0" disabled>Свойства</option>';
        echo '<ul>
        <li>
            <div><p><a class="sc" onclick="return UnHide(this)">&#9660;</a>
                <a href="#">Устройства</a></p></div>
            <ul>';
       	$first = true;
        if ($count > 0) {
        	$lastGroup ='';
            while ($row = $sth->fetch(PDO::FETCH_LAZY)) {

            	//if($lastGroup)

            	if($lastGroup != $row['GroupId'] )
            	{
            		if($first)
            		{
            			$this->parseGroup($row);   
            			$first = FALSE;
            			$lastGroup = $row['GroupId'];  			
					}
					else
					{
						echo '</ul>
               		 </li>';
                		$lastGroup = $row['GroupId'];
                		$this->parseGroup($row); 
					}					
				}				
				echo ' <li>
                            <div>
                                <p>
                                    <table cellspacing="0" id="maket">
                                    <td id="leftcol">
                                    <a>'.$row['Name'].'</a>
                                    </td></tr></table>
                                    <a>[ '.$row['OID'].' ]</a> <img src="public/images/del.png" class="del" rel="'.$row['Id'].'"/>                                </p>
                            </div>
                        </li>';

            }
            echo '</ul>
               	</li>
               	<li>
                   <div>
                   <p ><a class="sc">    <strong>+</strong></a><a href="http://monitoring.dev/oid/create" style="color: green" >Добавить новый OID</a></p>
                   </div>
                   </li>
               	</ul>
              </li>';
        }
        $sth->closeCursor();
	}
}
?>