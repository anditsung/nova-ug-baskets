<?php

namespace Anditsung\NovaUgBaskets\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\PerformsValidation;

class BasketController extends Controller
{
    use PerformsValidation;

    private function plantSelection()
    {
        return array(
            "A" => "A",
            "B" => "B",
            "C" => "C",
            "D" => "D",
            "E" => "E"
        );
    }

    public function fields(NovaRequest $request)
    {
        return  [
            Boolean::make('Barcode'),

            Select::make('Plant')
                ->options($this->plantSelection())
                ->rules('required'),

            Number::make('Start'),

            Number::make('End'),

            Number::make('Copy'),
        ];


    }

    private function validateGenerate(NovaRequest $request)
    {
        $rules = collect($this->fields($request))->mapWithKeys(function($field) {
            $rules = implode(',', $field->rules);
            return [$field->attribute => $rules];
        })->toArray();

        Validator::make($request->all(), $rules)->validate();
    }

    private function generateData(NovaRequest $request)
    {
        $data = collect($this->fields($request))->mapWithKeys(function($field) use ($request) {
            return [$field->attribute => $request->get($field->attribute)];
        })->toArray();

        return base64_encode(json_encode($data));
    }

    public function generate(NovaRequest $request)
    {
        $this->validateGenerate($request);

        return $this->generateData($request);
    }

    public function basketLabel($data)
    {
        return view('nova-ug-baskets::label', compact('data'));
    }
}
