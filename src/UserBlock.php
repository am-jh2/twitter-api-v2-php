<?php

namespace Noweh\TwitterApi;

use Exception;

/**
 * Class User/Block Controller
 * @see <a href="https://developer.twitter.com/en/docs/twitter-api/users/blocks/api-reference/get-users-blocking">Blocks</a>
 * @author Martin Zeitler
 */
class UserBlock extends AbstractController {

    public const MODES = [
        'LOOKUP' => 'lookup',
        'BLOCK' => 'block',
        'UNBLOCK' => 'unblock'
    ];

    private mixed $idOrUsername;

    /**
     * @param array<int, string> $settings
     * @throws \Exception
     */
    public function __construct(array $settings)
    {
        parent::__construct($settings);

        if (!isset($settings['account_id'])) {
            throw new Exception('Incomplete settings passed. Expected "account_id"');
        }

        $this->setAuthMode(1);
        $this->setEndpoint('users/'.$this->account_id);
    }

    /**
     * Retrieve Endpoint value and rebuilt it with the expected parameters
     * @return string
     * @throws Exception
     */
    protected function constructEndpoint(): string {
        $endpoint = parent::constructEndpoint();
        if ($this->mode == self::MODES['LOOKUP']) {
            $endpoint .= '/blocking';
        }
        return $endpoint;
    }

    /**
     * Look up blocked users by username or ID.
     *
     * @param mixed $idOrUsername can be an array of items
     * @return UserBlock
     */
    public function lookup(mixed $idOrUsername): UserBlock
    {
        $this->mode = self::MODES['LOOKUP'];
        $this->idOrUsername = $idOrUsername;
        return $this;
    }

    /**
     * Block user by username or ID.
     *
     * @param mixed $idOrUsername can be an array of items
     * @return UserBlock
     */
    public function block(mixed $idOrUsername): UserBlock
    {
        $this->mode = self::MODES['BLOCK'];
        $this->idOrUsername = $idOrUsername;
        return $this;
    }

    /**
     * Unblock user by username or ID.
     *
     * @param mixed $idOrUsername can be an array of items
     * @return UserBlock
     */
    public function unblock(mixed $idOrUsername): UserBlock
    {
        $this->mode = self::MODES['UNBLOCK'];
        $this->idOrUsername = $idOrUsername;
        return $this;
    }
}
