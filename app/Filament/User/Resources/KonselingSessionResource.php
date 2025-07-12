<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\KonselingSessionResource\Pages;
use App\Models\KonselingSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KonselingSessionResource extends Resource
{
    protected static ?string $model = KonselingSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('konselor_id')
                            ->label('Konselor')
                            ->relationship('konselor', 'name')
                            ->required()
                            ->options(fn () => \App\Models\User::where('role', 'konselor')->pluck('name', 'id'))
                            ->rules(['required', 'exists:users,id']),
    
                        DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->required()
                            ->rules(['required', 'date']),
                        
                            Select::make('sesi_id')
                            ->label('Sesi')
                            ->relationship('session', 'name')
                            ->required()
                            ->options(fn () => \App\Models\Session::pluck('name', 'id')),
                        
                        TextInput::make('topik')
                            ->label('Topik')
                            ->required(),

                            TextInput::make('status')
                            ->label('Status')
                            ->default('pending') // Set default value ke 'pending'
                            ->disabled(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('konselor.name')->label('Konselor'),
                TextColumn::make('tanggal')->label('Tanggal'),
                TextColumn::make('session.start_time')
                ->label('Jam Mulai')
                ->dateTime('H:i'), // Format waktu
                TextColumn::make('session.end_time')
                ->label('Jam Selesai')
                ->dateTime('H:i'), // Format waktu                TextColumn::make('status')->label('Status'),
                TextColumn::make('topik')->label('Topik'),
                TextColumn::make('status')->label('status'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('isiJawaban')
                ->label('isi Form')
                ->icon('heroicon-o-document-text')
                ->url(fn ($record) => route('form-answers.create', ['sesi_id' => $record->id]))
                ->visible(fn ($record) => $record->status === 'approved'), // Tombol hanya muncul jika status 'approved'
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKonselingSessions::route('/'),
            'create' => Pages\CreateKonselingSession::route('/create'),
            'edit' => pages\EditKonselingSession::route('/{record}/edit'),
        ];
    }
}