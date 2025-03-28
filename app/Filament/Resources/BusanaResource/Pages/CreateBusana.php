<?php

namespace App\Filament\Resources\BusanaResource\Pages;

use App\Filament\Resources\BusanaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;


class CreateBusana extends CreateRecord
{
    protected static string $resource = BusanaResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')->required()->maxLength(255),
                Forms\Components\Textarea::make('deskripsi'),
                Forms\Components\TextInput::make('harga_sewa')
                ->numeric()
                ->required(),
                Forms\Components\TextInput::make('stok')
                ->numeric()
                ->required(),
                FileUpload::make('gambar')
                ->image()
                ->required() // Menandakan bahwa field ini wajib diisi
                ->disk('public') // Menentukan disk untuk penyimpanan, misalnya 'public'
                ->directory('images') // Menentukan folder tempat gambar disimpan, misalnya 'images'
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/jpg']) // Opsional, membatasi jenis file yang diterima
                ->maxSize(1024) // Opsional, membatasi ukuran file maksimal (dalam kilobytes)
                ->columnSpan(2), // Opsional, menentukan lebar kolom yang digunakan
            ]);
    }
}
