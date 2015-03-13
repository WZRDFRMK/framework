<?php

namespace Wzrd\Test\Transformer;

use Mockery;
use League\Fractal;
use PHPUnit_Framework_TestCase;
use Wzrd as Framework;

class FractalTransformerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->fractal = Mockery::mock('League\Fractal\Manager')->makePartial();
        $this->transformer = new Framework\Transformer\FractalTransformer($this->fractal);
    }

    public function test_transform_single_value()
    {
        // Prepare ..
        $scope = Mockery::mock('League\Fractal\Scope')->makePartial();
        $scope->shouldReceive('toArray')->andReturn(true)->once();
        $this->fractal->shouldReceive('parseIncludes')->with('include1,include2')->once();
        $this->fractal->shouldReceive('createData')->with(Mockery::type('League\Fractal\Resource\Item'))->andReturn($scope)->once();

        // Transform ..
        $this->assertTrue($this->transformer->transform('user', 'UserTransformer', array('include1', 'include2')));
    }

    public function test_transform_collection()
    {
        // Prepare ..
        $scope = Mockery::mock('League\Fractal\Scope')->makePartial();
        $scope->shouldReceive('toArray')->andReturn(true)->once();
        $this->fractal->shouldReceive('parseIncludes')->with('include1,include2')->once();
        $this->fractal->shouldReceive('createData')->with(Mockery::type('League\Fractal\Resource\Collection'))->andReturn($scope)->once();

        // Transform ..
        $this->assertTrue($this->transformer->transform(array('user', 'user'), 'UserTransformer', array('include1', 'include2')));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
