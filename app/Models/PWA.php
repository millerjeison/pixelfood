<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PWA extends Model implements HasMedia
{
    use HasFactory;

    use InteractsWithMedia;

    protected $fillable = ['id'];
    protected $table = "pwa";

    public function getSplashAttribute(): string
    {
        if (!empty($this->getFirstMediaUrl('pwa_splash'))) {
            $pwa = $this->getMedia('pwa_splash')->first();
            return $pwa->getUrl('D_2048x2732');
        }
        return asset('images/icons/splash-2048x2732.png');
    }

    public function getIconAttribute(): string
    {
        if (!empty($this->getFirstMediaUrl('pwa_icon'))) {
            $pwa = $this->getMedia('pwa_icon')->first();
            return $pwa->getUrl('D_512x512');
        }
        return asset('images/icons/icon-512x512.png');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('D_2048x2732')->performOnCollections('pwa_splash')
             ->crop('crop-center', 2048, 2732)->keepOriginalImageFormat()->sharpen(10);
        $this->addMediaConversion('D_1668x2388')->performOnCollections('pwa_splash')
             ->crop('crop-center', 1668, 2388)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_1668x2224')->performOnCollections('pwa_splash')
             ->crop('crop-center', 1668, 2224)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_1536x2048')->performOnCollections('pwa_splash')
             ->crop('crop-center', 1536, 2048)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_1242x2688')->performOnCollections('pwa_splash')
             ->crop('crop-center', 1242, 2688)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_1242x2208')->performOnCollections('pwa_splash')
             ->crop('crop-center', 1242, 2208)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_1125x2436')->performOnCollections('pwa_splash')
             ->crop('crop-center', 1125, 2436)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_828x1792')->performOnCollections('pwa_splash')
             ->crop('crop-center', 828, 1792)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_750x1334')->performOnCollections('pwa_splash')
             ->crop('crop-center', 750, 1334)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_640x1136')->performOnCollections('pwa_splash')
             ->crop('crop-center', 640, 1136)->keepOriginalImageFormat()->sharpen(10);

        $this->addMediaConversion('D_512x512')->performOnCollections('pwa_icon')
             ->crop('crop-center', 512, 512)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_384x384')->performOnCollections('pwa_icon')
             ->crop('crop-center', 384, 384)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_192x192')->performOnCollections('pwa_icon')
             ->crop('crop-center', 192, 192)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_152x152')->performOnCollections('pwa_icon')
             ->crop('crop-center', 152, 152)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_144x144')->performOnCollections('pwa_icon')
             ->crop('crop-center', 144, 144)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_128x128')->performOnCollections('pwa_icon')
             ->crop('crop-center', 128, 128)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_96x96')->performOnCollections('pwa_icon')
             ->crop('crop-center', 96, 96)->keepOriginalImageFormat()->sharpen(10);
             $this->addMediaConversion('D_72x72')->performOnCollections('pwa_icon')
             ->crop('crop-center', 72, 72)->keepOriginalImageFormat()->sharpen(10);
     }

}