<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\PostCategory;

use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;
use \Illuminate\Support\Str;

/**
 * @extends ModelResource<PostCategory>
 */
class PostCategoryResource extends ModelResource
{
    protected string $model = PostCategory::class;

    protected string $title = 'PostCategory';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Title', 'name'),
            Date::make('Updated','updated_at')->sortable(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Title', 'name'),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Title', 'name'),
            Date::make('Updated','updated_at'),
            HasMany::make(
                'Post',
                'posts',
                fn($item)=>"$item->name",
                PostResource::class)->afterFill(fn($field)=>$field->setColumn('category_id')),
        ];
    }

    /**
     * @param PostCategory $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
