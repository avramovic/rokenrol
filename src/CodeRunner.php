<?php namespace Avram\Rokenrol;

class CodeRunner
{
    protected $variables;

    public function assign($var, $value)
    {
        $this->variables[$var] = $value;
    }

    public function run($php)
    {
        extract($this->variables);
        eval($php);
    }
}