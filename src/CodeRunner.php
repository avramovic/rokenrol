<?php namespace Avram\Rokenrol;

class CodeRunner
{
    public function run($php)
    {
        eval($php);
    }
}