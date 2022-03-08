<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUpLoads; //trait
use Livewire\WithPagination;

class CategoriesController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {

       if(strlen($this->search) > 0 )
            $data = Category::where('name', 'like', '%' .$this->search . '%' )->paginate($this->pagination);
        else
            $data = Category::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.category.categories', ['categories' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }


    public function Edit($id){
        $record = Category::find($id, ['id', 'name', 'image']   );
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){

        $rules = [
            'name' => 'required|unique:categories|min:3'

        ];
        $messages = [
            'name.required' => 'Category name is required',
            'name.unique' => 'Category name already exists',
            'name.min' => 'Category name must have at least 3 letters'
        ];

        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name
        ]);

        $customFileName;
        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories/', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();
        $this->emit('category-added', 'Categoría Registrada');



    }

    public function update(){

        $rules = [
            'name' => "required!min:3|unique:categories,name,{$this->selected_id}"
        ];

        $messages = [
            'name.required' => 'Category name is required',
            'name.min' => 'Category name must have at least 3 letters',
            'name.unique' => 'This Category name already exists'

        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name
        ]);

        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories/', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if($imageName != null){
                if(file_exists('storage/categories/' . $imageName)){
                    unlink('storage/categories/' . $imageName);
                }
            }


        }
        $this->resetUI();
        $this->emit('category-updated', 'Categoria Actualizada');





    }





    public function resetUI(){
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;

    }

}
