<?php

namespace App\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public bool $open = false;
    public ?string $view = null;
    public array $data = [];

    public string $test;

    protected $listeners = ['openModal' => 'open', 'closeModal' => 'close'];

    public function open(string $view, Array $data = [])
    {
        $this->view = $view;
        $this->data = $data;
        $this->open = true;
    }

    public function close()
    {
        $this->reset(['open', 'view', 'data']);
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
