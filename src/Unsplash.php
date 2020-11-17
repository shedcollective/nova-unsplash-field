<?php

namespace Shed\Unsplash;

use Laravel\Nova\Fields\Field;

class Unsplash extends Field
{
    /**
     * @var string
     */
    public $queryPlaceholder = 'Search Unsplash for photos';

    /**
     * @var string
     */
    public $orientation = '';

    /**
     * @var bool
     */
    public $featured = true;

    /**
     * @var string
     */
    public $previewSize = 'small';

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'unsplash';

    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        if (!config('services.unsplash.key')) {
            throw new \Exception("Please specify the Unsplash api key at services.unsplash.key config.");
        }

        $this->withMeta([
            'unsplashKey' => config('services.unsplash.key'),
            'queryPlaceholder' => $this->queryPlaceholder,
            'orientation' => $this->orientation,
            'featured' => $this->featured,
            'previewSize' => $this->previewSize
        ]);
    }
}
