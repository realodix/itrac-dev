<?php

namespace App\Models;

use App\Enums\TimelineType;
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
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /*
    |---------------------------------------------------------------------------
    | General Functions
    |---------------------------------------------------------------------------
    */

    /**
     * Get the number of comments of the specified issue.
     */
    public function commentCount(): int
    {
        $type = TimelineType::COMMENT->value;

        return $this->comments->where('type', $type)->count();
    }

    /**
     * Get the participants list of the issue. The participants are the users who
     * have commented on the issue.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Comment>
     */
    public function participants()
    {
        return $this->comments()
            ->select('author_id')
            ->where('type', TimelineType::COMMENT->value)
            ->distinct();
    }

    /**
     * Determine if the user is a participant of the issue.
     */
    public function isParticipant(): bool
    {
        return $this->participants()->where('author_id', auth()->id())->exists();
    }

    /**
     * Count the number of participants of the issue.
     */
    public function participantCount(): int
    {
        return $this->participants()->count('author_id');
    }

    /**
     * Determine if the issue is authored by the current authenticated user.
     *
     * Covered by unit test, but actually is not yet tested by PHPUnit.
     */
    public function isAuthor(): bool
    {
        return $this->author_id === auth()->id();
    }

    /**
     * Determine if the status of the issue is closed.
     */
    public function isClosed(): bool
    {
        return $this->closed_by !== null;
    }

    /**
     * Determine if the conversation of the issue is locked.
     */
    public function isLocked(): bool
    {
        return $this->locked_by !== null;
    }
}
