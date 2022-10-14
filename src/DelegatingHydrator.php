<?php

declare(strict_types=1);

namespace Laminas\Hydrator;

use Psr\Container\ContainerInterface;

class DelegatingHydrator implements HydratorInterface
{
    /** @var ContainerInterface */
    protected $hydrators;

    public function __construct(ContainerInterface $hydrators)
    {
        $this->hydrators = $hydrators;
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate(array $data, object $object)
    {
        return $this->getHydrator($object)->hydrate($data, $object);
    }

    /**
     * {@inheritdoc}
     */
    public function extract(object $object): array
    {
        return $this->getHydrator($object)->extract($object);
    }

    /**
     * Gets hydrator for an object
     */
    protected function getHydrator(object $object): HydratorInterface
    {
        return $this->hydrators->get($object::class);
    }
}
