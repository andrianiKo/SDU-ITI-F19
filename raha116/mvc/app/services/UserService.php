<?php
declare(strict_types=1);

namespace services;

use Exception;
use models\User;
use models\UserResponse;
use repositories\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var SessionService
     */
    private $sessionService;

    public function __construct(UserRepository $userRepository, SessionService $sessionService)
    {
        $this->userRepository = $userRepository;
        $this->sessionService = $sessionService;
    }

    /**
     * Creates a new user
     *
     * @param string $username
     * @param string $password
     * @return null|string null if everything went okay, and error in a string otherwise
     * @throws Exception
     */
    public function create_user(string $username, string $password, string $firstname, string $lastname, string $city, string $zip, string $email, string $phone)
    {
        // Check if the user already exists
        $user = $this->userRepository->get_user($username);

        if ($user) {
            return "Username is already in use";
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $user = $this->userRepository->create_user($username, $hash, $firstname, $lastname, $city, $zip, $email, $phone);


        if ($user) {
            $this->sessionService->set_active_user_id($user->user_id);
            return null;
        }
        return null;
    }

    /**
     * Does a login for the given user/password combination
     *
     * If the login is successful, then the session is updated
     *
     * @param string $username
     * @param string $password
     * @return string|null
     */
    public function login(string $username, string $password)
    {
        /**
         * @var string|User
         */
        $result = $this->verify_login($username, $password);

        // Hackity hack hack
        if (is_string($result)) {
            return $result;
        }

        $this->sessionService->set_active_user_id($result->user_id);

        return null;
    }

    /**
     * Verifies the given username and password, but doesn't do anymore with it
     * Will return a User on success, and a string with an error on fail
     *
     * @param string $username
     * @param string $password
     * @return User|string|null
     */
    public function verify_login(string $username, string $password)
    {

        $user = $this->userRepository->get_user($username);

        if (!$user) {
            return "Login failed";
        }

        if (!password_verify($password, $user->password)) {
            return "Login failed";
        }

        return $user;
    }

    public function logout()
    {
        $this->sessionService->destroy_session();
    }

    public function is_logged_in(): bool
    {
        return !!$this->sessionService->get_active_user_id();
    }

    /**
     * Loads all the users available
     *
     * @return UserResponse[]
     */
    public function getUsers(): array
    {
        $users = $this->userRepository->getUsers();

        $response = array();

        foreach ($users as $user) {
            $response[] = new UserResponse($user->user_id, $user->username);
        }

        return $response;
    }
}