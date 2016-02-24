<?php

namespace Websanova\Novasize\Console;

use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;

class Novasize extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'ns:resize {size?} {in?} {out?}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Image resizing utility.';

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        $in   = $this->argument('in');
        $out  = $this->argument('out');
        $size = $this->argument('size');
        $dim  = explode('x', $this->argument('size'));

        if ( ! (ctype_digit($size[0]) && ctype_digit($size[1]))) {
            $this->line("\nInvalid size argument [ex: ng:resize 200x200 in.png out.png]\n");
            exit;
        }

        if ($in === $out) {
            $this->line("\nThe directory in and out path can not be the same.\n");
            exit;
        }

        if ( ! is_file($in) && ! is_dir($in)) {
            $this->line("\nInvalid in file or directory argument [ex: ng:resize 200x200 in.png out.png]\n");
            exit;
        }

        Image::configure(array('driver' => 'imagick'));

        if (is_file($in)) {
            $pathinfo = pathinfo($in);

            if ($out === null) {
                $out = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-' . $size . '.' . $pathinfo['extension'];
            }

            $img = $this->resize($in, $dim[0], $dim[1], $out);

            $this->line("\nResizing " . $in . " => " . $out . "\n");

            exit;
        }

        if (is_dir($in)) {
            $out = rtrim($out, '/');
            $out = rtrim($out, '\\');

            if ( ! is_dir($out)) {
                mkdir($out);
            }

            $files = glob($in . '/*.{jpg,png}', GLOB_BRACE);

            $this->line("");

            foreach ($files as $file) {
                $pathinfo = pathinfo($file);

                $img = $this->resize($file, $dim[0], $dim[1], $out . '/' . $pathinfo['basename']);

                $this->line("Resizing " . $file . " => " . $out . '/' . $pathinfo['basename']);
            }

            $this->line("");

            exit;
        }
    }

    private function resize($in, $w, $h, $out)
    {
        $img = Image::make($in)->resize($w, $h, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save($out, 100);

        return $img;
    }
}
