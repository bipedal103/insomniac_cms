<?php

namespace App\Services\Support;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\ResponsiveImages\WidthCalculator\FileSizeOptimizedWidthCalculator;

class FixedWidthCalculator extends FileSizeOptimizedWidthCalculator
{
	public function calculateWidths(int $fileSize, int $width, int $height): Collection
	{
		$breakpoints = setting('responsive_images_breakpoints');

		return empty($breakpoints) ? parent::calculateWidths($fileSize, $width, $height) : collect(preg_split('/\s+/', $breakpoints))->filter(function ($value, $key) use ($width) {
			return $value < $width;
		})->sort();
	}
}
