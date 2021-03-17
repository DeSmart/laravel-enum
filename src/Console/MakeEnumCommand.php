<?php

declare(strict_types=1);

namespace DeSmart\Laravel\Enumeration\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use function DeSmart\Enum\Helpers\toConstName;

class MakeEnumCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'make:enum';

    /**
     * @var string
     */
    protected $description = 'Create a new Enumeration class';

    /**
     * @var string
     */
    protected $type = 'Enum';

    /**
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function replaceClass($stub, $name): string
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        $staticMethods = "\n";
        $constants = '';

        if ($this->option('cases')) {
            $cases = array_map('trim', explode(',', $this->option('cases')));

            $staticMethods .= $this->generateStaticMethods($cases, $class);
            $constants .= $this->generateConstants($cases);
        }

        $constants .= '}';

        return str_replace(
            ['{{ staticMethods }}', '{{ constants }}', '{{ class }}'],
            [$staticMethods, $constants, $class],
            $stub
        );
    }

    protected function generateStaticMethods(array $cases, string $class): string
    {
        $staticMethods = "/**\n";

        foreach ($cases as $case) {
            $method = Str::camel(Str::lower($case));
            $staticMethods .= " * @method static $class $method()\n";
        }

        $staticMethods .= " */\n";

        return $staticMethods;
    }

    protected function generateConstants(array $cases): string
    {
        $constants = '';

        foreach ($cases as $case) {
            $constant = toConstName($case);
            $constants .= "\tconst $constant = '$case';\n";
        }

        return $constants;
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/enum.stub';
    }

    /**
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\Enums';
    }

    protected function getOptions(): array
    {
        return [
            ['cases', '-c', InputOption::VALUE_OPTIONAL, 'Set enum cases'],
        ];
    }
}
