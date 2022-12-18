<?php

namespace App\Observers;

use App\Models\ProductType;
use App\Models\File;

use Illuminate\Support\Facades\Storage;

class ProductTypeObserver
{
    /**
     * Handle the product type "created" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function created(ProductType $productType)
    {
        //
    }

    /**
     * Handle the product type "updated" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function updated(ProductType $productType)
    {
        //
    }

    /**
     * Handle the product type "deleted" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function deleted(ProductType $productType)
    {
        // Remove file and file in database
        $this->removeFile($productType->files->first());
    }

    /**
     * Handle the product type "restored" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function restored(ProductType $productType)
    {
        //
    }

    /**
     * Handle the product type "force deleted" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function forceDeleted(ProductType $productType)
    {
        //
    }

    private function removeFile($file) {
        if (empty($file)) {
            return;
        }

        // Remove old file
        if (Storage::disk('public')->exists('images/productTypes/'.$file->file_name)) {
            Storage::disk('public')->delete('images/productTypes/'.$file->file_name);
        }

        // Delete file in database
        $file->delete();
    }
}
