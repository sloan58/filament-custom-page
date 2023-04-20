<?php

namespace App\Filament\Pages;

use Closure;
use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Wizard;
use Filament\Notifications\Notification;

class CustomPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.custom-page';

    protected static ?string $title = 'NetMRI Subnets';

    public string $netMriEnvironment = '';

    public string $ipAddress = '';

    public array $ipAddresses = [];

    public bool $ipAddressHasError = false;

    public string $foo;


    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Wizard\Step::make('Select Environment')
                    ->schema([
                        Forms\Components\Section::make('NetMRI Environment')->schema([
                            Forms\Components\Select::make('netMriEnvironment')->options([
                                'blue' => 'BLUE',
                                'green' => 'GREEN'
                            ])->label('')->required(),
                        ]),
                    ]),
                Wizard\Step::make('Add IP Addresses')
                    ->schema([
                        Forms\Components\Section::make('IP Addresses')->schema([
                            Forms\Components\TextInput::make('ipAddress')->label('Separate entries with a space')
                                ->rules([
                                    function () {
                                        return function (string $attribute, $value, Closure $fail) {
                                            if ($this->ipAddressHasError) {
                                                $fail("The {$attribute} is invalid.");
                                            }
                                        };
                                    },
                                ])
                                ->reactive(),
                            Forms\Components\View::make('addIpAddressButton')->view('filament.pages.custom-view')
                        ])
                    ]),
                Wizard\Step::make('Finalize')
                    ->schema([
                        Forms\Components\TextInput::make('foo')
                    ]),
            ])->submitAction(new HtmlString('<button class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700" type="submit">Submit</button>'))
        ];
    }

    public function addIpAddress()
    {
        if(empty($this->ipAddress)) {
            return;
        }

        $ips = explode(' ', $this->ipAddress);

        foreach($ips as $ip) {

            $ipAndSubnet = explode('/', $ip);

            if(!filter_var($ipAndSubnet[0], FILTER_VALIDATE_IP)) {
                Notification::make()
                    ->title('Please supply a valid IP Address')
                    ->danger()
                    ->send();
                $this->ipAddressHasError = true;
                $this->validate();
                return;
            }

            if(count($ipAndSubnet) === 2 and !in_array($ipAndSubnet[1], range(8, 32))) {
                Notification::make()
                    ->title('Please supply a valid Subnet mask')
                    ->danger()
                    ->send();
                $this->ipAddressHasError = true;
                $this->validate();
                return;
            }

            $this->ipAddresses[] = $ip;
        }

        $this->clearValidation();
        $this->ipAddressHasError = false;
        $this->ipAddress = '';
    }

    public function submit(): void
    {
        info('form', [
            $this->form->getState()
        ]);
    }
}
