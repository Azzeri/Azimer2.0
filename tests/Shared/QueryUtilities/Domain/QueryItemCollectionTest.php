<?php

declare(strict_types=1);

namespace App\Tests\Shared\QueryUtilities\Domain;

use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;

it('creates a new instance of a collection', function () {
    // Arrange
    $queryItems = [QueryItem::create('1', []), QueryItem::create('2', [])];

    // Act
    $collection = QueryItemCollection::create($queryItems);

    // Assert
    expect($collection)->toBeInstanceOf(QueryItemCollection::class);
});
