<?php

/**
 *
 */
class Controller
{

    private $model;

    function __construct()
	{
		/* if (isset($_POST['users'])) {
	    	var_dump($_POST['users']);
		} */
    	$this->model = new Model();
		$this->save();
    }

    public function save()
	{
		$data = $this->getData();
		/* echo "<pre>";
		print_r($data);
        echo "</pre>"; */

        if (!$data) {
			if (!isset($_POST['users'])) {
				return false;
			}
            $users = $_POST['users'];
			foreach ($users as $user) {
            	$res = $this->model->save($user);
				if (!$res) {
					echo 'Error user save: avatar='.$user['avatar'].' isAdmin='.$user['isAdmin'].' login='.$user['login'];
					break;
				}
			}
			exit;
        }
    }
    
    public function jsParams()
	{
		$users = $this->getData();
		foreach ($users as &$user) {
			$user = [
				'avatar' => $user['avatar'],
				'isAdmin' => ($user['is_admin'] == 1),
				'login' => $user['login']
			];
		}
		echo '<script>';
			echo 'var users = '.json_encode($users);
		echo '</script>';
	}

	private $data = null;

    public function getData()
	{
		if ($this->data === null) {
			$this->data = $this->model->query();
		}
        return $this->data;
    }
}
