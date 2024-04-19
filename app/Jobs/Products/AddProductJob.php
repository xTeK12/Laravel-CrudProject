<?php

namespace App\Jobs\Products;

use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use http\Env\Request;
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
     * @param Request $request
     * @param int $userId
     * @param string $path
     */
    public function __construct(protected array $request, protected int $userId, protected string $path)
    {
        $this->queue = 'products';
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $category = Category::where('name',$this->request['category'])->first();
        $product = new Product();
        $product->fill($this->request);
        $product->ownerID = $this->userId;
        $product->category_id = $category->id;
        $product->save();

        $newMedia = new Media();
        $newMedia->path = $this->path;
        $newMedia->product_id = $product->id;
        $newMedia->save();
    }
}
