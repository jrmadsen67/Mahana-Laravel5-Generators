<?php

namespace jrmadsen67\MahanaGenerators\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends BaseGeneratorCommand {
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mahana:model';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new Eloquent model class';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'Model';

	/**
	 * Build the class with the given name.
	 *
	 * @param  string  $name
	 * @return string
	 */
	protected function buildClass($name) {
		$stub = $this->files->get($this->getStub());

		return $this->replaceNamespace($stub, $name)
			->replaceTable($stub)
			->replacePrimaryKey($stub)
			->replaceFillable($stub)
			->replaceDates($stub)
			->replaceClass($stub, $name);
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub() {
		return __DIR__ . '/../stubs/model.stub';
	}

	protected function replaceTable(&$stub) {

		$table = $this->option('table') ? 'protected $table = \'' . $this->option('table') . '\';' : '';

		$stub = str_replace('TABLE', $table, $stub);

		return $this;
	}

	protected function replacePrimaryKey(&$stub) {

		$primary = ($this->option('primary')) ? 'protected $primaryKey = \'' . $this->option('primary') . '\';' : '';

		$stub = str_replace('PRIMARYKEY', $primary, $stub);

		return $this;
	}

	protected function replaceFillable(&$stub) {

		$fillable = '';

		if ($this->option('fillable')) {
			$fillable = 'protected $fillable = [' . $this->parseStringToArray($this->option('fillable')) . '];';
		}

		$stub = str_replace('FILLABLE', $fillable, $stub);

		return $this;
	}

	protected function replaceDates(&$stub) {

		$dates = '';

		if ($this->option('dates')) {
			$dates = 'protected $dates = [' . $this->parseStringToArray($this->option('dates')) . '];';
		}

		$stub = str_replace('DATES', $dates, $stub);

		return $this;
	}

	/**
	 * Get the default namespace for the class.
	 *
	 * @param  string  $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace($rootNamespace) {
		return $rootNamespace;
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return [
			['table', 't', InputOption::VALUE_OPTIONAL, 'Specify name for table', null],
			['primary', 'p', InputOption::VALUE_OPTIONAL, 'Specify pk field for table', null],
			['fillable', 'f', InputOption::VALUE_OPTIONAL, 'List fillable fields separated by commas', null],
			['dates', 'd', InputOption::VALUE_OPTIONAL, 'List Carbon date fields separated by commas', null],
		];
	}

}
