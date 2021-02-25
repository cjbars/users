<?php

namespace User\Repositories;

use Exception;
use User\Entities\Entity;
use User\Entities\UserEntity;
use User\Validators\DisallowedDomainsValidator;
use User\Validators\DisallowedWordsValidator;
use User\Validators\EmailValidator;
use User\Validators\LengthValidator;
use User\Validators\RegexValidator;
use User\Validators\UniqueValidator;

/**
 * Class UsersRepository
 * @package User\Repositories
 */
class UsersRepository extends Repository
{
    private array $disallowedNames = [];

    private array $disallowedDomains = [];

    /**
     * @return array
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'name' => [
                new UniqueValidator(['fieldName' => 'name', 'storage' => $this->storage]),
                new LengthValidator(['min' => 8, 'max' => 256]),
                new RegexValidator(['regex' => RegexValidator::ALPHA_NUM]),
                new DisallowedWordsValidator(['words' => $this->disallowedNames])
            ],
            'email' => [
                new EmailValidator(),
                new UniqueValidator(['fieldName' => 'email', 'storage' => $this->storage]),
                new LengthValidator(),
                new DisallowedDomainsValidator(['domains' => $this->disallowedDomains])
            ]
        ];
    }


    public function getById($id): ?UserEntity
    {
        $data = $this->storage->getById($id);
        if($data){
            return new UserEntity($data);
        }
        return null;
    }

    /**
     * @param array $disallowedNames
     * @return UsersRepository
     */
    public function setDisallowedNames(array $disallowedNames): UsersRepository
    {
        $this->disallowedNames = $disallowedNames;
        return $this;
    }

    /**
     * @param array $disallowedDomains
     * @return UsersRepository
     */
    public function setDisallowedDomains(array $disallowedDomains): UsersRepository
    {
        $this->disallowedDomains = $disallowedDomains;
        return $this;
    }


}