<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Core\App;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use React\EventLoop\LoopInterface;
use React\Filesystem\Filesystem;
use React\Filesystem\Node\FileInterface;
use React\Promise\PromiseInterface;
use SplObjectStorage;

class FilesystemListener implements EventListenerInterface
{
    /**
     * @var PromiseInterface
     */
    protected $files;

    public function __construct(LoopInterface $loop)
    {
        $this->files = Filesystem::create($loop)->dir(App::path('webroot', 'plugin'))->lsRecursive();
    }

    /**
     * Return implemented events.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            RequestEvent::EVENT => 'request',
        ];
    }

    public function request(RequestEvent $event)
    {
        $this->files->then(function (SplObjectStorage $listing) use ($event) {
            foreach ($listing as $node) {
                if (!($node instanceof FileInterface)) {
                    continue;
                }

                if ($event->getRequest()->getPath() == $node->getPath()) {
                    $node->getContents()->then(function ($contents) use ($event) {
                        $event->getResponse()->writeHead(200);
                        $event->getResponse()->end($contents);
                    });
                    $event->stopPropagation();
                }
            }
        });
    }
}
