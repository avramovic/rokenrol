<?php namespace Avram\Rokenrol;

use Avram\Rokenrol\Interfaces\ICodeParserInterface;

class CodeRunner
{
    protected array $variables;

    public function __construct(protected ICodeParserInterface $parser)
    {
        //
    }

    public function assign(string $var, mixed $value): static
    {
        $this->variables[$var] = $value;
        return $this;
    }

    public function run(string $code): void
    {
        $php = $this->parser->parse($code);
        extract($this->variables);
        eval($php);
    }
}