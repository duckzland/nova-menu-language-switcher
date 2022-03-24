<?php

namespace Duckzland\NovaMenuLanguageSwitcher;


use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;


class MenuLanguageSwitcher extends Field
{

    public $component = 'language-menu-switcher-nova';


    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

    }



    public function fill(NovaRequest $request, $model)
    {
        return;
    }



    protected function resolveAttribute($resource, $attribute)
    {
        $locales_source = config('app.locales');
        $model = get_class($resource);
        $parent = empty($resource->locale_parent_id)
            ? $resource->id
            : $resource->locale_parent_id;

        $children = $model::where(function ($query) use ($parent, $resource) {
                return $query
                    ->where('locale_parent_id', $parent)
                    ->orWhere('id', $parent);
            })
            ->where('id', '!=', $resource->id)
            ->get();
    

        $locales = [];

        foreach ($locales_source as $locale => $label) {
            if ($locale === $resource->locale) {
                $locales[$locale] = [
                    'id' => $resource->id,
                    'label' => $label,
                    'parent' => $resource->locale_parent_id 	
                ];
            } 
            
            else {
                $existing = $children->first(function ($c) use ($locale) {
                    return $c->locale === $locale;
                });

                $locales[$locale] = [
                    'id' => ($existing !== null) ? $existing->id : null,
                    'label' => $label
                ];
            }
        }

        return [
            'id' => $resource->id,
            'active' => $resource->locale,
            'parent' => $parent,
            'locales' => $locales,
            'fallback' => config('app.fallback_locale', 'en_US'),
        ];
    }



    public function setPlaceholder(string $placeholder)
    {
        return $this->withMeta([ 'placeholder' => $placeholder ]);
    }

}
