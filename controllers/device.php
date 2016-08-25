<?php
class Device extends Controller
{
    public function __construct()
    {
        //echo "Контроллер обработки ошибок";
        parent::__construct();
        //$this->view->msg = 'Страницы не существует != (';
        //$this->view->render('error / index');
    }
    public function settings()
    {
        $this->view->render('device/settings');
    }
    public function all()
    {
        $this->view->render('device/all');
    }
    public function index()
    {
        $this->view->msg = 'Страницы не существует999!';
        $this->view->render('error/index');
    }
    public function create()
    {
        $this->view->render('device/new');
    }
    public function edit()
    {
        $this->view->render('device/edit');
    }
    public function addDevice()
	{
		$this->model->addDevice();
	}
	public function oidsname()
	{
		if(empty($_POST['grp']))
			exit();
		else
			$this->model->oidsname();
	}
	public function count()
	{
		$this->model->count();
	}
	public function groups()
	{
		$this->model->groups();
	}
	public function editForm()
	{
		$this->model->editForm();
	}
	public function deleteDevice()
	{
		if(empty($_POST['ip']))
			{
				echo 'Unknown IP';
			}
		else
			$this->model->deleteDevice();
	}
	public function editDevice()
	{
		$this->model->editDevice();
	}
}
?>