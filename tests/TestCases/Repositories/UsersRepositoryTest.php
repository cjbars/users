<?php

namespace TestCases\Repositories;

use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;
use TestCases\Fixtures\InitialStateTrait;
use User\Entities\Entity;
use User\Entities\UserEntity;
use User\Exceptions\ValidationException;
use User\Logger\ArrayLogger;
use User\Repositories\Repository;
use User\Repositories\UsersRepository;
use User\Storages\ArrayStorage;

class UsersRepositoryTest extends TestCase
{
    use InitialStateTrait;

    private Repository $usersRepository;

    public function setUp(): void
    {
        $this->usersRepository = new UsersRepository(
            new ArrayStorage($this->getInitialState()),
            new ArrayLogger()
        );
        $this
            ->usersRepository
            ->setDisallowedNames(['disallowed', 'wrongword'])
            ->setDisallowedDomains(['bad.com', 'ignore.ru']);

    }

    public function testGetByExistingId()
    {
        $user = $this->usersRepository->getById(1);
        $this->assertInstanceOf(Entity::class, $user);
        $this->assertEquals(1, $user->getPrimaryKey());
    }

    public function testByNonExistingId()
    {
        $user = $this->usersRepository->getById(100500);
        $this->assertNull($user);
    }

    /**
     * @throws ValidationException
     */
    public function testAddValidUser()
    {
        $user = new UserEntity([
            'name' => 'testvalid',
            'email' => 'testvalid@xample.com',
            'created' => new DateTime()
        ]);
        $this->usersRepository->create($user);
        $this->assertCount(2, $this->usersRepository->getAll());
    }

    /**
     * @dataProvider invalidNamesProvider
     * @param $name
     */
    public function testAddWithBadName($name)
    {
        $this->expectException(ValidationException::class);
        $user = new UserEntity([
            'name' => (string)$name,
            'email' => 'valid@example.com'
        ]);
        $this->usersRepository->create($user);

    }

    /**
     * @dataProvider invalidEmailsProvider
     * @param $email
     * @throws Exception
     */
    public function testAddWithBadEmail($email)
    {
        $this->expectException(ValidationException::class);
        $user = new UserEntity([
            'name' => 'validname',
            'email' => (string)$email
        ]);
        $this->usersRepository->create($user);
    }

    /**
     * @throws ValidationException
     */
    public function testUpdateNameOfValidUser()
    {
        $name = 'updatedname';
        $user = $this->usersRepository->getById(1);
        $user->name = $name;
        $updated = $this->usersRepository->update(1, $user);
        $this->assertEquals($updated->name, $name);
    }

    /**
     * @throws ValidationException
     */
    public function testUpdateEmailOfValidUser()
    {
        $email = 'validEmail@eexample.com';
        $user = $this->usersRepository->getById(1);
        $user->email = $email;
        $updated = $this->usersRepository->update(1, $user);
        $this->assertEquals($updated->email, $email);
    }

    public function invalidNamesProvider(): array
    {
        return [
            [null],
            [false],
            [1234567],          // too short
            [''],               // empty
            ['short'],          // too short
            ['BadSymbols'],     // contain incorrect symbol
            ['bad_symbols'],    // contain incorrect symbol
            ['bad@symbols'],    // contain incorrect symbol
            ['disallowed'],     // disallowed
            ['wrongword'],      // disallowed
            ['testtest']        // non unique
        ];
    }

    public function invalidEmailsProvider(): array
    {
        return [
            [null],
            [false],
            [1234567],
            ['notemail'],
            ['@yandex'],
            ['русский@домен.рф'],
            ['test@'],
            ['example.com'],
            ['@example.com'],
            ['a@@example.com'],
            ['test@bad.com'],
            ['test@ignore.ru']
        ];
    }


}
