<?php

namespace App\controllers;

class PagesController
{

	public function index()
	{
		echo 'Home page';
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