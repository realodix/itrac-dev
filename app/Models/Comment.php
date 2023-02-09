<?php

namespace App\Models;

use App\Enums\TimelineType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property User           $author
 * @property Issue          $issue
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'author_id',
        'issue_id',
        'type',
        'description',
    ];

    /*
    |---------------------------------------------------------------------------
    | Eloquent: Relationships
    |---------------------------------------------------------------------------
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issue()
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
        return $this->type === TimelineType::Comment->value;
    }

    /**
     * Determine if the type of the comment is a status update.
     */
    public function isStatus(): bool
    {
        return $this->type === TimelineType::Event->value;
    }

    /**
     * Determine if the comment was written by the current user.
     */
    public function isAuthor(): bool
    {
        return $this->author_id === auth()->user()->id;
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
