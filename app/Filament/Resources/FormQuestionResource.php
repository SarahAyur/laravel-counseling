<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormQuestionResource\Pages;
use App\Models\FormQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;

class FormQuestionResource extends Resource
{
    protected static ?string $model = FormQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Forms';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('pertanyaan')
                            ->label('Pertanyaan')
                            ->required(),

                        Select::make('tipe')
                            ->label('Tipe')
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'select' => 'Select',
                                'radio' => 'Radio',
                                'checkbox' => 'Checkbox',
                            ])
                            ->required(),

                        Textarea::make('opsi')
                            ->label('Opsi')
                            ->helperText('Pisahkan opsi dengan koma')
                            ->nullable(),

                        TextInput::make('urutan')
                            ->label('Urutan')
                            ->numeric()
                            ->required(),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pertanyaan')
                    ->label('Pertanyaan')
                    ->sortable()
                    ->searchable()
                    ->limit(40),

                TextColumn::make('tipe')
                    ->label('Tipe')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListFormQuestions::route('/'),
            'create' => Pages\CreateFormQuestion::route('/create'),
            'edit' => Pages\EditFormQuestion::route('/{record}/edit'),
        ];
    }
}