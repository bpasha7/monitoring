<?php
class Monitor extends Controller
{
    public function __construct()
    {
        //echo "Контроллер обработки ошибок";
        parent::__construct();
        //$this->view->msg = 'Страницы не существует != (';
        //$this->view->render('error / index');
        //$this->view->render('monitor/index');
        //$this->model->refresh();
    }
    public function on()
    {
        //$this->view->msg = 'Страницы не существует999!';
        $this->view->render('monitor/index');
       
    }
    public function update()
    {
        //$this->view->msg = 'Страницы не существует999!';
        $this->model->update();
       
    }
    public function refresh()
    {
        //$this->view->msg = 'Страницы не существует999!';
       // $this->view->render('monitor/index');
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
    public function test()
    {
		$ma ="2+10";
$p = eval('return '.$ma.';');
print $p;
	}
}
?>