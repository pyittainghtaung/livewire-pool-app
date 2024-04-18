<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{
    public $title;
    public $options = ['First'];

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'options' => 'required|array|min:1|max:10',
        'options.*' => 'required|min:1|max:255'
    ];

    protected $messages = [
        'options.*' => 'The Option can\'t be empty!'
    ];

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        // Sort array
        $this->options = array_values($this->options);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function createPoll()
    {
        $this->validate();
        // First Style code
        // $poll = Poll::create([
        //     'title' => $this->title
        // ]);

        // foreach ($this->options as $optionName) {
        //     $poll->options()->create(['name' => $optionName]);
        // }

        // Second Style Code. Both styles work same  function
        Poll::create(['title' => $this->title])->options()->createMany(
            collect($this->options)->map(fn ($option) => ['name' => $option])->all()
        );



        $this->reset(['title', 'options']);
        // $this->emit('pollCreated');
        // Replace emit with dispatch in livewire 3
        $this->dispatch('pollCreated');
    }

    // public function mount()
    // {

    // }
}
