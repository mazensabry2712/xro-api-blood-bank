<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HospitalSeeder extends Seeder
{
	public function run()
	{
		$defaultPassword = Hash::make(env('SEED_HOSPITAL_PASSWORD', 'password123'));

		$hospitals = [
			[
				'name' => 'Cairo Central Hospital',
				'description' => 'Major public hospital in Cairo',
				'license_number' => 'CAIRO-001',
				'type' => 'governmental',
				'address' => 'Downtown, Cairo',
				'phone' => '0220000001',
				'hotline' => '199',
				'email' => 'cc_hospital@example.com',
				'website' => null,
				'longitude' => null,
				'latitude' => null,
				'region_id' => 1,
				'password' => $defaultPassword,
			],
			[
				'name' => 'Giza Specialized Medical Center',
				'description' => 'Private specialty clinic in Giza',
				'license_number' => 'GIZA-001',
				'type' => 'private',
				'address' => 'Dokki, Giza',
				'phone' => '0230000002',
				'hotline' => null,
				'email' => 'giza_med@example.com',
				'website' => null,
				'longitude' => null,
				'latitude' => null,
				'region_id' => 11,
				'password' => $defaultPassword,
			],
			[
				'name' => 'Alexandria University Hospital',
				'description' => 'University-affiliated hospital in Alexandria',
				'license_number' => 'ALEX-001',
				'type' => 'university',
				'address' => 'El Mansheya, Alexandria',
				'phone' => '0340000003',
				'hotline' => null,
				'email' => 'alex_univ@example.com',
				'website' => null,
				'longitude' => null,
				'latitude' => null,
				'region_id' => 17,
				'password' => $defaultPassword,
			],
			[
				'name' => 'Mansoura General Hospital',
				'description' => 'Regional hospital serving Mansoura',
				'license_number' => 'MANS-001',
				'type' => 'governmental',
				'address' => 'Mansoura, Dakahlia',
				'phone' => '0500000004',
				'hotline' => null,
				'email' => 'mans_hosp@example.com',
				'website' => null,
				'longitude' => null,
				'latitude' => null,
				'region_id' => 23,
				'password' => $defaultPassword,
			],
			[
				'name' => 'Hurghada Sea Care',
				'description' => 'Private hospital in Hurghada',
				'license_number' => 'HURG-001',
				'type' => 'private',
				'address' => 'Hurghada, Red Sea',
				'phone' => '0650000005',
				'hotline' => null,
				'email' => 'hurghada_care@example.com',
				'website' => null,
				'longitude' => null,
				'latitude' => null,
				'region_id' => 26,
				'password' => $defaultPassword,
			],
		];

		// upsert keyed by license_number to be idempotent and avoid duplicates
		DB::table('hospitals')->upsert($hospitals, ['license_number'], [
			'name', 'description', 'type', 'address', 'phone', 'hotline', 'email', 'website', 'longitude', 'latitude', 'region_id', 'password'
		]);
	}
}

