<?php

namespace Tests\Unit\App\Shared\QueryUtilities\Domain;

use App\Shared\QueryUtilities\Domain\QueryItem;

it('can be created', function () {
    // Arrange // Act
    $queryItem = QueryItem::create('123', 'data');

    // Assert
    expect($queryItem)->toBeInstanceOf(QueryItem::class)
        ->and($queryItem->id)->toEqual('123')
        ->and($queryItem->data)->toEqual('data');
});
