<?php

namespace App\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public bool $open = false;
    public ?string $view = null;
    public array $data = [];
    public array $modalConfig = [];

    // DOM Variables
    public $modalHeaderText;
    public $size;

    protected $listeners = ['modal-open' => 'open', 'modal-close' => 'close'];


    public function open(string $view, $data = [], $modalConfig = [])
    {
        $this->view = $view;
        $this->data = $data;
        $this->open = true;

        // Apply modal config if provided
        if (!empty($modalConfig)) {
            foreach ($modalConfig as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    public function resetModal()
    {
        $this->reset(['view', 'data', 'modalConfig']);
    }

    public function close()
    {
        $this->reset(['open', 'view', 'data', 'modalConfig']);
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
