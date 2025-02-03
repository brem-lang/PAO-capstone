<?php

namespace Database\Seeders;

use App\Models\IDType;
use App\Models\Language;
use App\Models\Religion;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IDType::create([
            'name' => 'passport',
            'description' => 'Passport',
        ]);
        IDType::create([
            'name' => 'drivers_license',
            'description' => 'Driver\'s License',
        ]);
        IDType::create([
            'name' => 'prc_license',
            'description' => 'PRC License (Professional Regulation Commission)',
        ]);
        IDType::create([
            'name' => 'umid',
            'description' => 'UMID (Unified Multi-Purpose ID)',
        ]);
        IDType::create([
            'name' => 'postal_id',
            'description' => 'Postal ID',
        ]);
        IDType::create([
            'name' => 'voters_id',
            'description' => 'Voter\'s ID or Voter’s Certification with a photo',
        ]);
        IDType::create([
            'name' => 'philhealth',
            'description' => 'PhilHealth',
        ]);
        IDType::create([
            'name' => 'pagibig',
            'description' => 'Pag-IBIG ID',
        ]);
        IDType::create([
            'name' => 'barangay_cert',
            'description' => 'Barangay Certification with Photo',
        ]);
        IDType::create([
            'name' => 'sss_id',
            'description' => 'SSS ID (Social Security System)',
        ]);
        IDType::create([
            'name' => 'senior_citizen',
            'description' => 'Senior Citizen ID',
        ]);
        IDType::create([
            'name' => 'pwd_id',
            'description' => 'PWD ID (Persons with Disabilities)',
        ]);

        // language
        // List of languages to insert
        $languages = [
            'Bisaya',
            'Tagalog',
            'English',
            'Ilocano',
            'Hiligaynon',
            'Bikol',
            'Waray',
            'Kapampangan',
            'Pangasinan',
            'Chavacano',
            'Maranao',
            'Tausug',
            'Maguindanao',
            'Ivatan',
            'Kinaray-a',
            'Yakan',
            'Sambal',
        ];

        // Insert languages into the languages table
        foreach ($languages as $language) {
            Language::create([
                'name' => $language,
            ]);
        }

        // List of religions to insert (matching the structure you provided)
        $religions = [
            'Roman Catholic',
            'Islam',
            'Iglesia ni Cristo',
            'Seventh Day Adventist',
            'Bible Baptist Church',
            "Jehovah's Witness",
        ];

        // Insert religions into the religions table
        foreach ($religions as $religion) {
            Religion::create([
                'name' => $religion,
            ]);
        }
    }
}
