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
        //$this->view->msg = 'Страницы не существует!';
        $this->view->render('monitor/index');
    }
}
?>