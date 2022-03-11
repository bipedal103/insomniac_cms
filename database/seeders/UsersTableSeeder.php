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
			'name' => 'Ivan',
			'email' => 'ivan@insomni.ac',
			'password' => 'yk4bpkUv*O]X',
			'timezone' => 'Europe/Zagreb',
			'email_verified_at' => formatTimestamp()
		]);
	}
}
