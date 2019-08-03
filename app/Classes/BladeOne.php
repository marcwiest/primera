<?php

namespace App\Classes;

use eftec\bladeone\BladeOne as BladeOneBase;

class BladeOne extends BladeOnBase
{
    /**
    * Constructor function.
    * See parent class for details.
    */
    public function __construct($templatePath=null, $compiledPath=null, $mode=0)
    {
        parent::__construct($templatePath, $compiledPath, $mode);

        $this->directive('svg', [$this, 'compileSvgDirective']);
    }

    public function compileSvgDirective($expression)
    {
        $svgName = $this->stripQuotes($expression);
        return "<?php include get_theme_file_path('public/img/{$svgName}.svg'); ?>";
    }

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
