<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'position',
        'department',
        'image',
        'bio',
        'skills',
        'socials'
    ];

    protected $casts = [
        'skills' => 'array',
        'socials' => 'array'
    ];
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    public function getSocialsAttribute($value)
    {
        return json_decode($value, true);
    }

    // app/Models/Team.php

    // app/Models/Team.php

public function getSkillsAttribute($value)
{
    if (empty($value)) {
        return $this->getDefaultSkills();
    }

    if (is_string($value)) {
        $value = json_decode($value, true);
    }

    // Handle array of objects with 'name' or 'skill' property
    if (is_array($value) && isset($value[0]['name'])) {
        return array_column($value, 'name');
    }
    if (is_array($value) && isset($value[0]['skill'])) {
        return array_column($value, 'skill');
    }

    // Handle array of strings
    if (is_array($value) && is_string($value[0] ?? null)) {
        return $value;
    }

    return $this->getDefaultSkills();
}

protected function getDefaultSkills()
{
    return ['Development', 'Programming']; // Default skills
}
}
