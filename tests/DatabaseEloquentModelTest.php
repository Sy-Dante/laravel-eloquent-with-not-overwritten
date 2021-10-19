<?php

namespace Sydante\Tests;

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;
use Mockery as m;
use Orchestra\Testbench\TestCase;
use Sydante\LaravelEloquentWithNotOverwritten\ServiceProvider;

class DatabaseEloquentModelTest extends TestCase
{

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        m::close();
    }

    public function testEagerLoadingWithOverwrite(): void
    {
        $model = new EloquentModelWithoutRelationStub;

        $instance = $model->newInstance()
            ->newQuery()
            ->with('foo:bar,baz')
            ->withNotOverwritten('foo.yao');

        $builder = m::mock(Builder::class);

        $builder->shouldReceive('select')
            ->once()
            ->with(['bar', 'baz']);

        $this->assertNotNull($instance->getEagerLoads()['foo']);
        $this->assertNotNull($instance->getEagerLoads()['foo.yao']);
        $closure = $instance->getEagerLoads()['foo'];
        $closure($builder);
    }

}

class EloquentModelWithoutRelationStub extends Model
{

    public $with = ['foo'];

    public function getConnection()
    {
        $mock = m::mock(Connection::class);

        $mock->shouldReceive('getQueryGrammar')
            ->andReturn(
                $grammar = m::mock(Grammar::class)
            );

        $mock->shouldReceive('getPostProcessor')
            ->andReturn(
                $processor = m::mock(Processor::class)
            );

        $mock->shouldReceive('query')
            ->andReturnUsing(
                function () use ($mock, $grammar, $processor) {
                    return new BaseBuilder($mock, $grammar, $processor);
                }
            );

        return $mock;
    }

}
