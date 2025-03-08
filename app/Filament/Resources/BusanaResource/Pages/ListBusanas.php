<?php

namespace App\Filament\Resources\BusanaResource\Pages;

use App\Filament\Resources\BusanaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;


class ListBusanas extends ListRecords
{
    protected static string $resource = BusanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('deskripsi')
                ->label('Deskripsi')
                ->formatStateUsing(function ($state) {
                    // Menggunakan teks yang dipotong dengan ellipsis jika terlalu panjang
                    return '<span style="display: inline-block; width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . e($state) . '">' . e($state) . '</span>';
                })
                ->html(),
                Tables\Columns\TextColumn::make('harga_sewa'),
                ImageColumn::make('gambar'),
                Tables\Columns\TextColumn::make('stok')
            ->label('Stok')
            ->formatStateUsing(function ($state) {
                // Mengecek jumlah stok dan menampilkan status beserta jumlah stok
                if ($state > 1) {
                    return $state . ' Tersedia';
                } elseif ($state == 0) {
                    return 'Habis';
                } else {
                    return $state . ' tersedia';  // Menampilkan jumlah stok jika kurang dari 1
                }
            }),
            ])->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
