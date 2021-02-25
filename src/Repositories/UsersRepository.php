<?php

namespace User\Repositories;

use Psr\Log\LoggerInterface;
use User\Storages\Storage;
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

    public function __construct(Storage $storage, LoggerInterface $logger)
    {
        parent::__construct($storage, $logger);
    }

    public function rules(): array
    {
        return [
            'name' => [
                new LengthValidator(['min' => 8, 'max' => 256]),
                new UniqueValidator(['fieldName' => 'name', 'storage' => $this->storage]),
                new RegexValidator(['regex' => RegexValidator::ALPHA_NUM]),
                new DisallowedWordsValidator(['words' => $this->disallowedNames])
            ],
            'email' => [
                new LengthValidator(),
                new EmailValidator(),
                new UniqueValidator(['fieldName' => 'email', 'storage' => $this->storage]),
                new DisallowedDomainsValidator(['domains' => $this->disallowedDomains])
            ],
        ];
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