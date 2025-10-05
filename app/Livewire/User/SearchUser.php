<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
class SearchUser extends Component
{
    public function render()
    {
        $users = User::paginate(5);
        return view('livewire/user/SearchUser', [
            'users' => User::where('username', $this->search)->get(),
        ]);
     //   return view('livewire.user.user');
    }
}
