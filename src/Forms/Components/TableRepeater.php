<?php

namespace Icetalker\FilamentTableRepeater\Forms\Components;

use Closure;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class TableRepeater extends Repeater
{
    protected string $view = 'filament-table-repeater::table-repeater';

    //columns for table header
    protected array|null $columnLabels = [];

    protected array| Closure | null $colStyles = null;

    protected function setUp(): void
    {
        $this->columnSpanFull();
        parent::setUp();
    }

    public function getColumnLabels(): array|null
    {
        return $this->columnLabels;
    }

    public function childComponents(array | Schema | Component | Action | ActionGroup | string | Htmlable | Closure | null $components, string $key = 'default'): static
    {
        foreach ($components as $component) {
            $component->hiddenLabel(); //Disable Label, only show Inputs inside table
            $this->childComponents[$key][] = $component;

            //Set Columen Labels
            $this->columnLabels[] = [
                'component' => $component->getName(),
                'name' => $component->getLabel(),
                'display' => ($component->isHidden() || ($component instanceof \Filament\Forms\Components\Hidden)) ? false : true,
            ];
        }

        return $this;
    }

    public function colStyles(array | Closure $colstyles): static
    {
        $this->colStyles = $colstyles;

        return $this;
    }

    public function getColStyles(): array| Closure | null
    {
        return $this->evaluate($this->colStyles);
    }

    //So that `OrderColumn()` could be used before `relationship()`
    public function relationship(string | Closure | null $name = null, ?Closure $modifyQueryUsing = null): static
    {
        parent::relationship($name, $modifyQueryUsing);

        if ($this->orderColumn) {
            $this->reorderable($this->evaluate($this->orderColumn));
        }

        return $this;
    }
}
