const del = require('del');
const mix = require('laravel-mix');

require('laravel-mix-imagemin');

const JS_SRC = 'resources/assets/js/app.js';
const JS_DEST = 'public/js';

const CSS_SRC = 'resources/assets/css/app.css';
const CSS_DEST = 'public/css';

const IMG_DEST = 'public/img';

del([JS_DEST, CSS_DEST, IMG_DEST]);

mix
	.js(JS_SRC, JS_DEST)
	.postCss(CSS_SRC, CSS_DEST)
	.imagemin(
		'img/**',
		{ context: 'resources/assets' },
		{
			optipng: {
				optimizationLevel: 7
			},
			gifsicle: {
				optimizationLevel: 3
			}
		}
	)
	.browserSync({ proxy: process.env.MIX_APP_URL });
