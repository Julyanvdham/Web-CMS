<?php
	/**
	 * Created by PhpStorm.
	 * User: julyan
	 * Date: 19-10-2017
	 * Time: 20:35
	 */

	namespace System;

	class Colors
	{
		/**
		 * @param string $img
		 * @param int    $count
		 * @param bool   $reduce_brightness
		 * @param bool   $reduce_gradients
		 * @param int    $delta
		 *
		 * @return array|bool
		 */
		public static function GetCommonColors($img, $count = 20, $reduce_brightness = true, $reduce_gradients = true, $delta = 24) {
			if (is_readable($img)) {
				$hexarray = array();
				if ($delta > 2) {
					$half_delta = $delta / 2 - 1;
				} else {
					$half_delta = 0;
				}
				// WE HAVE TO RESIZE THE IMAGE, BECAUSE WE ONLY NEED THE MOST SIGNIFICANT COLORS.
				$size = GetImageSize($img);
				$scale = 1;
				if ($size[0] > 0)
					$scale = min(150 / $size[0], 150 / $size[1]);
				if ($scale < 1) {
					$width = floor($scale * $size[0]);
					$height = floor($scale * $size[1]);
				} else {
					$width = $size[0];
					$height = $size[1];
				}
				$image_resized = imagecreatetruecolor($width, $height);
				if ($size[2] == 1)
					$image_orig = imagecreatefromgif($img);
				if ($size[2] == 2)
					$image_orig = imagecreatefromjpeg($img);
				if ($size[2] == 3)
					$image_orig = imagecreatefrompng($img);
				// WE NEED NEAREST NEIGHBOR RESIZING, BECAUSE IT DOESN'T ALTER THE COLORS
				imagecopyresampled($image_resized, $image_orig, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
				$im = $image_resized;
				$imgWidth = imagesx($im);
				$imgHeight = imagesy($im);
				$total_pixel_count = 0;
				for ($y = 0; $y < $imgHeight; $y++) {
					for ($x = 0; $x < $imgWidth; $x++) {
						$total_pixel_count++;
						$index = imagecolorat($im, $x, $y);
						$colors = imagecolorsforindex($im, $index);
						// ROUND THE COLORS, TO REDUCE THE NUMBER OF DUPLICATE COLORS
						if ($delta > 1) {
							$colors['red'] = intval((($colors['red']) + $half_delta) / $delta) * $delta;
							$colors['green'] = intval((($colors['green']) + $half_delta) / $delta) * $delta;
							$colors['blue'] = intval((($colors['blue']) + $half_delta) / $delta) * $delta;
							if ($colors['red'] >= 256) {
								$colors['red'] = 255;
							}
							if ($colors['green'] >= 256) {
								$colors['green'] = 255;
							}
							if ($colors['blue'] >= 256) {
								$colors['blue'] = 255;
							}

						}

						$hex = substr("0" . dechex($colors['red']), -2) . substr("0" . dechex($colors['green']), -2) . substr("0" . dechex($colors['blue']), -2);

						if (!isset($hexarray[$hex])) {
							$hexarray[$hex] = 1;
						} else {
							$hexarray[$hex]++;
						}
					}
				}

				// Reduce gradient colors
				if ($reduce_gradients) {
					// if you want to *eliminate* gradient variations use:
					// ksort( $hexarray );
					arsort($hexarray, SORT_NUMERIC);

					$gradients = array();
					foreach ($hexarray as $hex => $num) {
						if (!isset($gradients[$hex])) {
							$new_hex = self::_find_adjacent($hex, $gradients, $delta);
							$gradients[$hex] = $new_hex;
						} else {
							$new_hex = $gradients[$hex];
						}

						if ($hex != $new_hex) {
							$hexarray[$hex] = 0;
							$hexarray[$new_hex] += $num;
						}
					}
				}

				// Reduce brightness variations
				if ($reduce_brightness) {
					// if you want to *eliminate* brightness variations use:
					// ksort( $hexarray );
					arsort($hexarray, SORT_NUMERIC);

					$brightness = array();
					foreach ($hexarray as $hex => $num) {
						if (!isset($brightness[$hex])) {
							$new_hex = self::_normalize($hex, $brightness, $delta);
							$brightness[$hex] = $new_hex;
						} else {
							$new_hex = $brightness[$hex];
						}

						if ($hex != $new_hex) {
							$hexarray[$hex] = 0;
							$hexarray[$new_hex] += $num;
						}
					}
				}

				arsort($hexarray, SORT_NUMERIC);

				// convert counts to percentages
				foreach ($hexarray as $key => $value) {
					$hexarray[$key] = (float)$value / $total_pixel_count;
				}

				if ($count > 0) {
					// only works in PHP5
					// return array_slice( $hexarray, 0, $count, true );

					$arr = array();
					foreach ($hexarray as $key => $value) {
						if ($count == 0) {
							break;
						}
						$count--;
						$arr[$key] = $value;
					}

					return $arr;
				} else {
					return $hexarray;
				}

			}

			return false;
		}

		private static function _find_adjacent($hex, $gradients, $delta) {
			$red = hexdec(substr($hex, 0, 2));
			$green = hexdec(substr($hex, 2, 2));
			$blue = hexdec(substr($hex, 4, 2));

			if ($red > $delta) {
				$new_hex = substr("0" . dechex($red - $delta), -2) . substr("0" . dechex($green), -2) . substr("0" . dechex($blue), -2);
				if (isset($gradients[$new_hex])) {
					return $gradients[$new_hex];
				}
			}
			if ($green > $delta) {
				$new_hex = substr("0" . dechex($red), -2) . substr("0" . dechex($green - $delta), -2) . substr("0" . dechex($blue), -2);
				if (isset($gradients[$new_hex])) {
					return $gradients[$new_hex];
				}
			}
			if ($blue > $delta) {
				$new_hex = substr("0" . dechex($red), -2) . substr("0" . dechex($green), -2) . substr("0" . dechex($blue - $delta), -2);
				if (isset($gradients[$new_hex])) {
					return $gradients[$new_hex];
				}
			}

			if ($red < (255 - $delta)) {
				$new_hex = substr("0" . dechex($red + $delta), -2) . substr("0" . dechex($green), -2) . substr("0" . dechex($blue), -2);
				if (isset($gradients[$new_hex])) {
					return $gradients[$new_hex];
				}
			}
			if ($green < (255 - $delta)) {
				$new_hex = substr("0" . dechex($red), -2) . substr("0" . dechex($green + $delta), -2) . substr("0" . dechex($blue), -2);
				if (isset($gradients[$new_hex])) {
					return $gradients[$new_hex];
				}
			}
			if ($blue < (255 - $delta)) {
				$new_hex = substr("0" . dechex($red), -2) . substr("0" . dechex($green), -2) . substr("0" . dechex($blue + $delta), -2);
				if (isset($gradients[$new_hex])) {
					return $gradients[$new_hex];
				}
			}

			return $hex;
		}

		private static function _normalize($hex, $hexarray, $delta) {
			$lowest = 255;
			$highest = 0;
			$colors['red'] = hexdec(substr($hex, 0, 2));
			$colors['green'] = hexdec(substr($hex, 2, 2));
			$colors['blue'] = hexdec(substr($hex, 4, 2));

			if ($colors['red'] < $lowest) {
				$lowest = $colors['red'];
			}
			if ($colors['green'] < $lowest) {
				$lowest = $colors['green'];
			}
			if ($colors['blue'] < $lowest) {
				$lowest = $colors['blue'];
			}

			if ($colors['red'] > $highest) {
				$highest = $colors['red'];
			}
			if ($colors['green'] > $highest) {
				$highest = $colors['green'];
			}
			if ($colors['blue'] > $highest) {
				$highest = $colors['blue'];
			}

			// Do not normalize white, black, or shades of grey unless low delta
			if ($lowest == $highest) {
				if ($delta <= 32) {
					if ($lowest == 0 || $highest >= (255 - $delta)) {
						return $hex;
					}
				} else {
					return $hex;
				}
			}

			for (; $highest < 256; $lowest += $delta, $highest += $delta) {
				$new_hex = substr("0" . dechex($colors['red'] - $lowest), -2) . substr("0" . dechex($colors['green'] - $lowest), -2) . substr("0" . dechex($colors['blue'] - $lowest), -2);

				if (isset($hexarray[$new_hex])) {
					// same color, different brightness - use it instead
					return $new_hex;
				}
			}

			return $hex;
		}

		public static function IsDark($color = "#FFFFFF") {
			$rgb = self::HTMLToRGB($color);
			$hsl = self::RGBToHSL($rgb);

			return $hsl->lightness < 60;
		}

		private static function HTMLToRGB($htmlCode) {
			if ($htmlCode[0] == '#')
				$htmlCode = substr($htmlCode, 1);

			if (strlen($htmlCode) == 3) {
				$htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
			}

			$r = hexdec($htmlCode[0] . $htmlCode[1]);
			$g = hexdec($htmlCode[2] . $htmlCode[3]);
			$b = hexdec($htmlCode[4] . $htmlCode[5]);

			return $b + ($g << 0x8) + ($r << 0x10);
		}

		private static function RGBToHSL($RGB) {
			$r = 0xFF & ($RGB >> 0x10);
			$g = 0xFF & ($RGB >> 0x8);
			$b = 0xFF & $RGB;

			$r = ((float)$r) / 255.0;
			$g = ((float)$g) / 255.0;
			$b = ((float)$b) / 255.0;

			$maxC = max($r, $g, $b);
			$minC = min($r, $g, $b);

			$l = ($maxC + $minC) / 2.0;

			if ($maxC == $minC) {
				$s = 0;
				$h = 0;
			} else {
				if ($l < .5) {
					$s = ($maxC - $minC) / ($maxC + $minC);
				} else {
					$s = ($maxC - $minC) / (2.0 - $maxC - $minC);
				}
				if ($r == $maxC)
					$h = ($g - $b) / ($maxC - $minC);
				if ($g == $maxC)
					$h = 2.0 + ($b - $r) / ($maxC - $minC);
				if ($b == $maxC)
					$h = 4.0 + ($r - $g) / ($maxC - $minC);

				$h = $h / 6.0;
			}

			$h = (int)round(255.0 * $h);
			$s = (int)round(255.0 * $s);
			$l = (int)round(255.0 * $l);

			return (object)Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
		}
	}
