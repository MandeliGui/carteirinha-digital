<?php

namespace App\Http\Requests\Pets;

use App\Http\Requests\BaseValidationRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class AlterarFotoPetRequest extends BaseValidationRequest
{
    public function __construct(private array $data, array $attributes = [])
    {
        parent::__construct($attributes);

        $this->prepareForValidation();
    }

    public function prepareForValidation(): void
    {
        $this->data = [
            'id' => data_get($this->data, 'id'),
            'foto' => data_get($this->data, 'foto'),
        ];
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer'],
            'foto' => ['required', File::image()],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'image' => 'O campo :attribute deve ser uma imagem válida.',
        ];
    }

    /**
     * @return array{id: int, foto: UploadedFile}
     */
    public function validated(): array
    {
        /** @var array{id: int, foto: UploadedFile} $validated */
        $validated = Validator::make($this->data, $this->rules(), $this->messages(), $this->attributes())->validated();

        return $validated;
    }
}
