# NovaSize

Simple image resizing utility for Laravel console.

Only tested with `png`, `jpg`. Not sure what will happen with other formats.


## Install

~~~
composer require "websanova/novasize"
~~~

Add provider to `config/app`.

~~~
'providers' => [
    Websanova\Novasize\Providers\NovasizeProvider::class,
    ...
]
~~~


## Usage

~~~
> php artisan ns:resize size in out
~~~

Where `in` and `out` can either be a set of files or directories.


## ToDo

Maybe implement these flags as well later. If someone requests it.

`[--append]`

* Append to the file name if no out file name is specified.
* Overrides the default to use `resize` as the default append.

`[--prepend]`

* Prepend to the file name if no out file name is specified.
* Overrides the default to use `resize` as the default append.

`[--overwrite]`

* Overwrite the existing files.
* This force flag would be only way to do it.

`[--extension]`

* Change all files to this extension (converts the images).

`[--ignorebestfit]`

* Force ignore of best fit resize.
