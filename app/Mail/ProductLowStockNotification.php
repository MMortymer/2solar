<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;

class ProductLowStockNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function build()
    {
        return $this->view('emails.low_stock')
                    ->with([
                        'productName' => $this->product->name,
                        'stock' => $this->product->stock,
                    ])
                    ->subject('Product Low Stock Alert');
    }
}