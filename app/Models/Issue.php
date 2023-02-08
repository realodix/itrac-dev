<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property User           $author
 * @property Comment        $comments
 * @property int            $closed_by
 * @property \Carbon\Carbon $closed_at
 * @property int            $locked_by
 * @property \Carbon\Carbon $locked_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Issue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'author_id',
        'title',
        'description',
        'closed_by',
        'closed_at',
        'locked_by',
        'locked_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'closed_at' => 'datetime',
        'locked_at' => 'datetime',
    ];

    /*
    |---------------------------------------------------------------------------
    | Eloquent: Relationships
    |---------------------------------------------------------------------------
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories()
    {
        return $this->hasMany(IssueHistory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function lockedBy()
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    /*
    |---------------------------------------------------------------------------
    | General Functions
    |---------------------------------------------------------------------------
    */

    /**
     * Get the status of the issue.
     */
    public function status(): string
    {
        return $this->isClosed() ? 'Closed' : 'Open';
    }

    /**
     * Get the number of comments.
     */
    public function commentCount(): int
    {
        return $this->comments()->count();
    }

    /**
     * Get the participants of the issue.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Comment>
     */
    public function participant()
    {
        return $this->comments()
            ->select('author_id')
            ->distinct();
    }

    /**
     * Determine if the user is a participant of the issue.
     */
    public function isParticipant(): bool
    {
        return $this->participant()->where('author_id', auth()->id())->exists();
    }

    /**
     * Count the number of participants.
     */
    public function participantCount(): int
    {
        return $this->participant()->count('author_id');
    }

    /**
     * Determine if the issue is authored by the current user.
     */
    public function isAuthor(): bool
    {
        return $this->author_id === auth()->user()->id;
    }

    /**
     * Determine if the issue is closed.
     */
    public function isClosed(): bool
    {
        return $this->closed_by !== null;
    }

    /**
     * Determine if the issue is locked.
     */
    public function isLocked(): bool
    {
        return $this->locked_by !== null;
    }
}
