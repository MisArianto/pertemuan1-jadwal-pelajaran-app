<?php

namespace App\Http\Livewire;

use App\Models\Hari;
use App\Models\JadwalPelajaran;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Welcome extends Component
{
    // state
    public $header;
    public $editMode = false;
    public $inputMode = false;
    public $indexing;

    public $id_jadwal, $hari_id, $pelajaran;

    public function render()
    {
        $haris = Hari::get();
        return view('livewire.welcome', [
            'haris' => $haris
        ]);
    }

    public function rules(){

        return [
            'pelajaran' => 'required',
        ];
    
    }

    public function tambah($hari_id)
    {
        $this->reset();
        $this->hari_id = $hari_id;
        $this->indexing = $hari_id;
        $this->inputMode = true;
    }

    public function close()
    {
        $this->reset();
    }

    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function store()
    {
	    $this->validate();

        try {
            JadwalPelajaran::create([
                'hari_id' => $this->hari_id,
                'pelajaran' => $this->pelajaran
            ]);
	    	$this->reset();
    		$this->emit('success', 'data berhasil di simpan!');
    	} catch (\Exception $e) {
    		$this->emit('error', $e->getMessage());
    	}
    }

    public function edit($id, $hari_id)
    {
    	try {
            $this->reset();
            $this->indexing = $hari_id;
            $this->inputMode = true;
            $model = JadwalPelajaran::findOrFail($id);
            $this->editMode = true;
            $this->id_jadwal = $model->id;
            $this->hari_id = $model->hari_id;
            $this->pelajaran = $model->pelajaran;
            $this->dispatchBrowserEvent('form', ['param' => 'show']);
    		
    	} catch (\Exception $e) {
            $this->emit('error', $e->getMessage());
    	}
    }

    public function update()
    {
        
        $this->validate();
        
        try {
            $model = JadwalPelajaran::findOrFail($this->id_jadwal);
            $model->update([
                'hari_id' => $this->hari_id,
                'pelajaran' => $this->pelajaran
            ]);
            $this->reset();
            $this->emit('success', 'data berhasil di update!');

    	} catch (\Exception $e) {
    		$this->emit('error', $e->getMessage());
    	}
    }
    
    public function destroy($id)
    {
        try {
            $model = JadwalPelajaran::findOrFail($id);
            $model->delete();
    		$this->emit('success', 'data berhasil di hapus!');
    	}catch(\Exception $e) {
    		$this->emit('error', $e->getMessage());
    	}
    }


}
