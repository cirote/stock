<?php

namespace Cirote\Crud\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Cirote\Crud\Models\Template;

class CrudForm extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'  => 'required|max:100',
            'email' => 'required|max:200'
        ];
    }

    public function persist(Template $template)
    {

        $template->name     = $this->name;
        $template->email    = $this->email;

        if ($this->password)
            $template->password = bcrypt($this->password);

        $template->save();
    }
}