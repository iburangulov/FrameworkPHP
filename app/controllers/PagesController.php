<?php

namespace App\controllers;

use App\models\PagesModel;

class PagesController
{
	private $model;

	public function __construct()
	{
		$this->model = new PagesModel('pages');
	}

	public function index()
	{
		$res = $this->model->find('name', 'home');
		var_dump($res);
	}

	public function about()
	{
		echo 'About';
	}

	public function post($id)
	{
		echo 'Post - ' . $id;
	}

}