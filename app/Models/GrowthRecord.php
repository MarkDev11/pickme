<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrowthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'user_id',
        'record_date',
        'age_months',
        'ai_estimated_weight',
        'ai_estimated_height',
        'actual_weight',
        'actual_height',
        'head_circumference',
        'photo_path',
        'ai_analysis',
        'growth_status',
        'recommendations',
        'nutrition_advice',
        'milestone_check',
        'weight_for_age_zscore',
        'height_for_age_zscore',
        'weight_for_height_zscore',
        'parent_notes',
    ];

    protected $casts = [
        'record_date' => 'date',
        'ai_estimated_weight' => 'decimal:2',
        'ai_estimated_height' => 'decimal:2',
        'actual_weight' => 'decimal:2',
        'actual_height' => 'decimal:2',
        'head_circumference' => 'decimal:1',
        'nutrition_advice' => 'array',
        'milestone_check' => 'array',
        'weight_for_age_zscore' => 'decimal:2',
        'height_for_age_zscore' => 'decimal:2',
        'weight_for_height_zscore' => 'decimal:2',
    ];

    /**
     * Get the child that owns the record
     */
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    /**
     * Get the user (parent) that owns the record
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get photo URL
     */
    public function getPhotoUrlAttribute()
    {
        return asset($this->photo_path);
    }

    /**
     * Get the previous growth record (cached per instance)
     */
    protected function getPreviousRecord()
    {
        if (!isset($this->previousRecordCache)) {
            $this->previousRecordCache = self::where('child_id', $this->child_id)
                ->where('record_date', '<', $this->record_date)
                ->orderBy('record_date', 'desc')
                ->first();
        }
        return $this->previousRecordCache;
    }

    /**
     * Get weight difference from previous record
     */
    public function getWeightDifferenceAttribute()
    {
        $previous = $this->getPreviousRecord();

        if (!$previous) {
            return null;
        }

        return round($this->actual_weight - $previous->actual_weight, 2);
    }

    /**
     * Get height difference from previous record
     */
    public function getHeightDifferenceAttribute()
    {
        $previous = $this->getPreviousRecord();

        if (!$previous) {
            return null;
        }

        return round($this->actual_height - $previous->actual_height, 2);
    }

    /**
     * Get growth status color for UI
     */
    public function getStatusColorAttribute()
    {
        $status = strtolower($this->growth_status ?? '');

        if (str_contains($status, 'normal') || str_contains($status, 'bagus') || str_contains($status, 'sehat')) {
            return 'green';
        }

        if (str_contains($status, 'perlu perhatian') || str_contains($status, 'risiko')) {
            return 'yellow';
        }

        if (str_contains($status, 'stunting') || str_contains($status, 'gizi buruk') || str_contains($status, 'obesitas')) {
            return 'red';
        }

        return 'blue';
    }

    /**
     * Check if measurements were edited by parent
     */
    public function wasEditedByParent()
    {
        if (!$this->ai_estimated_weight || !$this->ai_estimated_height) {
            return false;
        }

        $weightDiff = abs($this->actual_weight - $this->ai_estimated_weight);
        $heightDiff = abs($this->actual_height - $this->ai_estimated_height);

        return $weightDiff > 0.1 || $heightDiff > 0.5;
    }

    /**
     * Get formatted growth comparison
     */
    public function getGrowthComparisonAttribute()
    {
        $weightDiff = $this->weight_difference;
        $heightDiff = $this->height_difference;

        if (!$weightDiff && !$heightDiff) {
            return 'Ini adalah data pertama';
        }

        $result = [];

        if ($weightDiff) {
            $result[] = ($weightDiff > 0 ? '+' : '') . $weightDiff . ' kg';
        }

        if ($heightDiff) {
            $result[] = ($heightDiff > 0 ? '+' : '') . $heightDiff . ' cm';
        }

        return implode(' • ', $result);
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-delete photo when record is deleted
        static::deleting(function ($record) {
            if ($record->photo_path && file_exists(public_path($record->photo_path))) {
                @unlink(public_path($record->photo_path));
            }
        });
    }
}