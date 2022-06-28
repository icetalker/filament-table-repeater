<?php

namespace Icetalker\FilamentTableRepeater\Forms\Components;

use Filament\Forms\Components\Repeater;

class TableRepeater extends Repeater
{
    protected string $view = 'forms.components.table-repeater';

    //columns for table header
    protected array|null $labelColumns = [];

    public function getLabelColumns(): array|null
    {
        return $this->labelColumns;
    }

    protected function setLabelColumns(): void
    {
        $components = $this->getChildComponents();

        foreach ($components as $component) {
            $this->labelColumns[] = $component->getLabel();
        }
    }

    public function childComponents(array | \Closure $components): static
    {
        foreach ($components as $component) {
            $component->disableLabel(); //Disable Label, only show Inputs inside table
            $this->childComponents[] = $component;
        }

        return $this;
    }

    // Add: Set Table Header Column
    public function schema(array | \Closure $components): static
    {
        $this->childComponents($components);
        $this->setLabelColumns($components);

        return $this;
    }
}
