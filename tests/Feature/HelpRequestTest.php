<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\EduClass;
use App\Models\RemedialPlan;
use App\Models\HelpRequest;
use App\Models\ProgressRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up basic class
        $this->eduClass = EduClass::create(['name' => 'Grade 10-A', 'department' => 'Science']);
    }

    public function test_student_can_submit_help_request(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $user->id,
            'edu_class_id' => $this->eduClass->id,
            'roll_number' => 'S101',
            'risk_score' => 50,
            'risk_level' => 'Slow Learner',
        ]);

        $response = $this
            ->actingAs($user)
            ->post('/student/help-request', [
                'subject' => 'Mathematics',
                'message' => 'I cannot solve quadratic formulas.',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('help_requests', [
            'student_id' => $student->id,
            'subject' => 'Mathematics',
            'message' => 'I cannot solve quadratic formulas.',
            'status' => 'pending',
        ]);
    }

    public function test_student_can_submit_confidence_rating(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'edu_class_id' => $this->eduClass->id,
            'roll_number' => 'S101',
            'risk_score' => 50,
            'risk_level' => 'Slow Learner',
        ]);

        $teacherUser = User::factory()->create(['role' => 'teacher']);
        $teacher = Teacher::create(['user_id' => $teacherUser->id]);

        $plan = RemedialPlan::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'subject' => 'Mathematics',
            'learning_issue' => 'Algebra issue',
            'preferred_style' => 'Visual',
            'duration' => '4 Weeks',
            'status' => 'Active',
        ]);

        $response = $this
            ->actingAs($studentUser)
            ->post("/plans/{$plan->id}/confidence", [
                'confidence' => 'confident',
                'message' => 'Feels much better now.',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('progress_records', [
            'remedial_plan_id' => $plan->id,
            'student_id' => $student->id,
            'improvement_percentage' => 10,
        ]);
    }

    public function test_teacher_can_resolve_help_request(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'edu_class_id' => $this->eduClass->id,
            'roll_number' => 'S101',
            'risk_score' => 50,
            'risk_level' => 'Slow Learner',
        ]);

        $teacherUser = User::factory()->create(['role' => 'teacher']);
        $teacher = Teacher::create(['user_id' => $teacherUser->id]);

        $helpRequest = HelpRequest::create([
            'student_id' => $student->id,
            'subject' => 'Mathematics',
            'message' => 'Help me please.',
            'status' => 'pending',
        ]);

        $response = $this
            ->actingAs($teacherUser)
            ->post("/teacher/help-request/{$helpRequest->id}/resolve");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('help_requests', [
            'id' => $helpRequest->id,
            'status' => 'resolved',
        ]);
    }

    public function test_teacher_can_generate_remedial_plan(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'edu_class_id' => $this->eduClass->id,
            'roll_number' => 'S101',
            'risk_score' => 50,
            'risk_level' => 'Slow Learner',
        ]);

        $teacherUser = User::factory()->create(['role' => 'teacher']);
        $teacher = Teacher::create(['user_id' => $teacherUser->id]);

        $response = $this
            ->actingAs($teacherUser)
            ->post('/plans', [
                'student_id' => $student->id,
                'subject' => 'Mathematics',
                'learning_issue' => 'Algebra issues',
                'preferred_style' => 'Visual Learning',
                'duration' => '4 Weeks',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('remedial_plans', [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'subject' => 'Mathematics',
            'learning_issue' => 'Algebra issues',
            'preferred_style' => 'Visual Learning',
            'duration' => '4 Weeks',
            'status' => 'Active',
        ]);
    }
}
