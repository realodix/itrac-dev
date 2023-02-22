<?php

namespace App\Models;

use App\Enums\CommentType;
use App\Enums\EventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property User           $author
 * @property Comment        $comments
 * @property bool           $is_closed
 * @property bool           $is_locked
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Issue extends Model implements Auditable
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
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
        'is_closed' => 'boolean',
        'is_locked' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_closed' => false,
        'is_locked' => false,
    ];

    /*
    |---------------------------------------------------------------------------
    | Eloquent: Relationships
    |---------------------------------------------------------------------------
    */

    /**
     * Get the comments for the issue.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the author that owns the issue.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /*
    |---------------------------------------------------------------------------
    | General Functions
    |---------------------------------------------------------------------------
    */

    /**
     * Responsible user locks conversation in an issue
     */
    public function lockedBy(): string
    {
        return $this->comments()
            ->where('type', TimelineType::EVENT->value)
            ->where('event_type', EventType::LOCKED->value)
            ->latest()->first()
            ->author->name;
    }

    /**
     * Get the number of comments of the issue.
     *
     * @return int
     */
    public function commentCount()
    {
        $type = CommentType::Comment->value;

        return $this->comments->where('type', $type)->count();
    }

    /**
     * Get the participants list of the issue. The participants are the users who
     * have commented on the issue.
     *
     * @return HasMany<Comment>
     */
    public function participants(): HasMany
    {
        return $this->comments()
            ->select('author_id')
            ->where('type', CommentType::Comment->value)
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
        return $this->is_closed === true;
    }

    /**
     * Determine if the conversation of the issue is locked.
     */
    public function isLocked(): bool
    {
        return $this->is_locked === true;
    }

    /*
    |---------------------------------------------------------------------------
    | Laravel Audits
    |---------------------------------------------------------------------------
    */

    /**
     * If the is_locked column is modified, pass the is_locked tag
     * If the is_closed column is modified, pass the is_closed tag
     */
    public function generateTags(): array
    {
        $tags = [];

        if ($this->isDirty('is_closed')) {
            $tags[] = 'is_closed';
        } elseif ($this->isDirty('is_locked')) {
            $tags[] = 'is_locked';
        }

        return $tags;
    }
}
