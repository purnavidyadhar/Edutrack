<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\EduClass;
use App\Models\Subject;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\TeacherFeedback;
use App\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminToolsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic dependencies
        $this->adminUser = User::factory()->create(['role' => 'admin']);
        $this->teacherUser = User::factory()->create(['role' => 'teacher']);
        $this->teacher = Teacher::create(['user_id' => $this->teacherUser->id]);
        
        $this->eduClass = EduClass::create(['name' => 'Grade 10-A', 'department' => 'Science']);
        $this->studentUser = User::factory()->create(['role' => 'student']);
        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'edu_class_id' => $this->eduClass->id,
            'roll_number' => 'S101',
            'risk_score' => 50,
            'risk_level' => 'Slow Learner',
        ]);

        $this->subject = Subject::create(['name' => 'Mathematics']);
    }

    public function test_admin_can_access_tools_panel(): void
    {
        $response = $this
            ->actingAs($this->adminUser)
            ->get('/admin/tools');

        $response->assertOk();
    }

    public function test_admin_can_override_student_marks(): void
    {
        $response = $this
            ->actingAs($this->adminUser)
            ->post('/admin/tools/update-marks', [
                'student_id' => $this->student->id,
                'subject_id' => $this->subject->id,
                'exam_type' => 'Mid Term',
                'marks_obtained' => 95,
                'total_marks' => 100,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('marks', [
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
            'marks_obtained' => 95,
            'exam_type' => 'Mid Term',
        ]);

        // Verify risk score was recalculated automatically
        $this->student->refresh();
        $this->assertTrue($this->student->risk_score > 50);
    }

    public function test_admin_can_override_student_attendance(): void
    {
        $response = $this
            ->actingAs($this->adminUser)
            ->post('/admin/tools/update-attendance', [
                'student_id' => $this->student->id,
                'percentage' => 98.5,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'percentage' => 98.5,
        ]);

        // Verify risk score was recalculated automatically
        $this->student->refresh();
        $this->assertEquals(25.2, $this->student->risk_score);
    }

    public function test_admin_can_broadcast_announcements(): void
    {
        $response = $this
            ->actingAs($this->adminUser)
            ->post('/admin/tools/announcement', [
                'title' => 'Emergency Holiday',
                'message' => 'School is closed tomorrow due to heavy rain.',
                'audience' => 'all',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('announcements', [
            'title' => 'Emergency Holiday',
            'message' => 'School is closed tomorrow due to heavy rain.',
            'audience' => 'all',
        ]);
    }

    public function test_admin_can_update_teacher_feedback(): void
    {
        $feedback = TeacherFeedback::create([
            'student_id' => $this->student->id,
            'teacher_id' => $this->teacher->id,
            'title' => 'Original Title',
            'feedback' => 'Original feedback text.',
            'type' => 'encouragement',
            'rating' => 4,
        ]);

        $response = $this
            ->actingAs($this->adminUser)
            ->post("/admin/tools/feedback/{$feedback->id}/update", [
                'title' => 'Updated Title',
                'feedback' => 'Updated feedback text.',
                'type' => 'achievement',
                'rating' => 5,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('teacher_feedbacks', [
            'id' => $feedback->id,
            'title' => 'Updated Title',
            'feedback' => 'Updated feedback text.',
            'type' => 'achievement',
            'rating' => 5,
        ]);
    }

    public function test_admin_can_delete_teacher_feedback(): void
    {
        $feedback = TeacherFeedback::create([
            'student_id' => $this->student->id,
            'teacher_id' => $this->teacher->id,
            'title' => 'Title',
            'feedback' => 'Feedback text.',
            'type' => 'encouragement',
        ]);

        $response = $this
            ->actingAs($this->adminUser)
            ->delete("/admin/tools/feedback/{$feedback->id}");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('teacher_feedbacks', [
            'id' => $feedback->id,
        ]);
    }
}
