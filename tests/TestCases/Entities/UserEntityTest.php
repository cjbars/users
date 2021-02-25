<?php

namespace Entities;

use User\Entities\UserEntity;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{

    private UserEntity $user;

    public function setUp(): void
    {
        $name = 'test';
        $email = 'test@example.com';
        $created = new \DateTime();
        $notes = 'some notes text';

        $this->user = new UserEntity([
            'name' => $name,
            'email' => $email,
            'created' => $created,
            'notes' => $notes
        ]);
    }

    public function test__construct()
    {
        $name = 'test';
        $email = 'test@example.com';
        $created = new \DateTime();
        $notes = 'some notes text';

        $user = new UserEntity([
            'name' => $name,
            'email' => $email,
            'created' => $created,
            'notes' => $notes
        ]);
        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
        $this->assertEquals($created, $user->created);
        $this->assertEquals($notes, $user->notes);
    }

    public function testPrimaryKey()
    {
        $this->user->setPrimaryKey(1);
        $this->assertEquals(1, $this->user->getPrimaryKey());
    }

    public function testToArray()
    {
        $arr = $this->user->toArray();
        $this->assertArrayHasKey('id', $arr);
        $this->assertArrayHasKey('name', $arr);
        $this->assertArrayHasKey('email', $arr);
        $this->assertArrayHasKey('created', $arr);
        $this->assertArrayHasKey('deleted', $arr);
        $this->assertArrayHasKey('notes', $arr);
    }
}
