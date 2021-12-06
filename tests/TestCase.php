<?php

namespace Tests;

use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication, DatabaseTransactions, WithFaker, TestHelpers;

	public function __construct()
	{
		parent::__construct();

		Mail::fake();
	}
}
