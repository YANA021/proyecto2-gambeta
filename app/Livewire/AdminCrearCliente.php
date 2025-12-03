<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Grupo;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminCrearCliente extends Component
{
    public bool $show = false;
    public string $nombre = '';
    public string $telefono = '';
    public ?int $grupo_id = null;
    public $grupos;

    #[On('openModalCliente')]
    public function open(): void
    {
        $this->resetValidation();
        $this->show = true;
    }

    public function mount(): void
    {
        $this->grupos = Grupo::orderBy('nombre')->get();
    }

    public function save(): void
    {
        $data = $this->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:30', 'regex:/^[0-9+()\\s-]{7,}$/'],
            'grupo_id' => ['nullable', 'exists:grupos,id'],
        ]);

        Cliente::create($data);

        session()->flash('success', 'Cliente creado correctamente');
        $this->reset(['nombre', 'telefono', 'grupo_id']);
        $this->show = false;
        $this->dispatch('clienteCreado');
    }

    public function render()
    {
        return view('livewire.admin-crear-cliente');
    }
}
