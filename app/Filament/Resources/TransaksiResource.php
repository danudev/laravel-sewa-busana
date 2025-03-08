<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Transaksi;
use App\Models\Busana;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\BadgeColumn;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('admin');
    }

    // Form untuk input data Transaksi
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('busana_id') // Menggunakan ID busana untuk relasi
                    ->label('Nama Busana')
                    ->relationship('busana', 'nama') // Mengambil nama busana dari relasi
                    ->required(),
                TextInput::make('durasi')->required()->label('Durasi (Hari)'),
                TextInput::make('total_harga')->required()->label('Total Harga'),
                TextInput::make('denda')->label('Denda')->default(0), // Menambahkan input denda
                Select::make('status')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'selesai' => 'Selesai',
                    ])
                    ->required(),
                DatePicker::make('tanggal_mulai')->required()->label('Tanggal Mulai'),
                DatePicker::make('tanggal_selesai')->required()->label('Tanggal Selesai'),
                DatePicker::make('tanggal_pengembalian')->label('Tanggal Pengembalian'),
            ]);
    }

    // Tabel untuk menampilkan daftar Transaksi
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->sortable()->searchable(),
                TextColumn::make('busana.nama')->sortable()->searchable(),
                TextColumn::make('durasi')->sortable(),
                TextColumn::make('total_harga')
                    ->sortable()
                    ->money('IDR'), // Menggunakan format mata uang langsung di kolom
                TextColumn::make('denda')
                    ->sortable()
                    ->money('IDR'), // Format uang untuk kolom denda
                    TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'selesai' => 'success',
                        'dipinjam' => 'danger',
                    }), // Menampilkan status dengan badge
                TextColumn::make('tanggal_mulai')->date(), // Format tanggal default
                TextColumn::make('tanggal_selesai')->date(), // Format tanggal default
                TextColumn::make('tanggal_pengembalian')->date(), // Format tanggal disamakan
            ])
            ->filters([/* Filter lainnya jika perlu */])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Menambahkan tombol kustom "Selesai"
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Transaksi $record) {
                        // Mengubah status transaksi menjadi 'selesai'
                        $record->update([
                            'status' => 'selesai',
                            'tanggal_pengembalian' => now(), // Menandakan barang sudah dikembalikan
                        ]);

                        // Menghitung denda berdasarkan keterlambatan
                        $tanggal_selesai = Carbon::parse($record->tanggal_selesai)->startOfDay(); // Pastikan hanya tanggal yang dihitung
                        $tanggal_pengembalian = Carbon::parse($record->tanggal_pengembalian)->startOfDay(); // Pastikan hanya tanggal yang dihitung

                        // Denda per hari keterlambatan
                        $denda_per_hari = 100000;
                        $denda = 0;

                        // Jika keterlambatan (tanggal pengembalian > tanggal selesai)
                        if ($tanggal_pengembalian > $tanggal_selesai) {
                            // Menghitung selisih hari keterlambatan
                            $keterlambatan = $tanggal_selesai->diffInDays($tanggal_pengembalian);

                            // Menghitung total denda
                            $denda = $keterlambatan * $denda_per_hari;
                        }

                        // Memperbarui nilai denda pada transaksi
                        $record->update([
                            'denda' => $denda,
                        ]);

                        // Menambahkan stok barang (Busana) 1 unit
                        $busana = $record->busana; // Mengambil objek busana yang berelasi
                        $busana->increment('stok', 1); // Menambah 1 ke kolom stok

                        // Mengupdate total harga dengan menambahkan denda ke total harga
                        $total_harga_baru = $record->total_harga + $denda;
                        $record->update([
                            'total_harga' => $total_harga_baru,
                        ]);
                    })
                    ->visible(fn (Transaksi $record): bool => $record->status === 'dipinjam'), // Menampilkan tombol hanya jika statusnya 'dipinjam'
            ]);
    }

    // Relasi model jika ada relasi lain, misalnya ke model Busana
    public static function getRelations(): array
    {
        return [
            // Misalnya, jika Transaksi berelasi dengan model Busana:
            // RelationManagers\BusanaRelationManager::class,
        ];
    }

    // Halaman untuk CRUD Transaksi
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
