<?php

namespace Identicon\Generator;

use Identicon\Generator\GeneratorInterface;

/**
 * @author Grummfy <grummfy@gmail.com>
 */
class BaseImagePngGenerator extends BaseGenerator
{
	public function getMimeType()
	{
		return 'image/png';
	}
}
