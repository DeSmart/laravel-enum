<?php

declare(strict_types=1);

namespace DeSmart\Laravel\Enumeration\Tests;

use DeSmart\Laravel\Enumeration\Enumeration;
use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;

class EnumerationCastTest extends TestCase
{
    /** @test */
    public function it_should_get_attribute_as_an_enum(): void
    {
        $model = new TestModel();
        $model->setRawAttributes(['character' => Character::GOOD]);

        $attribute = $model->getAttribute('character');

        $this->assertInstanceOf(Character::class, $attribute);
        $this->assertEquals(Character::GOOD, $attribute->getValue());
    }

    /** @test */
    public function it_should_get_attribute_as_null_value(): void
    {
        $model = new TestModel();
        $model->setRawAttributes(['character' => null]);

        $this->assertNull($model->getAttribute('character'));
    }

    /** @test */
    public function it_should_set_enum_object_as_attribute(): void
    {
        $model = new TestModel();
        $model->setAttribute('character', Character::sometimesGoodSometimesEvil());

        $this->assertEquals(Character::SOMETIMES_GOOD_SOMETIMES_EVIL, $model->getAttributes()['character']);
    }

    /** @test */
    public function it_should_serialize_enum_attribute(): void
    {
        $model = new TestModel(['character' => Character::evil()]);

        $modelToArray = $model->toArray();

        $this->assertEquals(Character::EVIL, $modelToArray['character']);
    }
}

class TestModel extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'character' => Character::class,
    ];
}

class Character extends Enumeration
{
    const GOOD = 'good';
    const EVIL = 'evil';
    const SOMETIMES_GOOD_SOMETIMES_EVIL = 'sometimes_good_sometimes_evil';
}