<?php

namespace App\Http\Livewire;

use App\Models\Todo;
use Livewire\Component;

class AddTodos extends Component
{


    protected $listeners = [

        'refreshDetail' => '$refresh'
    ];

    public $item;

    protected $rules = [
        'item' => 'required|min:3'
    ];

    protected $validationAttributes = [
        'item' => 'to-do'
    ];

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function mount() {
        $this->item = '';
    }

    /*
    public function addTodo() {
        $validatedData = $this->validate();
        Todo::create($validatedData);
        $this->reset('item');
        $this->emit('todoAdded');
    }
*/

    public function addTodo()
    {
        $this->validate([
            'item' => 'required',
        ]);

        Todo::updateOrCreate(['id' => $this->id], [
            'item' => $this->item,

        ]);

        $this->reset('item');
        $this->emit('todoAdded');

    }


    public function render() {
        return view('livewire.add-todos');
    }
}
