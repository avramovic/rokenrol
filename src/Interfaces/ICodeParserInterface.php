<?php

namespace Avram\Rokenrol\Interfaces;

interface ICodeParserInterface
{
    public function parse(string $code): string;
}