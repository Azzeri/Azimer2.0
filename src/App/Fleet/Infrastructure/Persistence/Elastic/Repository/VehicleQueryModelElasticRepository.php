<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Persistence\Elastic\Repository;

use App\Fleet\Domain\Dto\VehicleQueryModel;
use App\Fleet\Domain\Repository\VehicleQueryModelRepository;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Ramsey\Collection\Collection;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Implementation of {@see VehicleQueryModelRepository} with Elastic search engine
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehicleQueryModelElasticRepository implements VehicleQueryModelRepository
{
    /**
     * @param TransformedFinder $elasticFinder
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        #[Autowire(service: 'fos_elastica.finder.vehicle')]
        private TransformedFinder $elasticFinder,
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function findByPlateNumber(VehiclePlateNumber $plateNumber): ?VehicleQueryModel
    {
        $result = $this->elasticFinder->find((string)$plateNumber);
        return empty($result) ? null : $result[0];
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function search(): Collection
    {
        /** @var array<int,VehicleQueryModel> $results */
        $results = $this->elasticFinder->find('*', 999);

        return new Collection(
            VehicleQueryModel::class,
            $results
        );
    }
}
