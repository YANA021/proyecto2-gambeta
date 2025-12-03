<?php

namespace App\Livewire;

use App\Models\Cancha;
use App\Models\TipoCancha;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminCrearCancha extends Component
{
    use WithFileUploads;

    public bool $show = false;
    public string $nombre = '';
    public ?int $tipo_id = null;
    public float $precio_hora = 0;
    public bool $disponible = true;
    public $foto;
    public $tipos;

    #[On('openModalCancha')]
    public function open(): void
    {
        $this->resetValidation();
        $this->show = true;
    }

    public function mount(): void
    {
        $this->tipos = TipoCancha::orderBy('nombre')->get();
    }

    public function save(): void
    {
        $data = $this->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo_id' => ['required', 'exists:tipo_canchas,id'],
            'precio_hora' => ['required', 'numeric', 'min:0'],
            'disponible' => ['boolean'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($this->foto) {
            $data['foto'] = $this->foto->store('canchas', 'public');
        }

        Cancha::create($data);

        session()->flash('success', 'Cancha creada correctamente');
        $this->reset(['nombre', 'tipo_id', 'precio_hora', 'disponible', 'foto']);
        $this->show = false;
        $this->dispatch('canchaCreada');
    }

    public function render()
    {
        return view('livewire.admin-crear-cancha');
    }
}
