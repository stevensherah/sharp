<?php

namespace App\Sharp;

use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentTransformer;
use Code16\Sharp\Form\Fields\SharpFormAutocompleteField;
use Code16\Sharp\Form\Fields\SharpFormDateField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\SharpForm;

class SpaceshipSharpForm extends SharpForm
{
//    use WithSharpEloquentUpdater;

    use WithSharpFormEloquentTransformer;

    function buildFormFields()
    {
        $this->addField(
            SharpFormTextField::make("name")
                ->setLabel("Name")
        );

        $this->addField(
            SharpFormTextField::make("capacity")
                ->setLabel("Capacity (thousands)")
        );

        $this->addField(
            SharpFormDateField::make("construction_date")
                ->setLabel("Construction date")
                ->setHasTime(false)
        );

        $this->addField(
            SharpFormAutocompleteField::make("type_id", "local")
                ->setLabel("Ship type")
                ->setListItemTemplatePath("/sharp/templates/spaceshipType_list")
                ->setResultItemTemplatePath("/sharp/templates/spaceshipType_result")
                ->setLocalValues(
                    SpaceshipType::orderBy("label")->get()->pluck("label", "id")
                )
        );
    }

    function buildFormLayout()
    {
        $this->addColumn(6)
            ->withSingleField("name")
            ->withSingleField("type_id")
            ->withFieldset("Technical details", function($fieldset) {
                return $fieldset->withFields("capacity|4,6", "construction_date|8,6");
            });
    }

    function find($id): array
    {
        return $this->setCustomTransformer("capacity", function($spaceship) {
            return $spaceship->capacity / 1000;

        })->transform(
            Spaceship::findOrFail($id)
        );
    }

    function update($id, array $data): bool
    {
        return true;
    }

    function store(array $data): bool
    {
        return true;
    }

    function delete($id): bool
    {
        return true;
    }
}