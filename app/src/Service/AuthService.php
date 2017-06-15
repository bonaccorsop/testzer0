<?php

namespace Test0\Service;

use stdClass;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Builder as JWTBuilder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

use Test0\Repository\UserRepository;
use Test0\Application\Exception\InvalidCredentialsException;
use Test0\Application\Exception\InvalidTokenException;
use Test0\Application\Exception\ExpiredTokenException;


class AuthService extends Service
{
    const DEFAULT_TTL = 3600;

    private $userRepository;
    private $ttl;
    private $hmacKey;

    /**
     * @param Logger $logger
     * @param PostRepository $postRepository
     * @return PostService
     */
    public function __construct($logger, UserRepository $userRepository, string $hmacKey, int $ttl = self::DEFAULT_TTL)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
        $this->hmacKey = $hmacKey;
        $this->ttl = $ttl;
    }

    /**
     * @param string $username
     * @param string $password
     * @throws InvalidCredentialsException
     * @return Token
     */
    public function authenticate(string $username, string $password) : Token
    {
        //resolve password
        $password = $this->encryptPassword($password);

        $user = $this->userRepository->findByCredentials($username, $password);

        if(empty($user)) {
            throw new InvalidCredentialsException("Invalid Credentials", 401);
        }

        $token = $this->generateJwt(['uid' => $user->id, 'username' => $user->email]);

        $this->userRepository->storeToken($user->id, (string) $token);

        return $token;
    }

    /**
     * @param string $token
     * @throws InvalidTokenException
     * @return stdClass
     */
    public function authorize(string $token) : stdClass
    {
        $user = $this->userRepository->findByToken($token);

        if(empty($user)) {
            throw new InvalidTokenException('Invalid Token', 401);
        }

        if(! $this->checkJwt($token, ['uid' => $user->id, 'username' => $user->email])) {
            $this->userRepository->storeToken($user->id, null);
            throw new ExpiredTokenException('Token Expired', 401);
        }

        return $user;
    }

    /**
     * @param string $token
     * @return bool
     */
    private function checkJwt(string $token, array $claimInfo) : bool
    {
        $data = new ValidationData();
        return (new Parser())->parse($token)->validate($data);
    }

    /**
     * @param array $claimInfo
     * @return Token
     */
    private function generateJwt(array $claimInfo) : Token
    {
        $token = (new JWTBuilder())
            ->setExpiration(time() + $this->ttl);

        foreach ($claimInfo as $key => $value) {
            $token->set($key, $value);
        }

        return $token->sign(new Sha256(), $this->hmacKey)->getToken();
    }

    /**
     * @param string $cleanPassword
     * @return string
     */
    private function encryptPassword(string $cleanPassword)
    {
        return sha1($cleanPassword);
    }
}