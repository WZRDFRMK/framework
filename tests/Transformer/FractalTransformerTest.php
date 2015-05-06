<?php

namespace WZRD\Test\Transformer;

use Mockery;
use League\Fractal;
use PHPUnit_Framework_TestCase;
use WZRD as Framework;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

class FractalTransformerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->fractal     = Mockery::mock('League\Fractal\Manager')->makePartial();
        $this->transformer = new Framework\Transformer\FractalTransformer($this->fractal, function ($page) {return $page;});
    }

    public function test_transform_single_value()
    {
        // Prepare ..
        $transformer = Mockery::mock('League\Fractal\TransformerAbstract');
        $scope       = Mockery::mock('League\Fractal\Scope')->makePartial();
        $scope->shouldReceive('toArray')->andReturn(true)->once();
        $this->fractal->shouldReceive('parseIncludes')->with('include1,include2')->once();
        $this->fractal->shouldReceive('createData')->with(Mockery::type('League\Fractal\Resource\Item'))->andReturn($scope)->once();

        // Transform ..
        $this->assertTrue($this->transformer->transform('user', $transformer, ['include1', 'include2']));
    }

    public function test_transform_collection_array()
    {
        // Prepare ..
        $transformer = Mockery::mock('League\Fractal\TransformerAbstract');
        $scope       = Mockery::mock('League\Fractal\Scope')->makePartial();
        $scope->shouldReceive('toArray')->andReturn(true)->once();
        $this->fractal->shouldReceive('parseIncludes')->with('include1,include2')->once();
        $this->fractal->shouldReceive('createData')->with(Mockery::type('League\Fractal\Resource\Collection'))->andReturn($scope)->once();

        // Transform ..
        $this->assertTrue($this->transformer->transform(['user', 'user'], $transformer, ['include1', 'include2']));
    }

    public function test_transform_collection_pagerfanta()
    {
        // Prepare ..
        $transformer = Mockery::mock('League\Fractal\TransformerAbstract');
        $adapter     = new ArrayAdapter(['user', 'user']);
        $pagerfanta  = new Pagerfanta($adapter);
        $scope       = Mockery::mock('League\Fractal\Scope')->makePartial();
        $scope->shouldReceive('toArray')->andReturn(true)->once();
        $this->fractal->shouldReceive('parseIncludes')->with('include1,include2')->once();
        $this->fractal->shouldReceive('createData')->with(Mockery::type('League\Fractal\Resource\Collection'))->andReturn($scope)->once();

        // Transform ..
        $this->assertTrue($this->transformer->transform($pagerfanta, $transformer, ['include1', 'include2']));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
