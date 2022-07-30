<?php

/**
 * @see       https://github.com/laminas/laminas-paginator-adapter-laminasdb for the canonical source repository
 * @copyright https://github.com/laminas/laminas-paginator-adapter-laminasdb/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-paginator-adapter-laminasdb/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Paginator\Adapter\LaminasDb;

class ConfigProvider
{
    /**
     * Retrieve default laminas-paginator configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'paginators' => $this->getPaginatorConfig(),
        ];
    }

    /**
     * Retrieve configuration for laminas-paginator adapter plugin manager.
     *
     * @return array
     */
    public function getPaginatorConfig()
    {
        return [
            'aliases'   => [
                'dbselect'       => DbSelect::class,
                'dbSelect'       => DbSelect::class,
                'DbSelect'       => DbSelect::class,
                'dbtablegateway' => DbTableGateway::class,
                'dbTableGateway' => DbTableGateway::class,
                'DbTableGateway' => DbTableGateway::class,
            ],
            'factories' => [
                DbSelect::class       => DbSelectFactory::class,
                DbTableGateway::class => DbTableGatewayFactory::class,
            ],
        ];
    }
}
