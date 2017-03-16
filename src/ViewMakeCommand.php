<?php

namespace BenComeau\ArtisanMakeView;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ViewMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view
        {name : The name of the view to create in dot notation.}
        {--r|resource : Indicates if the view represents a resource.}
        {--p|view-path=0 : Indicates the key for your view storage path. A sensible default has been selected.}
        {--e|extension=blade.php : Indicates the extension of the view. A sensible default has been selected.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create individual views and view resources';

    /**
     * The Filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * The type of resource views that will
     * be created when the user selects
     * to create a view resource.
     * 
     * @var array
     */
    protected $resources = ['index', 'create', 'show', 'edit'];

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem 
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $views = $this->views();

        foreach ((array) $this->views() as $path) {
            if ($this->fileExists($path)) continue;

            $this->makeDirectory($path);

            $this->makeView($path);
        }
    }

    /**
     * Check if a file already exists.
     *
     * @param  string  $path
     * @return bool
     */
    protected function fileExists(string $path)
    {
        if (! $this->filesystem->exists($path)) return false;
        
        $this->error(sprintf('The view %s already exists in the directory!', $this->filesystem->basename($path)));

        return true;
    }

    /**
     * Create the directory.
     *
     * @param  string $path 
     * @return void
     */
    protected function makeDirectory(string $path)
    {
        $directory = $this->filesystem->dirname($path);

        if (! $this->filesystem->isDirectory($directory)) {
            $this->filesystem->makeDirectory($directory);
        }
    }

    /**
     * Create the view.
     * 
     * @param  string  $path
     * @return void
     */
    protected function makeView(string $path)
    {
        $this->filesystem->put($path, '');
    }

    /**
     * Get the views that should be created.
     * 
     * @return  mixed
     */
    protected function views()
    {
        if ($this->option('resource')) {
            foreach ($this->resources as $resource) {
                $views[] = $this->getPath($resource);
            }

            return $views;
        }
        
        return $this->getPath();
    }

    /**
     * Generate the fully qualified path of a file name.
     * 
     * @param  $directory
     * @return string
     */
    protected function getPath($directory = false)
    {
        return sprintf('%s\\%s.%s',
            config('view.paths')[$this->option('view-path')],
            str_replace('.', '\\', $this->argument('name') . ($directory ? '\\' . $directory : '')),
            $this->option('extension')
        );
    }
}