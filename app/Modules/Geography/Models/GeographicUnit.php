<?php

namespace App\Modules\Geography\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * A single node in the administrative geography hierarchy.
 *
 * The hierarchy is stored in one self-referencing table:
 *
 *   country > division > district > upazila > union|municipality > ward
 *
 * Municipality and union are siblings under an upazila, and a ward may belong
 * to either a union or a municipality. The internal bigint key is never used
 * as the public reference; `public_id` (UUIDv7) is.
 *
 * @property int $id
 * @property string $public_id
 * @property int|null $parent_id
 * @property string $type
 * @property string|null $code
 * @property string $name_bn
 * @property string $name_en
 * @property string|null $short_name_bn
 * @property string|null $short_name_en
 * @property bool $is_active
 * @property Carbon|null $verified_at
 * @property string|null $source
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read self|null $parent
 * @property-read Collection<int, self> $children
 * @property-read string $display_name
 * @property-read string $short_display_name
 */
#[Fillable([
    'parent_id',
    'type',
    'code',
    'name_bn',
    'name_en',
    'short_name_bn',
    'short_name_en',
    'is_active',
    'verified_at',
    'source',
])]
class GeographicUnit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'geographic_units';

    /**
     * The geographic unit types the hierarchy supports.
     *
     * Mouza is intentionally excluded from Milestone 2. The `geographic_units`
     * table enforces the same list through its `geographic_units_type_check`
     * constraint, so keep this list in sync with the migration.
     *
     * @var list<string>
     */
    public const TYPES = [
        'country',
        'division',
        'district',
        'upazila',
        'union',
        'municipality',
        'ward',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Automatically generate the public UUIDv7 reference on creation.
     */
    protected static function booted(): void
    {
        static::creating(function (self $unit): void {
            if (blank($unit->public_id)) {
                $unit->public_id = (string) Str::uuid7();
            }
        });
    }

    /**
     * The parent unit in the hierarchy, if any.
     *
     * @return BelongsTo<self, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * The direct child units in the hierarchy.
     *
     * @return HasMany<self, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Limit the query to active geographic units.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where($query->qualifyColumn('is_active'), true);
    }

    /**
     * Limit the query to a geographic unit type (or a set of types).
     *
     * @param  Builder<self>  $query
     * @param  string|array<int, string>  $type
     * @return Builder<self>
     */
    public function scopeOfType(Builder $query, string|array $type): Builder
    {
        return $query->whereIn($query->qualifyColumn('type'), (array) $type);
    }

    /**
     * Determine whether the given value is a supported geographic unit type.
     */
    public static function isType(string $type): bool
    {
        return in_array($type, self::TYPES, true);
    }

    /**
     * The localized name: Bangla for `bn`, English otherwise.
     *
     * Falls back to whichever name is present when one of them is missing.
     */
    public function getDisplayNameAttribute(): string
    {
        $locale = (string) app()->getLocale();

        $primary = $locale === 'bn' ? $this->name_bn : $this->name_en;
        $fallback = $locale === 'bn' ? $this->name_en : $this->name_bn;

        return $primary ?: $fallback ?: '';
    }

    /**
     * The localized short name, falling back to the localized full name.
     */
    public function getShortDisplayNameAttribute(): string
    {
        $locale = (string) app()->getLocale();

        $primary = $locale === 'bn' ? $this->short_name_bn : $this->short_name_en;
        $fallback = $locale === 'bn' ? $this->short_name_en : $this->short_name_bn;

        return $primary ?: $fallback ?: $this->display_name;
    }

    /**
     * Get the route key for the model, hiding the internal bigint key.
     */
    public function getRouteKeyName(): string
    {
        return 'public_id';
    }
}
