<?php

namespace WyriHaximus\CakeFest2016\Event;

use Cake\Core\App;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use React\EventLoop\LoopInterface;
use React\Filesystem\Filesystem;
use React\Filesystem\Node\FileInterface;
use React\Promise\PromiseInterface;
use React\Promise\RejectedPromise;
use SplObjectStorage;

class FilesystemListener implements EventListenerInterface
{
    /**
     * @var PromiseInterface
     */
    protected $files;

    /**
     * @var string
     */
    protected $webroot;

    public function __construct(LoopInterface $loop)
    {
        $this->webroot = ROOT . DS . App::path('webroot', 'WyriHaximus/CakeFest2016')[0];
        $this->files = Filesystem::create($loop)->dir($this->webroot)->lsRecursive();
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

                if ($this->webroot . $event->getRequest()->getPath() == $node->getPath()) {
                    $event->stopPropagation();
                    return $node->getContents();
                }
            }

            return new RejectedPromise();
        })->then(function ($contents) use ($event) {
            $event->getResponse()->writeHead(200);
            $event->getResponse()->end($contents);
        }, function () use ($event) {
            $event->getResponse()->writeHead(404);
            $event->getResponse()->end('O noes 404');
        });
    }
}
