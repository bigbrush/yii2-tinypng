TinyPng for Yii 2
===================================

TinyPng provides an Yii2 integration of [TinyPng](https://tinypng.com).

With it you can compress PNG and JPG images without loosing image quality. You can also
resize images while also compressing the images in the process.


Installation <span id="tiny-installation"></span>
-----------------------------------
Run the following command
~~~bash
composer require "bigbrush/yii2-tinypng:dev-master"
~~~

Or add this to your composer file
~~~bash
"bigbrush/yii2-tinypng": "dev-master"
~~~

Usage <span id="tiny-usage"></span>
-----------------------------------
**Image compression/optimizing**
~~~php
$tiny = new TinyPng(['apiKey' => 'YOUR API KEY']);

// compress image - overwrite file
$tiny->compress('path/to/file/to/compress');
// compress image - create a new image
$tiny->compress('path/to/file/to/compress', 'path/to/file/after/compression');
// get current monthly compression count 
$count = $tiny->usage();
~~~

**Image resizing**

Image resizing requires a configuration array to be passed.
~~~php
[
    'method' => 'fit',
    'width' => 150,
    'height' => 100,
]
~~~

Available methods are:
    - scale
    - fit
    - cover

See [TinyPng docs](https://tinypng.com/developers/reference/php#resizing-and-compressing-images) for information about each method.

~~~php
// resize image - overwrite file
$tiny->resize('path/to/file/to/resize', null, ['method' => 'fit', 'width' => 150, 'height' => 100]);
// resize image - create a new image
$tiny->resize('path/to/file/to/resize', 'path/to/file/after/resizing', ['method' => 'fit', 'width' => 150, 'height' => 100]);
~~~
