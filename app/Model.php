<?php
/**
 *
 */
class Model {

	private $table = 'picture';

    function __construct()
    {
        # code...
    }

    // INSERT INTO pictures(url, isAdmin) values (:url, :isAdmin)

	/* $data = [
		'avatar' => 'adsd.png',
		'isAdmin' => 1,
	]; */

    public function save($user)
	{
		if (empty($user['avatar'])) {
			echo 'Error user save: avatar is not set';
			return false;
		}
		if (empty($user['isAdmin'])) {
			echo 'Error user save: isAdmin is not set';
			return false;
		}
		if (empty($user['login'])) {
			echo 'Error user save: login is not set';
			return false;
		}
		$data = [
			':avatar' => $user['avatar'],
			':is_admin' => ($user['isAdmin'] === 'true') ? 1 : 0,
			':login' => $user['login']
		];
		try {
			$req = Database::query('INSERT INTO '.$this->table.' (avatar, is_admin, login) values (:avatar, :is_admin, :login)', $data);
		} catch (PDOException $e) {
			echo 'Error save query: '.$e->getMessage();
			return false;
		}
		return ($req->rowCount() > 0);
    }

    public function query()
	{
		try {
        	$req = Database::query('SELECT avatar, is_admin, login FROM '.$this->table);
		} catch (PDOException $e) {
			echo 'Error select query: '.$e->getMessage();
			return [];
		}
		$items = $req->fetchAll(PDO::FETCH_ASSOC);
        return $items;
    }
}
