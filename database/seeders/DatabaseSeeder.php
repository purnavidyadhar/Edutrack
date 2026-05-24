<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\EduClass;
use App\Models\Subject;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\RemedialPlan;
use App\Models\ProgressRecord;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Classes
        $classA = EduClass::create(['name' => 'Grade 10-A', 'department' => 'Science']);
        $classB = EduClass::create(['name' => 'Grade 10-B', 'department' => 'Commerce']);

        // 2. Create Subjects
        $subjects = ['Mathematics', 'Science', 'English', 'History'];
        $subjectModels = [];
        foreach ($subjects as $s) {
            $subjectModels[] = Subject::create(['name' => $s]);
        }

        // 3. Create Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@edutrack.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 4. Create Teacher
        $teacherUser = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@edutrack.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create(['user_id' => $teacherUser->id]);

        // 5. Create Students with specific Risk Scenarios
        $studentsData = [
            ['name' => 'Alex Rivera', 'email' => 'alex@edutrack.com', 'roll' => '101', 'scores' => [45, 50, 40, 60, 30]], // Slow Learner
            ['name' => 'Emily Chen', 'email' => 'emily@edutrack.com', 'roll' => '102', 'scores' => [85, 90, 80, 95, 90]], // Good Performer
            ['name' => 'Marcus Thorne', 'email' => 'marcus@edutrack.com', 'roll' => '103', 'scores' => [65, 70, 60, 75, 65]], // Needs Attention
            ['name' => 'Sofia Blake', 'email' => 'sofia@edutrack.com', 'roll' => '104', 'scores' => [30, 25, 40, 50, 20]], // Critical
        ];

        foreach ($studentsData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password'),
                'role' => 'student',
            ]);

            // Calculate Risk Score using the project logic
            // (Exam*0.35) + (Quiz*0.2) + (Assignment*0.15) + (Attendance*0.15) + (Participation*0.15)
            $exam = $data['scores'][0];
            $quiz = $data['scores'][1];
            $assignment = $data['scores'][2];
            $attendanceVal = $data['scores'][3];
            $participation = $data['scores'][4];
            
            $riskScore = ($exam * 0.35) + ($quiz * 0.20) + ($assignment * 0.15) + ($attendanceVal * 0.15) + ($participation * 0.15);
            
            $level = 'Good Performer';
            if ($riskScore < 40) $level = 'Critical Support Needed';
            elseif ($riskScore < 60) $level = 'Slow Learner';
            elseif ($riskScore < 75) $level = 'Needs Attention';

            $student = Student::create([
                'user_id' => $user->id,
                'edu_class_id' => $classA->id,
                'roll_number' => $data['roll'],
                'risk_score' => $riskScore,
                'risk_level' => $level
            ]);

            // Add Attendance
            Attendance::create(['student_id' => $student->id, 'percentage' => $attendanceVal]);

            // Add Marks for each subject
            foreach ($subjectModels as $subject) {
                Mark::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'marks_obtained' => rand(30, 95),
                    'total_marks' => 100,
                    'exam_type' => 'Mid Term'
                ]);
            }

            // Create a Remedial Plan for Alex (Slow Learner)
            if ($data['name'] == 'Alex Rivera') {
                $plan = RemedialPlan::create([
                    'student_id' => $student->id,
                    'teacher_id' => $teacher->id,
                    'subject' => 'Mathematics',
                    'learning_issue' => 'Difficulty in understanding algebraic functions and quadratic equations.',
                    'preferred_style' => 'Visual Learning',
                    'duration' => '4 Weeks',
                    'generated_plan' => "### Objective\nMaster algebraic foundations.\n\n### Activities\n- Visual mapping of functions\n- Interactive graph plotting",
                    'status' => 'Active'
                ]);

                ProgressRecord::create([
                    'remedial_plan_id' => $plan->id,
                    'student_id' => $student->id,
                    'notes' => 'Significant improvement in identifying variables. Confidence level increased.',
                    'improvement_percentage' => 15
                ]);
            }
        }
    }
}
