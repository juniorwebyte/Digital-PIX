<?php

namespace App\Console\Commands;

use App\Video;
use Illuminate\Console\Command;

class VideoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tutorial:davi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Video::create([
            'title' => 'Conhecendo o Painel Administrativo',
            'link' => 'JgyfWB-EiEw'
        ]);

        Video::create([
            'title' => 'Como Definir Ganhador Pelo Número Da Loteria Federal',
            'link' => 'hxDW8T0BIyU'
        ]);
    }
}
