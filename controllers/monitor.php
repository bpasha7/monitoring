<?php
class Monitor extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function on()
    {
        $this->view->render('monitor/index');
       
    }
    public function update()
    {
        $this->model->update();
       
    }
    public function refresh()
    {
       $this->model->refresh();
    }
    public function create()
    {
$to      = 'bpasha@mail.ru';
$subject = 'the subject';
$message = 'Ready';
$headers = 'From: test <s.ql@bk.ru>' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

echo mail($to, $subject, $message, $headers);
    }
   /* private function parse($str)
    {
		$s = $str;
		$p = array("/","*","+","-");
		$start = 0;
		for($i = 0; $i < strlen($str); $i++){
			for($j = 0; $j < count($p); $j++){
				if($str[$i] == $p[$j] || $i == strlen($str) - 1){
					if($i == strlen($str) - 1)
					$c = substr($str,$start,$i - $start + 1);
					else
					$c = substr($str,$start,$i - $start);
					$c = str_replace(array("(",")"), "", $c);
					$s     = str_replace($c,'ok',$s);
					$start = $i + 1;
					$i     = $start;
				}
			}
		}+
		echo $s;
		return $s;
	}*/
    public function test()
    {
		/*$ma ="89*10";
$p = eval('return '.$ma.';');
print $p;*/

$str='10';
$s=$str;
$p = array("/","*","+","-");
$start=0;
for($i=0; $i<strlen($str); $i++)
{
	for($j=0; $j<count($p); $j++)
	{
		if($str[$i]==$p[$j]||$i==strlen($str)-1)
		{
			if($i==strlen($str)-1)
				$c= substr($str,$start,$i-$start+1);
			else
				$c= substr($str,$start,$i-$start);
				//
			$c = str_replace(array("(",")"), "", $c);
			if(!is_numeric($c))
				$s=str_replace($c,'70',$s);
			$start = $i+1;
			$i=$start;
			//echo $s;
		}
	}
}
//echo $s;
$p = eval('return '.$s.';');
print $p;
return $s;
	}
}
?>