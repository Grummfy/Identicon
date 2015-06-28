<?php

namespace Identicon\Generator;

use Identicon\Generator\GeneratorInterface;

/**
 * @author Benjamin Laugueux <benjamin@yzalis.com>
 */
class SvgGenerator extends BaseGenerator implements GeneratorInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getMimeType()
	{
		return 'image/svg+xml';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getImageBinaryData($string, $size = null, $color = null, $backgroundColor = null)
	{
		return $this->getImageResource($string, $size, $color, $backgroundColor);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getImageResource($string, $size = null, $color = null, $backgroundColor = null)
	{
		$this
			->setString($string)
			->setSize($size)
			->setColor($color)
			->setBackgroundColor($backgroundColor)
			->_generateImage();

		return $this->generatedImage;
	}

	protected function _generateImage()
	{
		// prepare image
		$w = $this->getPixelRatio() * 5;
		$h = $this->getPixelRatio() * 5;
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="'. $w .'" height="'. $h .'">';

		$backgroundColor = '#FFFFFF';
		$rgbBackgroundColor = $this->getBackgroundColor();
		if (!is_null($rgbBackgroundColor))
		{
			$backgroundColor = $this->_toUnderstandableColor($rgbBackgroundColor);
		}
		$svg .= '<rect width="'. $w .'" height="'. $h .'" style="fill:'. $backgroundColor .';stroke-width:1;stroke:' . $backgroundColor .'"/>';


		$rgbColor = $this->_toUnderstandableColor($this->getColor());
		// draw content
		foreach ($this->getArrayOfSquare() as $lineKey => $lineValue)
		{
			foreach ($lineValue as $colKey => $colValue)
			{
				if (true === $colValue)
				{
					$svg .= '<rect x="'. $colKey * $this->getPixelRatio() .'" y="'. $lineKey * $this->getPixelRatio() .'" width="'.($this->getPixelRatio()) .'" height="'. $this->getPixelRatio() .'" style="fill:'. $rgbColor .';stroke-width:0;"/>';

				}
			}
		}

		$svg .= '</svg>';

		$this->generatedImage = $svg;

		return $this;
	}

	/**
	 * @param array|string $color
	 * @return string
	 */
	protected function _toUnderstandableColor($color)
	{
		if (is_array($color))
		{
			return 'rgb(' . implode(', ', $color) . ')';
		}
		return $color;
	}
}
