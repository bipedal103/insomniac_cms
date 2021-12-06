<?php

namespace App\Services\Csp\Policies;

use Spatie\Csp\Scheme;
use Spatie\Csp\Keyword;
use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Policy as BasePolicy;

class Policy extends BasePolicy
{
	public function configure(): void
	{
		$scripts = (array) preg_split('/\s+/', setting('csp_allowed_scripts', ''));
		$styles = (array) preg_split('/\s+/', setting('csp_allowed_styles', ''));

		$this->addDirective(Directive::BASE, Keyword::SELF)
			->addDirective(Directive::CONNECT, Keyword::SELF)
			->addDirective(Directive::FORM_ACTION, Keyword::SELF)
			->addDirective(Directive::OBJECT, Keyword::NONE)
			->addDirective(Directive::FRAME, [Keyword::SELF, 'google.com'])
			->addDirective(Directive::FONT, [Keyword::SELF, Scheme::DATA, 'fonts.gstatic.com'])
			->addDirective(Directive::SCRIPT, [Keyword::SELF, Keyword::UNSAFE_INLINE, Keyword::UNSAFE_EVAL, ...$scripts])
			->addDirective(Directive::STYLE, [Keyword::SELF, Keyword::UNSAFE_INLINE, ...$styles]);
	}
}
