<?php

namespace Phive\TaskQueue;

use Phive\Queue\Queue\Queue;

class SerializerAwareQueue implements Queue
{
    /**
     * @var Queue
     */
    private $queue;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(Queue $queue, SerializerInterface $serializer = null)
    {
        $this->queue = $queue;
        $this->serializer = $serializer ?: new Serializer();
    }

    /**
     * {@inheritdoc}
     */
    public function push($item, $eta = null)
    {
        $item = $this->serializer->serialize($item);
        $this->queue->push($item, $eta);
    }

    /**
     * {@inheritdoc}
     */
    public function pop()
    {
        $item = $this->queue->pop();

        return $this->serializer->deserialize($item);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->queue->count();
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->queue->clear();
    }
}