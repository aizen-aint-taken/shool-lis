<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function advisedClasses(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'adviser_id');
    }

    public function encodedGrades(): HasMany
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }

    public function encodedAttendance(): HasMany
    {
        return $this->hasMany(Attendance::class, 'adviser_id');
    }

    public function student()
    {
        // Log this relationship access for debugging
        \Log::info('Accessing student relationship', [
            'user_id' => $this->id,
            'username' => $this->username,
            'lrn_column' => 'lrn',
            'username_column' => 'username'
        ]);
        
        $relationship = $this->hasOne(Student::class, 'lrn', 'username');
        
        // Log the SQL query that would be generated
        \Log::info('Student relationship query', [
            'sql' => $relationship->toSql(),
            'bindings' => $relationship->getBindings()
        ]);
        
        return $relationship;
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAdviser(): bool
    {
        return $this->role === 'adviser';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}