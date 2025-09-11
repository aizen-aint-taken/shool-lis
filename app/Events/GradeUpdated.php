<?php

namespace App\Events;

use App\Models\Grade;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GradeUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $grade;
    public $student;
    public $subject;
    public $teacher;

    /**
     * Create a new event instance.
     */
    public function __construct(Grade $grade)
    {
        $this->grade = $grade;
        $this->student = $grade->student;
        $this->subject = $grade->subject;
        $this->teacher = $grade->teacher;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('grades.' . $this->grade->school_class_id),
            new Channel('grades.admin'),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'grade_id' => $this->grade->id,
            'student_id' => $this->grade->student_id,
            'student_name' => $this->student->first_name . ' ' . $this->student->last_name,
            'subject_id' => $this->grade->subject_id,
            'subject_name' => $this->subject->name,
            'grading_period' => $this->grade->grading_period,
            'score' => $this->grade->score,
            'final_rating' => $this->grade->final_rating,
            'remarks' => $this->grade->remarks,
            'teacher_name' => $this->teacher->name,
            'school_class_id' => $this->grade->school_class_id,
            'academic_year' => $this->grade->academic_year,
            'updated_at' => $this->grade->updated_at->toISOString(),
        ];
    }

    /**
     * Get the broadcast event name.
     */
    public function broadcastAs(): string
    {
        return 'grade.updated';
    }
}