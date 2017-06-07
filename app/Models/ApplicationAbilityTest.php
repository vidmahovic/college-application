<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationAbilityTest extends Model // PIVOT MED TESTOM SPOSOBNOSTI IN PRIJAVNICO
{
    protected $table = 'applications_ability_test';
    protected $fillable = ['points', 'application_id', 'ability_test_id'];
    protected $guarded = ['id'];

    public function abilityTest(){
        return $this->belongsTo(AbilityTest::class, 'ability_test_id');
    }

    public function application(){
        return $this->belongsTo(Application::class, 'application_id');
    }
}
