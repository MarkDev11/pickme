<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'birth_date',
        'birth_place',
        'birth_weight',
        'birth_height',
        'birth_type',
        'photo',
        'blood_type',
        'health_notes',
        'allergy_notes',
        'ai_summary',
        'ai_recommendations',
        'summary_last_updated',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'birth_weight' => 'decimal:2',
        'birth_height' => 'decimal:2',
    ];

    /**
     * Get the user (parent) that owns the child
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get growth records for the child
     */
    public function growthRecords()
    {
        return $this->hasMany(GrowthRecord::class)->orderBy('record_date', 'desc');
    }

    /**
     * Get the latest growth record
     */
    public function latestGrowth()
    {
        return $this->hasOne(GrowthRecord::class)->latestOfMany('record_date');
    }

    /**
     * Get age in months
     */
    public function getAgeInMonthsAttribute()
    {
        return $this->birth_date->diffInMonths(now());
    }

    /**
     * Get age in years and months
     */
    public function getAgeTextAttribute()
    {
        $months = $this->age_in_months;
        $years = floor($months / 12);
        $remainingMonths = $months % 12;
        
        if ($years > 0) {
            return $years . ' tahun ' . $remainingMonths . ' bulan';
        }
        return $months . ' bulan';
    }

    /**
     * Check if child is under 5 years old
     */
    public function isUnderFive()
    {
        return $this->age_in_months < 60; // 5 years = 60 months
    }

    /**
     * Get latest growth record (alternative method)
     */
    public function getLatestGrowthAttribute()
    {
        return $this->growthRecords()->first();
    }

    /**
     * Get growth records count
     */
    public function getRecordsCountAttribute()
    {
        return $this->growthRecords()->count();
    }

    /**
     * Get photo URL with fallback
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo && file_exists(public_path($this->photo))) {
            return asset($this->photo);
        }
        return asset('images/default-child.png');
    }

    /**
     * Delete photo file when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($child) {
            // Delete child photo
            if ($child->photo && file_exists(public_path($child->photo))) {
                @unlink(public_path($child->photo));
            }
            
            // Delete all growth record photos
            foreach ($child->growthRecords as $record) {
                if ($record->photo_path && file_exists(public_path($record->photo_path))) {
                    @unlink(public_path($record->photo_path));
                }
            }
        });
    }
}