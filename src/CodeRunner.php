<?php namespace Avram\Rokenrol;

class CodeRunner
{
    protected array $variables;

    public function __construct(protected CodeParser $parser)
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