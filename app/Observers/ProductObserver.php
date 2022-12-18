<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\File;

use Illuminate\Support\Facades\Storage;

class ProductObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        // Remove file and file in database
        $this->removeFile($product->files->first());
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }

    private function removeFile($file) {
        if (empty($file)) {
            return;
        }

        // Remove old file
        if (Storage::disk('public')->exists('images/products/'.$file->file_name)) {
            Storage::disk('public')->delete('images/products/'.$file->file_name);
        }

        // Delete file in database
        $file->delete();
    }
}
