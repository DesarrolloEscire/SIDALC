<?php

/**
 * @see       https://github.com/laminas/laminas-paginator-adapter-laminasdb for the canonical source repository
 * @copyright https://github.com/laminas/laminas-paginator-adapter-laminasdb/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-paginator-adapter-laminasdb/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Laminas\Paginator\Adapter\LaminasDb\Exception;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Paginator\Adapter\LaminasDb\DbSelect;
use Laminas\Paginator\Adapter\LaminasDb\DbTableGateway;
use RuntimeException;

use function sprintf;

final class ServiceNotCreatedException extends RuntimeException implements ExceptionInterface
{
    public static function forMissingDbSelectDependencies(): self
    {
        return new self(sprintf(
            '%s requires at least two options in the following order: a %s instance and a %s instance',
            DbSelect::class,
            Select::class,
            AdapterInterface::class
        ));
    }

    public static function forMissingDbTableGatewayDependencies(): self
    {
        return new self(sprintf(
            '%s requires at least one option, a %s instance',
            DbTableGateway::class,
            AbstractTableGateway::class
        ));
    }
}
