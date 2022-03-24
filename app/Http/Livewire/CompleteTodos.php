<?php

namespace App\Http\Livewire;

use App\Models\Todo;
use Livewire\Component;

class CompleteTodos extends Component
{
    public $todos;
    public $editedTodoIndex = null;
    public $editedTodoField = null;

    protected $listeners = ['todoCompleted',
        'refreshDetail' => '$refresh'];


    protected $rules = [
        'todos.*.item' => 'required|min:3'
    ];

    protected $validationAttributes = [
        'todos.*.item' => 'to-do',
    ];

    public function mount() {
        $this->todos = Todo::where('completed', 1)->latest()->get();
    }

    public function editTodo($todoIndex) {

        $this->editedTodoIndex = $todoIndex;

    }


    public function editTodoField($todoIndex, $fieldName) {

        $stringTodoIndex = implode(',',$todoIndex);
        $this->editedTodoField = $stringTodoIndex . "." .$fieldName;
        }



    public function saveTodo($todoIndex) {
        $this->validate();
        $todo = $this->todos($todoIndex) ?? NULL;
        if(!is_Null($todo)) {
            optional(Todo::find($todo('id')))->update($todo);
        }
        $this->editedTodoField = null;
        $this->editedTodoIndex = null;
    }



    public function incompleteTodo($id) {
        optional(Todo::find($id['id']))->update(['completed' => 0]);
        $this->todos = Todo::where('completed', 1)->latest()->get();
        $this->emit('todoIncompleted');

    }



    public function todoCompleted() {
        $this->todos = Todo::where('completed', 1)->latest()->get();
    }



    public function deleteTodo($id) {

//        $todo = $this->todos[$todoIndex];


        $todo =Todo::where('id',$id)->first();
        $todo->forcedelete();
        $this->emit('refreshDetail');

       // $this->todos = Todo::where('completed', 1)->latest()->get();

    }



    public function render() {
        return view('livewire.complete-todos', [
            'todos' => $this->todos,
        ]);
    }



}
