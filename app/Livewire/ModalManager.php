<?php

namespace App\Livewire;

use Livewire\Component;

class ModalManager extends Component
{
    public $open = false;
    public $titleHeaderText;
    public $enableCloseOnOutsideClick = true;
    public $enableCloseOnEscKeyPressed = true;
    public $modalMaxWidth = 'xl';
    public $promptAlertBeforeClosing = false;
    public $modalPosition = 'center-center';
    public $specialData = [];

    protected $listeners = [
        'open-modal' => 'openModal',
        'close-modal' => 'closeModal',
    ];

    public function mount(
        $titleHeaderText = null,
        $enableCloseOnOutsideClick = true,
        $enableCloseOnEscKeyPressed = true,
        $modalMaxWidth = 'xl',
        $promptAlertBeforeClosing = false,
        $modalPosition = 'center-center'
    ) {
        $this->titleHeaderText = $titleHeaderText;
        $this->enableCloseOnOutsideClick = $enableCloseOnOutsideClick;
        $this->enableCloseOnEscKeyPressed = $enableCloseOnEscKeyPressed;
        $this->modalMaxWidth = $modalMaxWidth;
        $this->promptAlertBeforeClosing = $promptAlertBeforeClosing;
        $this->modalPosition = $modalPosition;
    }

    public function openModal($data = [])
    {
        $this->specialData = $data;
        $this->open = true;
    }

    public function closeModal()
    {
        if ($this->promptAlertBeforeClosing) {
            $this->dispatch('confirm-close');
            return;
        }

        $this->open = false;
        $this->specialData = [];
    }

    public function render()
    {
        return view('livewire.modal-manager');
    }
}
