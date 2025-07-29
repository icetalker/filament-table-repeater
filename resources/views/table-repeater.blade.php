@php
use Filament\Support\Enums\Alignment;
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

    @php
        $items = $getItems();

        $addAction = $getAction($getAddActionName());
        $addActionAlignment = $getAddActionAlignment();
        $cloneAction = $getAction($getCloneActionName());
        $deleteAction = $getAction($getDeleteActionName());
        $moveDownAction = $getAction($getMoveDownActionName());
        $moveUpAction = $getAction($getMoveUpActionName());
        $reorderAction = $getAction($getReorderActionName());

        $isAddable = $isAddable();
        $isCloneable = $isCloneable();
        $isCollapsible = $isCollapsible();//
        $isDeletable = $isDeletable();
        $isReorderable = $isReorderable();
        $isReorderableWithButtons = $isReorderableWithButtons();
        $isReorderableWithDragAndDrop = $isReorderableWithDragAndDrop();

        $statePath = $getStatePath();

        $columnLabels = $getColumnLabels();
        $colStyles = $getColStyles();
        //---

        $addBetweenAction = $getAction($getAddBetweenActionName());//
        $extraItemActions = $getExtraItemActions();

    @endphp

    <div
        {{-- x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }"  --}}
        x-data="{ isCollapsed: @js($isCollapsed()) }"
        x-on:repeater-collapse.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = true)"
        x-on:repeater-expand.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = false)"

        {{
            $attributes
                ->merge($getExtraAttributes(), escape: false)
                ->class(['it-table-repeater'])
        }}
    >

        <div
            class="it-table-repeater-header"
        >

            <div></div>
        
            @if ($isCollapsible)
                <div>
                    <button
                        x-on:click="isCollapsed = !isCollapsed"
                        type="button"
                        class="it-table-repeater-btn-collapse"
                    >
                    
                        <x-heroicon-s-chevron-up class="w-4 h-4" x-show="! isCollapsed"/>

                        <span class="sr-only" x-show="! isCollapsed">
                            {{ __('filament-forms::components.repeater.actions.collapse.label') }}
                        </span>

                        <x-heroicon-s-chevron-down class="w-4 h-4" x-show="isCollapsed" x-cloak/>

                        <span class="sr-only" x-show="isCollapsed" x-cloak>
                            {{ __('filament-forms::components.repeater.actions.expand.label') }}
                        </span>
                    </button>
                </div>
            @endif
        </div>

        <div class="px-4{{ $isAddable? '' : ' py-2' }}">
            <table x-show="! isCollapsed">
                <thead>
                    <tr>

                        @foreach($columnLabels as $columnLabel)
                            @if($columnLabel['display'])
                            <th
                                @if($colStyles && isset($colStyles[$columnLabel['component']]))
                                    style="{{ $colStyles[$columnLabel['component']] }}"
                                @endif
                            >
                                <span>
                                    {{ $columnLabel['name'] }}
                                </span>
                            </th>
                            @else
                            <th class="hidden"></th>
                            @endif
                        @endforeach

                        @if (count($extraItemActions)||$isReorderableWithDragAndDrop || $isReorderableWithButtons || $isCloneable || $isDeletable)
                        	<th></th>
						@endif
                    </tr>
                </thead>

                <tbody
                    x-sortable
                >

                    @foreach ($items as $itemKey => $item)

                        <tr
                            x-on:repeater-collapse.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = true)"
                            x-on:repeater-expand.window="$event.detail === '{{ $getStatePath() }}' && (isCollapsed = false)"
                            wire:key="{{ $item->getLivewireKey() }}.item"
                            x-sortable-item="{{ $itemKey }}"
                        >

                            @foreach ($item->getComponents(withHidden: true) as $component)
                            <td>
                               {{ $component }}
                            </td>
                            @endforeach

                            @if (count($extraItemActions)||$isReorderableWithDragAndDrop || $isReorderableWithButtons || $isCloneable || $isDeletable )
								<td class="it-table-repeater-actions">

                                    @foreach ($extraItemActions as $extraItemAction)
                                        <div x-on:click.stop>
                                            {{ $extraItemAction(['item' => $itemKey]) }}
                                        </div>
                                    @endforeach
                                    @if ($isReorderableWithDragAndDrop || $isReorderableWithButtons)
                                        @if ($isReorderableWithDragAndDrop)
                                            <div
                                                x-sortable-handle
                                                x-on:click.stop
                                            >
                                                {{ $reorderAction }}
                                            </div>
                                        @endif

                                        @if ($isReorderableWithButtons)
                                            <div
                                                class="flex items-center justify-center"
                                            >
                                                {{ $moveUpAction(['item' => $itemKey])->disabled($loop->first) }}
                                            </div>

                                            <div
                                                class="flex items-center justify-center"
                                            >
                                                {{ $moveDownAction(['item' => $itemKey])->disabled($loop->last) }}
                                            </div>
                                        @endif

                                    @endif

                                    @if ($isCloneable || $isDeletable )
                                        @if ($cloneAction->isVisible())
                                            <div>
                                                {{ $cloneAction(['item' => $itemKey]) }}
                                            </div>
                                        @endif

                                        @if ($isDeletable)
                                            <div>
                                                {{ $deleteAction(['item' => $itemKey]) }}
                                            </div>
                                        @endif

                                    @endif

                                </td>
							@endif
                        </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="it-table-repeater-collapsed" x-show="isCollapsed" x-cloak>
                {{ __('filament-table-repeater::components.table-repeater.collapsed') }}
            </div>
        </div>

        @if ($isAddable && $addAction->isVisible())
            <div
                @class([
                    'it-table-repeater-add',
                    match ($addActionAlignment) {
                        Alignment::Start, Alignment::Left => 'justify-start',
                        Alignment::Center, null => 'justify-center',
                        Alignment::End, Alignment::Right => 'justify-end',
                        default => $alignment,
                    },
                ])
            >
                {{ $addAction }}
            </div>
        @endif

    </div>

</x-dynamic-component>
