<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\GeneratorTrait;

class MakeTestController extends BaseCommand
{
    use GeneratorTrait;

    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Generators';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'make:testcontroller';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generates a new file.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:testcontroller <name> [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'name' => 'The file class name.',
    ];


    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [
        '--command'   => 'The command name. Default: "command:name"',
        '--type'      => 'The command type. Options [basic, generator]. Default: "basic".',
        '--force'     => 'Force overwrite existing file.',
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->component = 'Command';
        $this->directory = 'Controllers';
        $this->template  = 'command.tpl.php';

        $this->execute($params);
    }

    /**
     * Prepare options and do the necessary replacements.
     */
    protected function prepare(string $class): string
    {
        $command = $this->getOption('command');
        $type    = $this->getOption('type');

        $command = is_string($command) ? $command : 'command:name';
        $type    = is_string($type) ? $type : 'basic';

        if (! in_array($type, ['basic', 'generator'], true)) {
            // @codeCoverageIgnoreStart
            $type = CLI::prompt(lang('CLI.generator.commandType'), ['basic', 'generator'], 'required');
            CLI::newLine();
            // @codeCoverageIgnoreEnd
        }

        return $this->parseTemplate(
            $class,
            ['{command}'],
            [$command],
            ['type' => $type]
        );
    }
}
