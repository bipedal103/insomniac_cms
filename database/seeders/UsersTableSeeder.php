<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Admin::create()->authParent()->create([
			'name' => 'ricardo',
			'email' => 'ricardo@lloyds-digital.com',
			'password' => 'owen10',
			'timezone' => 'Europe/Zagreb',
			'email_verified_at' => formatTimestamp()
		]);
	}
}
