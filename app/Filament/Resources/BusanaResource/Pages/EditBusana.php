<?php

namespace App\Filament\Resources\BusanaResource\Pages;

use App\Filament\Resources\BusanaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;


class EditBusana extends EditRecord
{
    protected static string $resource = BusanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
{
    return $form
        ->schema([
            // Input untuk nama busana
            Forms\Components\TextInput::make('nama')
                ->label('Nama Busana')
                ->required()
                ->maxLength(255)
                ->default(fn ($record) => $record->nama), // Menampilkan data nama busana yang sudah ada

            // Input untuk deskripsi busana
            Forms\Components\Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->default(fn ($record) => $record->deskripsi), // Menampilkan deskripsi yang sudah ada

            // Input untuk harga sewa busana
            Forms\Components\TextInput::make('harga_sewa')
                ->label('Harga Sewa')
                ->required()
                ->default(fn ($record) => $record->harga_sewa), // Menampilkan harga sewa yang sudah ada

            // Input untuk stok busana
            Forms\Components\TextInput::make('stok')
                ->label('Stok')
                ->required()
                ->default(fn ($record) => $record->stok), // Menampilkan stok yang sudah ada

            // Input untuk gambar busana
            FileUpload::make('gambar')
                ->label('Gambar')
                ->image()
                ->default(fn ($record) => $record->gambar) // Menampilkan gambar yang sudah ada
                ->directory('uploads/images') // Menentukan direktori penyimpanan gambar
                ->visibility('public'), // Menentukan visibilitas gambar
        ]);
}
}
