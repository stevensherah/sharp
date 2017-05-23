<?php

namespace Code16\Sharp\Tests\Unit\Form\Eloquent\Relationships;

use Code16\Sharp\Form\Eloquent\Relationships\UpdateBelongsToRelation;
use Code16\Sharp\Tests\Fixtures\Person;
use Code16\Sharp\Tests\Unit\Form\Eloquent\SharpFormEloquentBaseTest;

class UpdateBelongsToRelationTest extends SharpFormEloquentBaseTest
{

    /** @test */
    function we_can_update_a_belongsTo_relation()
    {
        $mother = Person::create(["name" => "Jane Wayne"]);
        $person = Person::create(["name" => "John Wayne"]);

        $updater = new UpdateBelongsToRelation();

        $updater->update($person, "mother", $mother->id);

        $this->assertDatabaseHas("people", [
            "id" => $person->id,
            "mother_id" => $mother->id
        ]);
    }
}