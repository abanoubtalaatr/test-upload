<?php

namespace App\Uploader\Domain\Models;

use App\Course\Domain\Models\CourseAccommodation;
use App\Infrastructure\Helpers\Traits\UploaderHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory, UploaderHelper;

    protected $fillable = ['name', 'type', 'attachable_type', 'attachable_id', 'folder', 'description', 'is_visible_for_school'];

    protected $casts = [
        'is_visible_for_school' => 'boolean'
    ];

    /**
     * Get all of the schools that are assigned this attachment.
     */
    public function schools()
    {
        return $this->morphedByMany('App\School\Domain\Models\School', 'attachable_type', 'attachable_id');
    }

        /**
     * Get all of the course accommodations that are assigned this attachment.
     */
    public function courseAccommodation()
    {
        return $this->morphTo('App\Course\Domain\Models\CourseAccommodation', 'attachable_type', 'attachable_id');
    }

        /**
     * Get all of the course requests that are assigned this attachment.
     */
    public function courseRequests()
    {
        return $this->morphTo('App\Course\Domain\Models\CourseRequest', 'attachable_type', 'attachable_id');
    }

    /**
     * Get the parent attachable model like (school).
     */
    public function attachable()
    {
        return $this->morphTo();
    }

    /**
     * Get the attachable creator model like (admin).
     */
    public function creatable()
    {
        return $this->morphTo();
    }

    public function getFullPathAttribute()
    {
        $fullPath = $this->getFileFullPath($this->name, $this->folder);

        return $fullPath;
    }
}
