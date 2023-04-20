<div class="col-span-1">
    <div class="filament-forms-field-wrapper">
        <div class="space-y-2">
            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                <div class="flex-1">
                    <button wire:click.prevent="addIpAddress" class="@if(empty($this->ipAddress)) bg-primary-200 @else bg-primary-600 @endif filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
