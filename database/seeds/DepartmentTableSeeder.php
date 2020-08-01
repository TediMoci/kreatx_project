<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'title' => 'Finance',
                    'children' => [
                        [    
                            'title' => 'Financial Management',
                            'children' => [
                                    ['title' => 'Internal Auditing'],
                                    ['title' => 'Controlling'],
                                    ['title' => 'Treasurers'],
                            ],
                        ],
                        [    
                            'title' => 'Business',
                                'children' => [
                                    ['title' => 'Sales'],
                                    ['title' => 'Marketing'],
                                    ['title' => 'Business Administration'],
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'Software Development',
                        'children' => [
                        [
                            'title' => 'Backend Development',
                            'children' => [
                                ['title' => 'Backend Developers'],
                                ['title' => 'Backend Testers'],
                            ],
                        ],
                        [
                            'title' => 'Mobile Development',
                            'children' => [
                                ['title' => 'iOS Developers'],
                                ['title' => 'Android Developers'],
                                ['title' => 'Mobile Testers'],
                            ],
                        ],
                    ],
                ],
        ];
        foreach($departments as $department)
        {
            \App\Department::create($department);
        }
    }
}
