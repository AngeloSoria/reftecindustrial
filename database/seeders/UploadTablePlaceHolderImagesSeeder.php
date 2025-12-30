<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Upload;

class UploadTablePlaceHolderImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = [
            [
                'name' => 'johannes-plenio-RwHv7LgeC7s-unsplash.jpg',
                'path' => '/images/landscape/johannes-plenio-RwHv7LgeC7s-unsplash.jpg'
            ],
            [
                'name' => 'leonard-cotte-c1Jp-fo53U8-unsplash.jpg',
                'path' => '/images/landscape/leonard-cotte-c1Jp-fo53U8-unsplash.jpg'
            ],
            [
                'name' => 'matthew-smith-Rfflri94rs8-unsplash.jpg',
                'path' => '/images/landscape/matthew-smith-Rfflri94rs8-unsplash.jpg'
            ],
            [
                'name' => 'qingbao-meng-01_igFr7hd4-unsplash.jpg',
                'path' => '/images/landscape/qingbao-meng-01_igFr7hd4-unsplash.jpg'
            ],
            [
                'name' => 'quaritsch-photography-lIYBssO6ahY-unsplash.jpg',
                'path' => '/images/landscape/quaritsch-photography-lIYBssO6ahY-unsplash.jpg'
            ],
            [
                'name' => 'sergey-shmidt-koy6FlCCy5s-unsplash.jpg',
                'path' => '/images/landscape/sergey-shmidt-koy6FlCCy5s-unsplash.jpg'
            ],
        ];

        foreach($files as $file => $data) {
            Upload::create([
                'filename' => $data['name'],
                'type' => 'image/jpeg',
                'path' => $data['path'],
                'is_protected' => true,
                'uploaded_by' => 1
            ]);
        }
    }
}
