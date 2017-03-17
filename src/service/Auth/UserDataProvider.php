<?php

namespace Perfumerlabs\Start\Service\Auth;

use App\Model\Session;
use App\Model\SessionQuery;
use App\Model\UserQuery;
use Perfumer\Component\Auth\DataProvider\AbstractProvider;

class UserDataProvider extends AbstractProvider
{
    /**
     * @var int
     */
    protected $lifetime = 7 * 86400;

    /**
     * @param string $token
     * @return mixed
     */
    public function getData(string $token)
    {
        $session_entry = SessionQuery::create()->findOneByToken($token);

        if (!$session_entry) {
            return null;
        }

        if ($session_entry->getExpiredAt() !== null && $session_entry->getExpiredAt()->diff(new \DateTime())->invert == 0) {
            return null;
        }

        $user = UserQuery::create()->findPk($session_entry->getUserId());

        if (!$user) {
            return null;
        }

        $expired_at = (new \DateTime())->modify('+' . $this->lifetime . ' second');

        $session_entry->setExpiredAt($expired_at);
        $session_entry->save();

        return (string) $session_entry->getUserId();
    }

    /**
     * @param string $data
     * @return array
     */
    public function getTokens(string $data): array
    {
        return SessionQuery::create()
            ->select('Token')
            ->filterByUserId((int) $data)
            ->find()
            ->getData();
    }

    /**
     * @param string $token
     * @param string $data
     * @return bool
     */
    public function saveData(string $token, string $data): bool
    {
        $session_entry = new Session();
        $session_entry->setToken($token);
        $session_entry->setUserId((int) $data);

        $expired_at = (new \DateTime())->modify('+' . $this->lifetime . ' second');

        $session_entry->setExpiredAt($expired_at);

        return (bool) $session_entry->save();
    }

    /**
     * @param string $token
     * @return bool
     */
    public function deleteToken(string $token): bool
    {
        SessionQuery::create()
            ->filterByToken($token)
            ->delete();

        return true;
    }
}
