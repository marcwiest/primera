<?php

namespace App\Classes;

use eftec\bladeone\BladeOne as BladeOneBase;

class BladeOne extends BladeOnBase
{

    // NOTE: Example component alias. Rename: `compileExample`, `compileEndExample` & `components.example`.
    // NOTE: $slot is available within the component.
    public function compileExample($expression)
    {
        return $this->phpTag . " \$this->startComponent('components.example', []); ?>";
    }
    public function compileEndExample()
    {
        return $this->compileEndComponent();
    }
}
