<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueHistory extends Model
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
        'action',
        'old_value',
        'new_value',
    ];

    /*
    |---------------------------------------------------------------------------
    | Eloquent: Relationships
    |---------------------------------------------------------------------------
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}
