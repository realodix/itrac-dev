<?php

namespace App\Models;

use App\Enums\TimelineType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User           $author
 * @property Issue          $issue
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Comment extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'author_id',
        'issue_id',
        'type',
        'event_type',
        'description',
    ];

    /*
    |---------------------------------------------------------------------------
    | Eloquent: Relationships
    |---------------------------------------------------------------------------
    */

    /**
     * Get the author that owns the comment.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the issue that owns the issue.
     */
    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    /*
    |---------------------------------------------------------------------------
    | General Functions
    |---------------------------------------------------------------------------
    */

    /**
     * Determine if the type of the comment is a comment.
     */
    public function isComment(): bool
    {
        return $this->type === TimelineType::COMMENT->value;
    }

    /**
     * Determine if the comment was written by the current authenticated user.
     */
    public function isAuthor(): bool
    {
        return $this->author_id === auth()->id();
    }

    /**
     * Determine if the comment was written by the issue author.
     */
    public function isIssueAuthor(): bool
    {
        return $this->author_id === $this->issue->author_id;
    }

    /**
     * Get the role of the comment author.
     */
    public function userRole(): string
    {
        return 'Author';
    }
}
