<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Geography Foundation: self-referencing administrative units.
 *
 * This migration creates the scalar and relational schema only. Spatial
 * columns (geometry/geography, centroid) and their GiST indexes are
 * intentionally deferred to the spatial migration in Milestone 2.3.3.
 */
return new class extends Migration
{
    /**
     * The PostgreSQL types the geography hierarchy supports.
     *
     * Mouza is deliberately excluded from Milestone 2 until the authoritative
     * requirements and hierarchy are established.
     *
     * @var list<string>
     */
    private const ALLOWED_TYPES = [
        'country',
        'division',
        'district',
        'upazila',
        'union',
        'municipality',
        'ward',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('geographic_units', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique('geographic_units_public_id_unique');
            $table->bigInteger('parent_id')->nullable();
            $table->string('type', 24);
            $table->string('code', 32)->nullable();
            $table->string('name_bn', 160);
            $table->string('name_en', 160);
            $table->string('short_name_bn', 80)->nullable();
            $table->string('short_name_en', 80)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestampTz('verified_at', 6)->nullable();
            $table->string('source', 255)->nullable();
            $table->timestampTz('created_at', 6);
            $table->timestampTz('updated_at', 6);

            // Never cascade-delete geographic reference records.
            $table->foreign('parent_id', 'geographic_units_parent_id_foreign')
                ->references('id')
                ->on('geographic_units')
                ->restrictOnDelete();

            $table->index(
                ['parent_id', 'type', 'is_active'],
                'geographic_units_parent_id_type_is_active_index'
            );

            $table->unique(['code'], 'geographic_units_code_unique');
        });

        // A unit may never be its own parent.
        DB::statement(
            'alter table "geographic_units" add constraint "geographic_units_parent_id_not_self_check" '
            .'check ("parent_id" is null or "parent_id" <> "id")'
        );

        // Sibling uniqueness. NULLS NOT DISTINCT (PostgreSQL 15+) makes the
        // rule apply to root-level units whose parent_id is NULL, so only one
        // active "country" row named "Bangladesh" can exist.
        $allowedTypes = implode(', ', array_map(
            fn (string $type): string => $this->quote($type),
            self::ALLOWED_TYPES
        ));

        DB::statement(
            'alter table "geographic_units" add constraint "geographic_units_type_check" '
            ."check (\"type\" in ({$allowedTypes}))"
        );

        DB::statement(
            'create unique index "geographic_units_parent_type_name_en_active_unique" '
            .'on "geographic_units" ("parent_id", "type", "name_en") nulls not distinct '
            .'where "is_active"'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geographic_units');
    }

    /**
     * Quote a string literal for use in DDL statements in this migration.
     */
    private function quote(string $value): string
    {
        return "'".str_replace("'", "''", $value)."'";
    }
};
