<?php

namespace App\Traits;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTranslation
{
	public function getTranslation(string $column, string $locale, $default = null): ?string
	{
		return $this->translations->where('column', $column)->where('locale', $locale)->first()?->value ?? $default;
	}

	public function translations(): MorphMany
	{
		return $this->morphMany(Translation::class, 'item');
	}

	public function updateTranslations(array $columns = []): self
	{
		foreach ($columns as $column => $locales) {
			foreach ($locales as $locale => $value) {
				$this->translations()->updateOrCreate([
					'column' => $column,
					'locale' => $locale,
				], [
					'value' => $value,
				]);
			}
		}

		return $this;
	}

	protected static function bootHasTranslation(): void
	{
		static::deleting(function ($model) {
			$model->translations->each(function ($item) {
				$item->delete();
			});
		});
	}
}
