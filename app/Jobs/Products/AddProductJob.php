<?php

namespace App\Jobs\Products;

use App\Models\Media;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AddProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    private $userId, $path, $request;
    public function __construct($request, $userId, $path)
    {
        $this->userId = $userId;
        $this->request = $request;
        $this->path = $path;
        $this->queue = 'products';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product = new Product();
        $product->fill($this->request);
        $product->ownerID = $this->userId;
        $product->save();

        $newMedia = new Media();
        $newMedia->path = $this->path;
        $newMedia->product_id = $product->id;
        $newMedia->save();
    }
}
