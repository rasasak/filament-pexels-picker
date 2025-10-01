<?php

namespace Rasasak\PexelsPicker\Livewire;

use Exception;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Schema;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PexelsPickerComponent extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public string $search = '';

    public int $perPage;

    public bool $useSquareDisplay = true;

    public bool $isMultiple = false;

    public int $numberOfSelectableImages = 1;

    public int $page = 1;

    public ?int $totalPages = null;

    public ?int $totalResults = null;

    public bool $searching = false;

    public string $language;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    TextInput::make('search')
                        //->live(debounce: 300)
                        ->hiddenLabel()
                        ->autocomplete(false)
                        ->autofocus()
                        ->grow()
                        ->afterStateUpdated(fn () => $this->page = 1)
                        ->placeholder(__('pexels-picker::pexels-picker-action.form.fields.search.placeholder'))
                        ->extraAlpineAttributes([
                            'x-model' => 'search',
                            // 'x-on:keydown.enter' => 'if (!["TEXTAREA", "TRIX-EDITOR"].includes($event.target.tagName)) {
                            //     $event.preventDefault()
                            // }',
                        ]),

                    Select::make('language')
                        ->hiddenLabel()
                        ->selectablePlaceholder(false)
                        ->options([
                            'cs-CZ' => 'CZ',
                            'en-US' => 'EN',
                        ])
                        ->grow(false)
                        ->extraAlpineAttributes([
                            'x-model' => 'language',
                        ]),

                    Select::make('perPage')
                        ->hiddenLabel()
                        ->selectablePlaceholder(false)
                        ->options([
                            '20' => '20',
                            '25' => '25',
                            '50' => '50',
                        ])
                        ->grow(false)
                        ->extraAlpineAttributes([
                            'x-model' => 'perPage',
                        ]),

                    Toggle::make('useSquareDisplay')
                        ->label(__('pexels-picker::pexels-picker-action.form.fields.square_mode.label'))
                        ->default(fn () => $this->shouldUseSquareDisplay())
                        ->reactive()
                        ->grow(false),

                    Action::make('doSearch')
                        ->label('Hledat')
                        ->action(fn () => $this->searching = true)
                        ->keyBindings(['enter'])


                ])->extraAttributes(['class' => 'items-center']),
            ]);
    }

    #[Computed]
    public function getImages()
    {
        if (blank($this->search)) {
            return [];
        }

        $response = Http::withHeaders([
                'Authorization' => config('services.pexels.key'),
                'X-Second' => 'bar'
            ])->get('https://api.pexels.com/v1/search', [
            'query' => $this->search,
            'per_page' => $this->getPerPage(),
            'page' => $this->page,
            'locale' => $this->language

        ]);

        throw_if($response->failed(), new Exception(Arr::get($response->json(), 'errors.0')));

        $this->totalResults = Arr::get($response->json(), 'total_results');
        $this->totalPages = ceil($this->totalResults / $this->perPage);
        $this->searching = false;

        return Arr::get($response->json(), 'photos');
    }

    public function nextPageAction(): Action
    {
        return Action::make('nextPage')
            ->button()
            ->color('gray')
            ->label(__('pexels-picker::pexels-picker-action.actions.next_page.label'))
            ->disabled(fn () => $this->totalPages <= 1 || $this->page === $this->totalPages)
            ->action(function () {
                $this->nextPage();
            });
    }

    public function previousPageAction(): Action
    {
        return Action::make('previousPage')
            ->button()
            ->color('gray')
            ->label(__('pexels-picker::pexels-picker-action.actions.previous_page.label'))
            ->disabled(fn () => $this->totalPages <= 1 || $this->page === 1)
            ->action(function () {
                $this->previousPage();
            });
    }

    public function nextPage()
    {
        $this->page++;
    }

    public function previousPage()
    {
        $this->page--;
    }

    #[Computed]
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    #[Computed]
    public function shouldUseSquareDisplay(): bool
    {
        return $this->useSquareDisplay;
    }

    public function render()
    {
        return view('pexels-picker::livewire.pexels-picker-component');
    }
}
