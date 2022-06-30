<?php

namespace Icetalker\FilamentTableRepeater\Forms\Components;

use Filament\Forms\Components\Repeater;

class TableRepeater extends Repeater
{
    protected string $view = 'forms.components.table-repeater';

    //columns for table header
    protected array|null $columnLabels = [];

    public function getColumnLabels():array|null
    {
        $this->setColumnLabels();

        return $this->columnLabels;
    }

    protected function setColumnLabels():void
    {
        $components = $this->getChildComponents();

        foreach($components as $component){
            $this->columnLabels[] = $component->getLabel();
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

}
