<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>

    @php
        $containers = $getChildComponentContainers();

        $isCollapsible = $isCollapsible();
        $isItemCreationDisabled = $isItemCreationDisabled();
        $isItemDeletionDisabled = $isItemDeletionDisabled();
        $isItemMovementDisabled = $isItemMovementDisabled();

        $columnLabels = $getColumnLabels();
        $colStyles = $getColStyles();

    @endphp

    <div
        {{-- x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }"  --}}
        x-data="{ isCollapsed: @js($isCollapsed()) }"
        x-on:repeater-collapse.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = true)"
        x-on:repeater-expand.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = false)"

        @class([
            "bg-white border border-gray-300 shadow-sm rounded-xl relative",
            "dark:bg-gray-800 dark:border-gray-600"  => config('forms.dark_mode'),
        ])
    >

        <div @class([
            'filament-tables-header',
            'flex items-center h-10 overflow-hidden border-b bg-gray-50 rounded-t-xl',
            'dark:bg-gray-800 dark:border-gray-700' => config('forms.dark_mode'),
        ])>

            <div class="flex-1"></div>
            @if ($isCollapsible)
                <div>
                    <button
                        x-on:click="isCollapsed = !isCollapsed"
                        type="button"
                        @class([
                            'flex items-center justify-center flex-none w-10 h-10 text-gray-400 transition hover:text-gray-300',
                            'dark:text-gray-400 dark:hover:text-gray-500' => config('forms.dark_mode'),
                        ])
                    >
                        <x-heroicon-s-minus-sm class="w-4 h-4" x-show="! isCollapsed"/>

                        <span class="sr-only" x-show="! isCollapsed">
                            {{ __('forms::components.repeater.buttons.collapse_item.label') }}
                        </span>

                        <x-heroicon-s-plus-sm class="w-4 h-4" x-show="isCollapsed" x-cloak/>

                        <span class="sr-only" x-show="isCollapsed" x-cloak>
                            {{ __('forms::components.repeater.buttons.expand_item.label') }}
                        </span>
                    </button>
                </div>
            @endif
        </div>

        <div class="px-4">
            <table class="w-full text-left rtl:text-right table-auto mx-4 filament-table-repeater" x-show="! isCollapsed">
                <thead>
                    <tr>

                        @foreach($columnLabels as $columnLabel)
                            @if($columnLabel['display'])
                            <th class="p-2 filament-table-repeater-header-cell"
                                @if($colStyles && isset($colStyles[$columnLabel['component']]))
                                    style="{{ $colStyles[$columnLabel['component']] }}"
                                @endif
                            >
                                <span>
                                    {{ $columnLabel['name'] }}
                                </span>
                            </th>
                            @else
                            <th style="display: none"></th>
                            @endif
                        @endforeach

						@if (!$isItemMovementDisabled || !$isItemDeletionDisabled)
                        	<th class="w-10"></th>
						@endif
                    </tr>
                </thead>

                <tbody
                    wire:sortable
                    wire:end.stop="dispatchFormEvent('repeater::moveItems', '{{ $getStatePath() }}', $event.target.sortable.toArray())"
                >

                    @foreach ($containers as $uuid => $item)

                        <tr
                            x-data="{ isCollapsed: @js($isCollapsed()) }"
                            x-on:repeater-collapse.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = true)"
                            x-on:repeater-expand.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = false)"
                            wire:key="{{ $item->getStatePath() }}"
                            wire:sortable.item="{{ $uuid }}"
                        >

                            @foreach($item->getComponents() as $component)
                            <td
                                @if($component->isHidden() || ($component instanceof \Filament\Forms\Components\Hidden))style="display:none"@endif
                                @if($colStyles && isset($colStyles[$component->getName()]))
                                    style="$colStyles[$component->getName()]"
                                @endif
                            >
                                {{ $component }}
                            </td>
                            @endforeach

							@if (!$isItemMovementDisabled || !$isItemDeletionDisabled)
								<td class="w-10 flex">
									@if (!$isItemMovementDisabled)
										<button
											wire:sortable.handle
											wire:keydown.prevent.arrow-up="dispatchFormEvent('repeater::moveItemUp', '{{ $getStatePath() }}', '{{ $uuid }}')"
											wire:keydown.prevent.arrow-down="dispatchFormEvent('repeater::moveItemDown', '{{ $getStatePath() }}', '{{ $uuid }}')"
											type="button"
											@class([
												'flex items-center justify-center flex-none text-gray-400 w-5 h-10 transition hover:text-gray-300',
												'dark:text-gray-400 dark:hover:text-gray-500' => config('forms.dark_mode'),
											])
										>
											<span class="sr-only">
												{{ __('forms::components.repeater.buttons.move_item_down.label') }}
											</span>

											<x-heroicon-s-switch-vertical class="w-4 h-4"/>
										</button>
									@endif

									@if (!$isItemDeletionDisabled)
										<button
											wire:click="dispatchFormEvent('repeater::deleteItem', '{{ $getStatePath() }}', '{{ $uuid }}')"
											type="button"
											@class([
												'flex items-center justify-center flex-none w-5 h-10 text-danger-600 transition hover:text-danger-500',
												'dark:text-danger-500 dark:hover:text-danger-400' => config('forms.dark_mode'),
											])
										>
											<span class="sr-only">
												{{ __('forms::components.repeater.buttons.delete_item.label') }}
											</span>

											<x-heroicon-s-trash class="w-4 h-4"/>
										</button>
									@endif
								</td>
							@endif
                        </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="p-2 text-xs text-center text-gray-400" x-show="isCollapsed" x-cloak>
                {{ __('forms::components.repeater.collapsed') }}
            </div>
        </div>

        @if(!$isItemCreationDisabled)
            <div class="relative flex justify-center py-2">
                <x-forms::button
                    :wire:click="'dispatchFormEvent(\'repeater::createItem\', \'' . $getStatePath() . '\')'"
                    size="sm"
                    type="button"
                >
                    {{ $getCreateItemButtonLabel() }}
                </x-forms::button>
            </div>
        @endif

    </div>
</x-dynamic-component>
