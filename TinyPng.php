<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\tinypng;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\UnauthorizedHttpException;
use Tinify;

/**
 * TinyPng provides an Yii2 integration of [TinyPng](https://tinypng.com).
 * 
 * With it you can compress PNG and JPG images without loosing image quality. You can also
 * resize images while also compressing the images in the process.
 * 
 * Installation:
 * Run the following command
 * ~~~bash
 * composer require "bigbrush/yii2-tinypng:dev-master"
 * ~~~
 * 
 * Or add this to your composer file
 * ~~~bash
 * "bigbrush/yii2-tinypng": "dev-master"
 * ~~~
 * 
 * Usage:
 * ~~~php
 * $tiny = new TinyPng(['apiKey' => 'YOUR API KEY']);
 * 
 * // compress image - overwrite file
 * $tiny->compress('path/to/file/to/compress');
 * // compress image - create a new image
 * $tiny->compress('path/to/file/to/compress', 'path/to/file/after/compression');
 * 
 * // resize image - overwrite file
 * $tiny->resize('path/to/file/to/resize');
 * // resize image - create a new image
 * $tiny->resize('path/to/file/to/resize', 'path/to/file/after/resizing');
 * ~~~
 * 
 * You can find more information at the [TinyPng docs](https://tinypng.com/developers/reference/php).
 */
class TinyPng extends Component
{
    const VERSION = '0.0.1';

    /**
     * @var string $apiKey the api key to use with [TinyPng](https://tinypng.com).
     */
    public $apiKey;


    /**
     * Initializes the component by validating [[apiKey]].
     *
     * @throws InvalidConfigException if [[apiKey]] is not set.
     * @throws UnauthorizedHttpException if [[apiKey]] could not be validated.
     */
    public function init()
    {
        if (!$this->apiKey) {
            throw new InvalidConfigException("The property 'apiKey' must be in set in " . get_class($this) . ".");
        }
        try {
            Tinify\setKey($this->apiKey);
            Tinify\validate();
        } catch(\Tinify\Exception $e) {
            throw new UnauthorizedHttpException("The specified apiKey '$this->apiKey' could not be validated.");
        }
    }

    /**
     * Compresses the specified image.
     *
     * @param string $src the image source path.
     * @param string $dst the image destination path after being optimized. If not set $src
     * will be overwritten.
     */
    public function compress($src, $dst = null)
    {
        $dst = $dst ?: $src;
        $source = Tinify\fromFile($src);
        $source->toFile($dst);
    }

    /**
     * Resizes and compresses the specified image.
     *
     * @param string $src the image source path.
     * @param string $dst the image destination path after being resized. If not set $src
     * will be overwritten.
     * @param array $options options used when resizing. Options array must be formatted like so:
     * ~~~php
     * [
     *     'method' => 'fit',
     *     'width' => 150,
     *     'height' => 100,
     * ]
     * ~~~
     *
     * Available methods are:
     *     - scale
     *     - fit
     *     - cover
     *
     * See [TinyPng docs](https://tinypng.com/developers/reference/php) for information about each method.
     */
    public function resize($src, $dst, $options)
    {
        $dst = $dst ?: $src;
        $source = Tinify\fromFile($src);
        $resized = $source->resize($options);
        $resized->toFile($dst);
    }

    /**
    * Gets the current number of compressions used this month 
    *
    * See [TinyPng docs](https://tinypng.com/developers/reference/php#compression-count) for more information.
    */

    public function usage()
    {
        return Tinify\compressionCount();
    }
}
