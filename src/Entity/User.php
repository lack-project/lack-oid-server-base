<?php


namespace Lack\OidServer\Entity;


class User
{
    public function __construct(

        /**
         *
         */
        #[E]
        public string $uid,

        public string $user,

        public string $email,

        public bool $email_verified = false,

        public ?string $passwd_crypt = null,

        public ?string $birthdate = null,

        public ?string $picture = null,


    ){}
}
