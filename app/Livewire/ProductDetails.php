<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Contents\GeneralProductLines;

class ProductDetails extends Component
{
    public ?GeneralProductLines $product = null;
    public int $id;
    public $data;

    protected $listeners = ['receiveData' => 'receive'];

    #[On('receiveData')]
    public function receive($data) {
        Logger('Foo:' . json_encode($data));
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.product-details');
    }
}
