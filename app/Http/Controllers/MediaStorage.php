<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class MediaStorage
{
    const THUMBS_DIR = '/thumbs/';
    const MARKED_REMOVAL_KEY = 'marked_removal';
    const VISIBILITY_KEY = 'visibility';
    const OLD_NAMES_KEY = 'old_names';
    const NEW_NAMES_KEY = 'new_names';
    const FILENAME_GLUE = '-';

    private $disk = null;

    public function __construct($disk = null)
    {
        $disk = $disk ?? setting('media_storage');
        $this->disk = Storage::disk($disk);
    }

    public function handle($media, $pairs = [])
    {
        $this->delete($media);
        $this->changeVisibility($media);
        $this->regenerateThumbs($media);
        $this->rename($media);
        $this->save($media, $pairs);
    }

    private function save($media, $pairs)
    {
        $pairs = (array) $pairs;

        foreach($pairs as $key => $upload_dir)
        {
            if(!isset($media[$key])) continue;

            $thumbs_dir = $upload_dir.self::THUMBS_DIR;
            $files = is_object($media[$key]) ? [$media[$key]] : $media[$key];

            foreach($files as $file)
            {
                if($file->getClientSize() > setting('max_upload_size')) continue;
                $filename = $this->generateFilename($file->getClientOriginalName());

                $this->disk->putFileAs($upload_dir, $file, $filename, setting('media_visibility'));
                if($this->isReadyForThumb($filename)) $this->disk->put($thumbs_dir.$filename, $this->makeThumb($file), setting('media_visibility'));
            }
        }
    }

    private function regenerateThumbs($media)
    {
        $old_names = $media[self::OLD_NAMES_KEY] ?? [];

        foreach($old_names as $old_name)
        {
            if($this->isReadyForThumb($old_name) && $this->disk->exists($old_name)) $this->disk->put($this->getThumb($old_name), $this->makeThumb($this->url($old_name)), setting('media_visibility'));
        }
    }

    private function rename($media)
    {
        $old_names = $media[self::OLD_NAMES_KEY] ?? [];
        $new_names = $media[self::NEW_NAMES_KEY] ?? [];

        foreach($old_names as $key => $old_name)
        {
            $new_name = $this->generateFileName($new_names[$key]);
            if(empty($new_name)) continue;

            $dir = pathinfo($old_name, PATHINFO_DIRNAME);
            $ext = $this->getExt($old_name);
            $new_name = $dir.'/'.$new_name.'.'.$ext;

            if($old_name == $new_name || !$this->disk->exists($old_name) || $this->disk->exists($new_name)) continue;

            $this->disk->move($old_name, $new_name);
            if($this->isReadyForThumb($old_name)) $this->disk->move($this->getThumb($old_name), $this->getThumb($new_name));
        }
    }

    private function changeVisibility($media)
    {
        $old_names = $media[self::OLD_NAMES_KEY] ?? [];
        $visibilities = $media[self::VISIBILITY_KEY] ?? [];

        foreach($old_names as $key => $old_name)
        {
            if(!$this->disk->exists($old_name)) continue;

            $this->disk->setVisibility($old_name, $visibilities[$key]);
            if($this->isReadyForThumb($old_name)) $this->disk->setVisibility($this->getThumb($old_name), $visibilities[$key]);
        }
    }

    private function delete($media)
    {
        $media = $media[self::MARKED_REMOVAL_KEY] ?? [];

        foreach($media as $file)
        {
            if(!$this->disk->exists($file)) continue;

            $this->disk->delete($file);
            if($this->isReadyForThumb($file)) $this->disk->delete($this->getThumb($file));
        }
    }

    public function deleteAllFiles()
    {
        $directories = $this->disk->directories('.');
        foreach($directories as $dir) $this->deleteDir($dir);
    }

    private function generateFileName($filename)
    {
        return preg_replace('/\s+/', self::FILENAME_GLUE, basename(trim($filename)));
    }

    private function makeThumb($file)
    {
        $file = Image::make($file);
        if(!$file) return null;

        $crop_w = $width = $file->width();
        $crop_h = $height = $file->height();
        $tmp_w = $width > $height ? setting('thumb_width_landscape') : setting('thumb_width_portrait');

        if($tmp_w < $width)
        {
            $crop_w = $tmp_w;
            $crop_h = round(($crop_w * $height) / $width);
        }

        return (string) $file->resize($crop_w, $crop_h)->encode();
    }

    public function relocateTo($newDisk, $visibility = null, $delete_old = false)
    {
        $files = $this->allFiles();
        $newDisk = Storage::disk($newDisk);

        foreach($files as $file)
        {
            $check = $newDisk->put($file, $this->disk->get($file), $visibility ?? $this->getVisibility($file));
            if($check && $delete_old) $this->disk->delete($file);
        }
    }

    public function deleteDir($dir)
    {
        return $this->disk->deleteDirectory($dir);
    }

    public function getExt($file)
    {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION));
    }

    public function getDir($file = '.')
    {
        return pathinfo($file, PATHINFO_DIRNAME);
    }

    public function isImage($file)
    {
        return $this->isMime($file, 'image');
    }

    public function isVideo($file)
    {
        return $this->isMime($file, 'video');
    }

    public function isAudio($file)
    {
        return $this->isMime($file, 'audio');
    }

    private function isMime($file, $mime)
    {
        return !(strpos($this->disk->mimeType($file), $mime) === false);
    }

    private function isReadyForThumb($file)
    {
        $extensions = preg_split('/\s+/', strtolower(setting('image_filter')));
        return in_array($this->getExt($file), $extensions);
    }

    public function getThumb($file)
    {
        $name = basename($file);
        $name = str_replace('/'.$name, self::THUMBS_DIR.$name, $file);

        return $this->disk->exists($name) ? $name : $file;
    }

    public function files($dir = '.')
    {
        return $this->disk->files($dir);
    }

    public function allFiles($dir = '.')
    {
        return $this->disk->allFiles($dir);
    }

    public function size($file)
    {
        return $this->disk->size($file);
    }

    public function url($file)
    {
        return $this->disk->url($file);
    }

    public function getVisibility($file)
    {
        return $this->disk->getVisibility($file);
    }

    public function lastModified($file)
    {
        return Carbon::createFromTimestamp($this->disk->lastModified($file))->setTimezone('UTC');
    }
}