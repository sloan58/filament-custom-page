<x-filament::page>

    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>

    @if($netMriEnvironment)
        <div class="mt-8">
            <x-filament::card>
                <x-slot name="heading">
                    IP Addresses Added
                </x-slot>
                <x-slot name="actions">
                    <x-filament::button wire:click.prevent="$set('ipAddresses', [])">
                        Clear
                    </x-filament::button>
                </x-slot>
                <ul>
                    @foreach($ipAddresses as $ipAddress)
                        <li>{{ $ipAddress }}</li>
                    @endforeach
                </ul>
            </x-filament::card>
        </div>
    @endif

{{--    {{ json_encode($this) }}--}}

</x-filament::page>
