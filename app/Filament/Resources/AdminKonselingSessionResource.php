<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminKonselingSessionResource\Pages;
use App\Models\KonselingSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;

class AdminKonselingSessionResource extends Resource
{
    protected static ?string $model = KonselingSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Konseling';
    protected static ?string $navigationLabel = 'Daftar Konseling';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('mahasiswa.name')
                        ->label('Mahasiswa')
                        ->disabled(),

                    TextInput::make('konselor.name')
                        ->label('Konselor')
                        ->disabled(),

                        DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->disabled(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),

                        Textarea::make('catatan_konselor')
                            ->label('Catatan Konselor')
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mahasiswa.name')->label('Mahasiswa')->sortable()->searchable(),
                TextColumn::make('konselor.name')->label('Konselor')->sortable()->searchable(),
                TextColumn::make('tanggal')->label('Tanggal')->sortable(),
                TextColumn::make('status')->label('Status')->sortable(),
                TextColumn::make('topik')->label('Topik')->limit(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminKonselingSessions::route('/'),
            'create' => Pages\CreateAdminKonselingSession::route('/create'),
            'edit' => Pages\EditAdminKonselingSession::route('/{record}/edit'),
        ];
    }
}