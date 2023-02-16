<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class FieldSeeder extends Seeder
{
    /**
     * Seed the fields of study database table for the institution
     *
     * @return void
     */
    public function run(): void
    {
        $seedFields = [
            [
                'name' => 'Aerospace, Maritime and Logistics',
                'description' => "With the uptake of online shopping, supply chain has become the major conduit to fulfil the transfer of global goods and services. You could become a valuable part in an evolving industry by gaining the necessary skills for working in the supply chain industry.",
            ],
            [
                'name' => 'Agricultural Science and the Environment',
                'description' => "Learn aspects of working in a nursery and with plant propagation. This skill set will give you the skills and knowledge for entry level employment in a nursery centre and covers basic nursery preparation skills for plant propagation and care for nursery plants. It is suitable for anyone wishing to work in Horticulture industry.",
            ],
            [
                'name' => 'Automotive',
                'description' => "Gear up for a career in the automotive industry. This area has courses spanning from our pre-apprenticeship course - where you will gain the skills to become an apprentice mechanic - through to courses covering the requirements for you to upskill your career into the Airconditioning, Electrical, Servicing and Trimming branches of the industry.",
            ],
            [
                'name' => 'Building and Construction',
                'description' => "Build your career from the ground up with courses from Bricklaying, Plastering, Carpentry and Decorating to the basics of Architectural Design and Construction. Work as a builder or manager of a small to medium building business dealing with low-rise residential and commercial construction projects. Learn to plan and supervise construction projects and prepare, cost and schedule contracts.",
            ],
            [
                'name' => 'Business and Finance',
                'description' => "Account for your future by gaining the skills necessary to manage your own business; or learn the principles of Bookkeeping, Account Management and Data Analysis to begin your climb of the corporate ladder in a range of industries. You'll learn how to set up and maintain computerised accounts, establish payroll systems, maintain inventory records, prepare financial reports prepare and lodge business and instalment activity statements and provide advice to taxpayers in relation to activity statements.",
            ],
            [
                'name' => 'Creative Industries',
                'description' => "Design your career in the creative and cultural heart of the city. North Metro TAFE has a well established fashion department offering a stimulating design space that combines creativity with the underpinning practical skills necessary for success in an exciting and challenging industry.",
            ],
            [
                'name' => 'Community Services',
                'description' => "Make a difference to the lives of others. This study area focuses on providing assessment and support to clients with alcohol and drug issues. You will learn about interviewing in the initial client assessment, responding to crisis, working with people with mental health concerns, and providing alcohol and other drugs (AOD) interventions.",
            ],
            [
                'name' => 'Engineering',
                'description' => "Whether you are upskilling or looking for a career change, these courses will give you the drafting skills to work in the Mechanical Engineering and Drafting sector. The Mechanical Engineering Drafting Skill Set will equip you with the skills needed to use AutoCAD to complete mechanical engineering design drawings for CNC processes in manufacturing. Or take our courses in Advanced Welding with specializations in Manual Metal Arc and Gas Tungsten Arc Welding skill sets.",
            ],
            [
                'name' => 'Health and Fitness',
                'description' => "Become part of a vital health care team with our introductory and advanced courses in Allied Health Assistance, Physiotherapy and Anaesthetic Technology. You may find employment in both public and private health settings such as hospitals and community rehabilitation, aged care facilities, schools, mental health clinics, private practices and not-for-profit organisations.",
            ],
            [
                'name' => 'Hospitality, Tourism and Events',
                'description' => "Are you a born organiser? Turn that natural talent into a career with our courses which will prepare you for senior roles in hospitality and give you a variety of administration and operational skills and knowledge of event management processes as well as events coordination. You'll be equipped to work independently and make operational event management decisions.",
            ],
            [
                'name' => 'Information Technology',
                'description' => "Welcome to the 21st century!! Gain the basic skills and knowledge to use digital technology in the workplace with our Applied Digital Technologies course, learn to build and repair computers, or develop a career in Cyber Security, Programming or Networking with courses from beginner to advanced in Back-End, Games Programming and Web Development.",
            ],
            [
                'name' => 'Language Foundation Studies',
                'description' => "Prepare yourself for a career anywhere across the globe by learning the basics of Language. Start your journey to understanding with courses in Japanese language and culture; set yourself up to integrate easily in more than 20 countries by learning Arabic; or gain the skills of Auslan, allowing you to communicate socially and in the workplace.",
            ],
        ];

        $countItems = count($seedFields);
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $countItems);
        $this->command->getOutput()->writeln("<info>Seeding $countItems Fields of study for the institution ...");

        foreach ($seedFields as $item) {
            $field['name'] = $item['name'];
            $field['description'] = $item['description'];
            Field::create($field);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->getOutput()->writeln("");
    }
}

