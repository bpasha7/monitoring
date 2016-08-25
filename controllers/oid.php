<?php
class Oid extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function create()
    {
        $this->view->render('oid/new');
    }
    public function show()
    {
        $this->view->render('oid/show');
    }
   	public function add()
	{
		if(empty($_POST['group'])||empty($_POST['name'])||empty($_POST['oid']))
			echo 'NO';
		else
			$this->model->NewOid();
	}
	public function showTree()
    {
		$this->model->showTree();
	}
	public function deleteOid()
	{
		if(empty($_POST['oidid']))
			echo 'Удаление невозможно';
		else
			$this->model->deleteOid();
	}

}
?>