<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyAnalysis extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'body_analyses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'image_path',
        'estimated_height',
        'estimated_weight',
        'estimated_age',
        'full_analysis',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'estimated_height' => 'integer',
        'estimated_weight' => 'integer',
        'estimated_age' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get BMI (Body Mass Index) calculated from height and weight
     *
     * @return float
     */
    public function getBmiAttribute(): float
    {
        $heightInMeters = $this->estimated_height / 100;
        
        if ($heightInMeters <= 0) {
            return 0;
        }
        
        return round($this->estimated_weight / ($heightInMeters * $heightInMeters), 1);
    }

    /**
     * Get BMI category
     *
     * @return string
     */
    public function getBmiCategoryAttribute(): string
    {
        $bmi = $this->bmi;
        
        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi < 25) {
            return 'Normal';
        } elseif ($bmi < 30) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }

    /**
     * Get BMI color for UI
     *
     * @return string
     */
    public function getBmiColorAttribute(): string
    {
        $bmi = $this->bmi;
        
        if ($bmi < 18.5) {
            return 'blue';
        } elseif ($bmi < 25) {
            return 'green';
        } elseif ($bmi < 30) {
            return 'yellow';
        } else {
            return 'red';
        }
    }

    /**
     * Get full image URL
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return asset($this->image_path);
    }

    /**
     * Scope a query to only include recent analyses
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope a query to filter by height range
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $min
     * @param  int  $max
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHeightBetween($query, $min, $max)
    {
        return $query->whereBetween('estimated_height', [$min, $max]);
    }

    /**
     * Scope a query to filter by weight range
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $min
     * @param  int  $max
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWeightBetween($query, $min, $max)
    {
        return $query->whereBetween('estimated_weight', [$min, $max]);
    }

    /**
     * Get the user that owns the analysis
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to filter by age range
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $min
     * @param  int  $max
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAgeBetween($query, $min, $max)
    {
        return $query->whereBetween('estimated_age', [$min, $max]);
    }
}